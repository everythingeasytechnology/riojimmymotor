<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_dashboard_redirects_unauthenticated_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_returns_successful_response(): void
    {
        $this->seed();
        $admin = \App\Models\User::first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_admin_dashboard_shows_actual_seeded_statistics(): void
    {
        $this->seed();
        $admin = \App\Models\User::first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('stats', function ($stats) {
            return $stats['total_products'] === 5
                && $stats['total_categories'] === 18
                && $stats['total_orders'] === 2
                && $stats['total_users'] === 3;
        });
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Control Center');
    }

    public function test_login_authenticates_valid_user(): void
    {
        $this->seed();
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $this->seed();
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password-123'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout_invalidates_session(): void
    {
        $this->seed();
        $admin = \App\Models\User::first();

        $response = $this->actingAs($admin)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_homepage_shows_seeded_categories(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('categories', function ($categories) {
            return $categories->count() === 5;
        });
    }

    public function test_lead_inquiry_submission_stores_lead_successfully(): void
    {
        $response = $this->postJson('/inquiry', [
            'vehicle' => '2019 Ford F-150',
            'engine_size' => '5.0L V8',
            'phone' => '123-456-7890'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Quote request submitted successfully! A parts specialist will contact you shortly.'
        ]);

        $this->assertDatabaseHas('leads', [
            'year' => '2019',
            'make' => 'Ford',
            'model' => 'F-150',
            'phone' => '123-456-7890',
            'notes' => 'Engine Size: 5.0L V8'
        ]);
    }

    public function test_contact_form_submission_stores_lead_successfully(): void
    {
        $response = $this->postJson('/contact', [
            'name' => 'John Contact',
            'email' => 'john@contact.com',
            'phone' => '111-222-3333',
            'vin' => '12345678901234567',
            'year' => '2020',
            'make' => 'Honda',
            'model' => 'Civic',
            'part_requested' => 'Front Bumper',
            'notes' => 'Looking for red color bumper'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Your parts inquiry has been submitted successfully! An auto parts specialist will contact you shortly.'
        ]);

        $this->assertDatabaseHas('leads', [
            'name' => 'John Contact',
            'email' => 'john@contact.com',
            'phone' => '111-222-3333',
            'vin' => '12345678901234567',
            'year' => '2020',
            'make' => 'Honda',
            'model' => 'Civic',
            'part_requested' => 'Front Bumper',
            'notes' => 'Looking for red color bumper',
            'status' => 'new',
            'is_read' => false
        ]);
    }

    public function test_contact_form_submission_validation_rules(): void
    {
        // Missing required fields
        $response = $this->postJson('/contact', [
            'name' => '',
            'email' => 'invalid-email',
            'phone' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors']);
    }

    public function test_admin_can_view_leads_in_panel(): void
    {
        $this->seed();
        $admin = \App\Models\User::first();

        // Create a contact lead
        $lead = \App\Models\Lead::create([
            'name' => 'John Contact',
            'email' => 'john@contact.com',
            'phone' => '111-222-3333',
            'year' => '2020',
            'make' => 'Honda',
            'model' => 'Civic',
            'part_requested' => 'Front Bumper',
            'status' => 'new'
        ]);

        $response = $this->actingAs($admin)->get('/admin/leads');
        $response->assertStatus(200);
        $response->assertSee('John Contact');
        $response->assertSee('john@contact.com');
        $response->assertSee('Honda Civic');
        $response->assertSee('Front Bumper');
    }

    public function test_admin_can_mark_lead_as_read(): void
    {
        $this->seed();
        $admin = \App\Models\User::first();

        $lead = \App\Models\Lead::create([
            'name' => 'John Contact',
            'email' => 'john@contact.com',
            'phone' => '111-222-3333',
            'year' => '2020',
            'make' => 'Honda',
            'model' => 'Civic',
            'part_requested' => 'Front Bumper',
            'status' => 'new',
            'is_read' => false
        ]);

        $response = $this->actingAs($admin)->postJson("/admin/leads/{$lead->id}/read");
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $lead->refresh();
        $this->assertTrue($lead->is_read);
    }

    public function test_cart_page_loads_empty(): void
    {
        $response = $this->get('/cart');
        $response->assertStatus(200);
        $response->assertSee('Your cart is empty');
    }

    public function test_add_to_cart_adds_product_to_session(): void
    {
        $this->seed();
        $product = \App\Models\Product::first();

        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $response->assertRedirect();
        $this->assertNotNull(session('cart'));
        $this->assertArrayHasKey($product->id, session('cart'));
        $this->assertEquals(1, session('cart')[$product->id]['quantity']);
    }

    public function test_add_to_cart_validates_stock(): void
    {
        $this->seed();
        $product = \App\Models\Product::first();

        $response = $this->post('/cart/add', [
            'product_id' => $product->id,
            'quantity' => $product->stock + 1
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertNull(session('cart'));
    }

    public function test_update_cart_quantity(): void
    {
        $this->seed();
        $product = \App\Models\Product::first();

        // Put item in session cart first
        session(['cart' => [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => 'some-img.jpg',
                'quantity' => 1,
                'stock' => $product->stock
            ]
        ]]);

        $response = $this->post('/cart/update', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $response->assertRedirect();
        $this->assertEquals(2, session('cart')[$product->id]['quantity']);
    }

    public function test_remove_from_cart(): void
    {
        $this->seed();
        $product = \App\Models\Product::first();

        // Put item in session cart first
        session(['cart' => [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => 'some-img.jpg',
                'quantity' => 1,
                'stock' => $product->stock
            ]
        ]]);

        $response = $this->post('/cart/remove', [
            'product_id' => $product->id
        ]);

        $response->assertRedirect();
        $this->assertEmpty(session('cart'));
    }

    public function test_checkout_redirects_if_cart_empty(): void
    {
        $response = $this->get('/checkout');
        $response->assertRedirect('/cart');
    }

    public function test_checkout_page_loads_with_cart_items(): void
    {
        $this->seed();
        $product = \App\Models\Product::first();

        // Put item in session cart
        session(['cart' => [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => 'some-img.jpg',
                'quantity' => 1,
                'stock' => $product->stock
            ]
        ]]);

        $response = $this->get('/checkout');
        $response->assertStatus(200);
        $response->assertViewHas('cart');
    }

    public function test_buy_now_auto_adds_to_cart_and_redirects(): void
    {
        $this->seed();
        $product = \App\Models\Product::first();

        $response = $this->get('/checkout?product=' . $product->slug);

        $response->assertRedirect('/checkout');
        $this->assertNotNull(session('cart'));
        $this->assertArrayHasKey($product->id, session('cart'));
    }

    public function test_checkout_submission_creates_order_for_cart_items(): void
    {
        $this->seed();
        $product = \App\Models\Product::first();
        $initialStock = $product->stock;

        // Put item in session cart
        session(['cart' => [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => 'some-img.jpg',
                'quantity' => 1,
                'stock' => $product->stock
            ]
        ]]);

        $response = $this->post('/checkout', [
            'email' => 'customer@example.com',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'street_address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10001',
            'phone' => '555-555-5555',
            'payment_method' => 'stripe',
            'order_notes' => 'Leave near door'
        ]);

        $response->assertRedirect();
        $this->assertTrue(str_contains($response->headers->get('Location'), '/checkout/success'));

        // Extract order number from redirect URL
        $urlComponents = parse_url($response->headers->get('Location'));
        parse_str($urlComponents['query'], $queryParams);
        $orderNumber = $queryParams['order'] ?? null;

        $this->assertNotNull($orderNumber);

        // Assert database records
        $this->assertDatabaseHas('orders', [
            'order_number' => $orderNumber,
            'customer_email' => 'customer@example.com',
            'customer_phone' => '555-555-5555',
            'payment_method' => 'Stripe',
            'payment_status' => 'paid',
            'refund_reason' => 'Leave near door'
        ]);

        $order = \App\Models\Order::where('order_number', $orderNumber)->first();

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'quantity' => 1
        ]);

        // Assert stock decremented
        $product->refresh();
        $this->assertEquals($initialStock - 1, $product->stock);

        // Assert session cart is empty
        $this->assertNull(session('cart'));
    }

    public function test_admin_can_update_payment_settings(): void
    {
        $this->seed();
        $admin = \App\Models\User::first();

        $response = $this->actingAs($admin)->post('/admin/payments/update', [
            'stripe_enabled' => '1',
            'stripe_mode' => 'sandbox',
            'stripe_public_key' => 'pk_test_123',
            'stripe_secret_key' => 'sk_test_123',
            'stripe_webhook' => 'whsec_123',
            'razorpay_enabled' => '1',
            'razorpay_mode' => 'live',
            'razorpay_key_id' => 'rzp_test_123',
            'razorpay_key_secret' => 'rzp_secret_123',
        ]);

        $response->assertRedirect('/admin/payments');

        $this->assertEquals('1', \App\Models\Setting::getValue('payment_stripe_enabled'));
        $this->assertEquals('pk_test_123', \App\Models\Setting::getValue('payment_stripe_public'));
        $this->assertEquals('1', \App\Models\Setting::getValue('payment_razorpay_enabled'));
        $this->assertEquals('live', \App\Models\Setting::getValue('payment_razorpay_mode'));
        $this->assertEquals('0', \App\Models\Setting::getValue('payment_paypal_enabled'));
    }

    public function test_admin_can_update_seo_settings_and_they_are_dynamic_on_frontend(): void
    {
        $this->seed();
        $admin = \App\Models\User::first();

        // 1. Submit update request from SEO form
        $response = $this->actingAs($admin)->post('/admin/seo/update', [
            'meta_title' => 'Custom Meta Title Rio',
            'meta_description' => 'Custom Meta Description Rio',
            'canonical_url' => 'https://riojimmymotor.custom.com',
            'robots_meta' => 'noindex, follow',
            'schema_organization' => '{"@context":"https://schema.org","@type":"Organization","name":"CustomOrg"}',
            'schema_local_business' => '{"@context":"https://schema.org","@type":"LocalBusiness","name":"CustomBiz"}',
        ]);

        $response->assertRedirect('/admin/seo');

        // 2. Fetch the home page and verify the updated SEO parameters are output dynamically
        $frontendResponse = $this->get('/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertSee('Custom Meta Title Rio');
        $frontendResponse->assertSee('Custom Meta Description Rio');
        $frontendResponse->assertSee('https://riojimmymotor.custom.com');
        $frontendResponse->assertSee('noindex, follow');
        $frontendResponse->assertSee('{"@context":"https://schema.org","@type":"Organization","name":"CustomOrg"}', false);
        $frontendResponse->assertSee('{"@context":"https://schema.org","@type":"LocalBusiness","name":"CustomBiz"}', false);
    }
}

