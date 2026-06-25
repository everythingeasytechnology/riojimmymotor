<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Lead;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Permissions
        $permissionsList = [
            'manage-users' => 'Manage system users and access levels.',
            'manage-roles' => 'Manage user roles and authorization permissions.',
            'manage-products' => 'Create, edit, and delete parts catalog items.',
            'manage-categories' => 'Manage category hierarchy and structures.',
            'manage-orders' => 'View, update, and manage customer orders.',
            'manage-payments' => 'Configure and manage payment gateway API settings.',
            'manage-blogs' => 'Compose, edit, and publish blogs/articles.',
            'manage-seo' => 'Manage site SEO configurations, canonical tags, and schema scripts.',
            'manage-settings' => 'Manage global site variables, SMTP settings, and logo options.',
            'manage-forms' => 'Manage lead captures and contact submissions.',
            'manage-media' => 'Manage general uploaded catalog media files.'
        ];

        $seededPermissions = [];
        foreach ($permissionsList as $slug => $desc) {
            $seededPermissions[$slug] = Permission::create([
                'name' => ucwords(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'description' => $desc
            ]);
        }

        // 2. Seed Roles
        $rolesList = [
            'super-admin' => 'Super Administrator with full master access.',
            'admin' => 'Administrator for day to day operations.',
            'seo-manager' => 'Manages meta tags, keywords, sitemaps, and scripts.',
            'content-manager' => 'Manages blog posts, articles, and FAQs.',
            'product-manager' => 'Manages parts inventory, OEM details, and pricing.',
            'customer-support' => 'Manages customer orders, refunds, and contact leads.'
        ];

        $seededRoles = [];
        foreach ($rolesList as $slug => $desc) {
            $seededRoles[$slug] = Role::create([
                'name' => ucwords(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'description' => $desc
            ]);
        }

        // 3. Associate Permissions to Roles
        // Super Admin gets all permissions
        $seededRoles['super-admin']->permissions()->attach(Permission::all()->pluck('id')->toArray());

        // Admin gets most permissions (except user/role management)
        $adminPermissions = Permission::whereNotIn('slug', ['manage-users', 'manage-roles'])->pluck('id')->toArray();
        $seededRoles['admin']->permissions()->attach($adminPermissions);

        // SEO Manager gets manage-seo, manage-settings, manage-blogs
        $seoPermissions = Permission::whereIn('slug', ['manage-seo', 'manage-settings', 'manage-blogs'])->pluck('id')->toArray();
        $seededRoles['seo-manager']->permissions()->attach($seoPermissions);

        // Content Manager gets manage-blogs, manage-media
        $contentPermissions = Permission::whereIn('slug', ['manage-blogs', 'manage-media'])->pluck('id')->toArray();
        $seededRoles['content-manager']->permissions()->attach($contentPermissions);

        // Product Manager gets manage-products, manage-categories, manage-media
        $productPermissions = Permission::whereIn('slug', ['manage-products', 'manage-categories', 'manage-media'])->pluck('id')->toArray();
        $seededRoles['product-manager']->permissions()->attach($productPermissions);

        // Customer Support gets manage-orders, manage-forms
        $supportPermissions = Permission::whereIn('slug', ['manage-orders', 'manage-forms'])->pluck('id')->toArray();
        $seededRoles['customer-support']->permissions()->attach($supportPermissions);

        // 4. Seed Users and attach Roles
        $superAdminUser = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdminUser->roles()->attach($seededRoles['super-admin']->id);

        $supportUser = User::create([
            'name' => 'John Doe (Support)',
            'email' => 'support@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $supportUser->roles()->attach($seededRoles['customer-support']->id);

        $seoUser = User::create([
            'name' => 'Jane Smith (SEO)',
            'email' => 'seo@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $seoUser->roles()->attach($seededRoles['seo-manager']->id);

        // 5. Seed Site Settings
        $defaultSettings = [
            'site_name' => 'Rio Jimmy Motor',
            'contact_phone' => '+1 (800) 555-0199',
            'contact_email' => 'support@riojimmymotor.com',
            'office_address' => '100 Industrial Pkwy, Detroit, MI 48201',
            'business_hours' => 'Mon - Sat: 8:00 AM - 6:00 PM EST',
            'google_analytics_id' => 'G-TRACK12345',
            'clarity_project_id' => 'clarity9876',
            'facebook_pixel_id' => 'fbpx112233',
            'custom_header_scripts' => '<!-- Default Header Custom Scripts -->',
            'custom_footer_scripts' => '<!-- Default Footer Custom Scripts -->'
        ];
        foreach ($defaultSettings as $key => $value) {
            Setting::setValue($key, $value);
        }

        // 6. Seed Categories
        $categoriesList = [
            'Used Engines' => [
                'slug' => 'engines',
                'desc' => 'Tested and certified pre-owned complete engine assemblies.',
                'seo_title' => 'Used OEM Engines for Sale | High Quality Tested Motors',
                'sub' => ['V6 Engines', 'V8 Engines', '4-Cylinder Engines']
            ],
            'Used Transmissions' => [
                'slug' => 'transmissions',
                'desc' => 'High quality automatic and manual gearboxes for all makes and models.',
                'seo_title' => 'Used Transmissions for Sale | OEM Automatic & Manual Transmissions',
                'sub' => ['Automatic Transmissions', 'Manual Transmissions']
            ],
            'OEM Wheels & Rims' => [
                'slug' => 'wheels',
                'desc' => 'Factory original alloy wheels, steel wheels, and matching center caps.',
                'seo_title' => 'Factory OEM Wheels & Rims for Sale | Original Steel & Alloy Wheels',
                'sub' => ['Alloy Wheels', 'Steel Rims']
            ],
            'Headlights & Lighting' => [
                'slug' => 'lights',
                'desc' => 'Certified OEM headlight assembly modules, tail lights, and fog lamps.',
                'seo_title' => 'OEM Headlights & Lighting Assemblies | Used Tail Lights',
                'sub' => ['LED Headlights', 'Halogen Headlights', 'Tail Light Assemblies']
            ],
            'Body Panels & Bumpers' => [
                'slug' => 'body-parts',
                'desc' => 'Bumper covers, fenders, hoods, side mirrors, and recycled doors.',
                'seo_title' => 'Used OEM Body Panels, Bumpers & Fenders | Auto Body Parts',
                'sub' => ['Bumper Covers', 'Hoods & Fenders', 'Side Mirrors']
            ]
        ];

        foreach ($categoriesList as $name => $info) {
            $cat = Category::create([
                'name' => $name,
                'slug' => $info['slug'],
                'description' => $info['desc'],
                'meta_title' => $info['seo_title'],
                'meta_description' => 'Get certified grade A pre-tested ' . strtolower($name) . '. Free shipping included across USA.',
                'canonical_url' => url('/parts?category=' . $info['slug'])
            ]);

            foreach ($info['sub'] as $subName) {
                Category::create([
                    'name' => $subName,
                    'slug' => Str::slug($subName),
                    'parent_id' => $cat->id,
                    'description' => $subName . ' category.',
                    'meta_title' => $subName . ' | Rio Jimmy Motor'
                ]);
            }
        }

        // 7. Seed Products
        $catEngines = Category::where('slug', 'engines')->first()->id;
        $catTrans = Category::where('slug', 'transmissions')->first()->id;
        $catWheels = Category::where('slug', 'wheels')->first()->id;
        $catLights = Category::where('slug', 'lights')->first()->id;

        $productsData = [
            [
                'name' => '2.5L DOHC 4-Cylinder Engine Assembly',
                'sku' => 'ENG-CAM-2018-25L',
                'category_id' => $catEngines,
                'brand' => 'Toyota',
                'condition' => 'Used',
                'price' => 1450.00,
                'sale_price' => 1250.00,
                'stock' => 2,
                'description' => 'Tested Grade A Used 2.5L DOHC 4-Cylinder Engine Assembly from a 2018 Toyota Camry. Includes intake manifold, fuel injectors, and coil packs. Compression tested and verified (185 PSI across all cylinders). 90-Day Money-Back Warranty.',
                'specifications' => [
                    'Mileage' => '48,150 Miles',
                    'Engine Size' => '2.5L',
                    'Cylinders' => '4 Cylinders',
                    'Block Type' => 'Aluminum DOHC',
                    'Fuel Type' => 'Gasoline',
                    'Warranty' => '90-Day Parts Only'
                ],
                'compatibility' => [
                    ['year' => '2018', 'make' => 'Toyota', 'model' => 'Camry'],
                    ['year' => '2019', 'make' => 'Toyota', 'model' => 'Camry'],
                    ['year' => '2020', 'make' => 'Toyota', 'model' => 'Camry FWD']
                ],
                'warranty' => '90-Day Parts Warranty',
                'images' => ['https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=600&auto=format&fit=crop'],
                'is_featured' => true,
                'meta_title' => '2018 Toyota Camry 2.5L Engine Assembly for Sale | OEM Recycled',
                'meta_description' => 'Buy certified 2018 Toyota Camry 2.5L engine assembly with 48k miles. Free freight shipping, tested and backed by a 90-day warranty.'
            ],
            [
                'name' => '3.5L V6 Dual VVT-i Engine Assembly',
                'sku' => 'ENG-HIG-2017-35L',
                'category_id' => $catEngines,
                'brand' => 'Toyota',
                'condition' => 'Used',
                'price' => 2100.00,
                'sale_price' => 1950.00,
                'stock' => 1,
                'description' => 'Premium Recycled 3.5L V6 Engine Assembly. Grade A tested, no leaks, fully cleaned and prepped. Free nationwide terminal delivery or residential tailgate drop (fees apply). 180-Day warranty included.',
                'specifications' => [
                    'Mileage' => '61,000 Miles',
                    'Engine Size' => '3.5L V6',
                    'Cylinders' => '6 Cylinders',
                    'Block Type' => 'DOHC 24V',
                    'Warranty' => '180-Day Parts Only'
                ],
                'compatibility' => [
                    ['year' => '2017', 'make' => 'Toyota', 'model' => 'Camry / Highlander'],
                    ['year' => '2018', 'make' => 'Toyota', 'model' => 'Camry / Highlander'],
                    ['year' => '2019', 'make' => 'Toyota', 'model' => 'Highlander / Avalon']
                ],
                'warranty' => '180-Day Parts Warranty',
                'images' => ['https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=600&auto=format&fit=crop'],
                'is_featured' => true,
                'meta_title' => 'Toyota 3.5L V6 Engine Assembly (2017-2020) for Sale | Grade A',
                'meta_description' => 'Grade A certified used Toyota 3.5L V6 engine assembly. Fits Camry, Highlander, Avalon (2017-2020). 61k miles, certified compression. Get free quote.'
            ],
            [
                'name' => '8-Speed Automatic Transmission FWD',
                'sku' => 'TRA-CAM-2019-8SPD',
                'category_id' => $catTrans,
                'brand' => 'Toyota',
                'condition' => 'Used',
                'price' => 1150.00,
                'sale_price' => 1050.00,
                'stock' => 1,
                'description' => 'OEM FWD 8-Speed Automatic Transmission Assembly. Fluid drained and checked for metal residue (completely clean). Shift solenoids tested and verified.',
                'specifications' => [
                    'Mileage' => '51,300 Miles',
                    'Transmission Type' => 'Automatic FWD',
                    'Speeds' => '8 Speeds',
                    'Warranty' => '90-Day Parts Only'
                ],
                'compatibility' => [
                    ['year' => '2018', 'make' => 'Toyota', 'model' => 'Camry 2.5L FWD'],
                    ['year' => '2019', 'make' => 'Toyota', 'model' => 'Camry 2.5L FWD'],
                    ['year' => '2020', 'make' => 'Toyota', 'model' => 'RAV4 2.5L FWD']
                ],
                'warranty' => '90-Day Parts Warranty',
                'images' => ['https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=600&auto=format&fit=crop'],
                'is_featured' => false,
                'meta_title' => '2018-2021 Toyota Camry 8-Speed Automatic Transmission | OEM',
                'meta_description' => 'OEM pre-tested 8-speed automatic transmission for 2018-2021 Toyota Camry 2.5L models. 51k miles, warrantied, free fast shipping.'
            ],
            [
                'name' => '18" Factory OEM Alloy Wheel Rim',
                'sku' => 'WHL-CAM-2022-18A',
                'category_id' => $catWheels,
                'brand' => 'Toyota',
                'condition' => 'OEM Takeoff',
                'price' => 185.00,
                'sale_price' => null,
                'stock' => 4,
                'description' => 'Original factory 18-inch alloy wheel rim takeoff. Straight tested, zero cracks, clean face with minor hairline scratches. Standard 5x114.3 bolt pattern.',
                'specifications' => [
                    'Wheel Diameter' => '18 Inch',
                    'Bolt Pattern' => '5 x 114.3 mm',
                    'Material' => 'Alloy Aluminum',
                    'Finish' => 'Machine Charcoal Tint'
                ],
                'compatibility' => [
                    ['year' => '2021', 'make' => 'Toyota', 'model' => 'Camry SE'],
                    ['year' => '2022', 'make' => 'Toyota', 'model' => 'Camry SE'],
                    ['year' => '2023', 'make' => 'Toyota', 'model' => 'Camry SE / XSE']
                ],
                'warranty' => '30-Day Money Back Guarantee',
                'images' => ['https://images.unsplash.com/photo-1549399542-7e3f8b79c341?q=80&w=600&auto=format&fit=crop'],
                'is_featured' => false,
                'meta_title' => '18 Inch OEM Alloy Wheel Rim for 2021-2023 Toyota Camry SE',
                'meta_description' => 'Looking for replacement 18" alloy wheels? Original factory takeoff wheel rim for Toyota Camry SE. Free shipping, tested straight.'
            ],
            [
                'name' => 'LED Passenger Headlight Assembly',
                'sku' => 'LGT-RAV-2020-LEDR',
                'category_id' => $catLights,
                'brand' => 'Toyota',
                'condition' => 'Used',
                'price' => 280.00,
                'sale_price' => 250.00,
                'stock' => 1,
                'description' => 'Recycled OEM passenger side (right hand side) LED headlight module. Outer lens is clear and polished, housing tabs are intact, complete wiring harness plugs in.',
                'specifications' => [
                    'Side' => 'Passenger / Right Side',
                    'Bulb Type' => 'LED Module',
                    'OEM Part Number' => '81110-0R080',
                    'Lens Quality' => 'Grade A (Polished)'
                ],
                'compatibility' => [
                    ['year' => '2019', 'make' => 'Toyota', 'model' => 'RAV4 (LE/XLE/Limited)'],
                    ['year' => '2020', 'make' => 'Toyota', 'model' => 'RAV4 (LE/XLE/Limited)'],
                    ['year' => '2021', 'make' => 'Toyota', 'model' => 'RAV4 (LE/XLE/Limited)']
                ],
                'warranty' => '30-Day Exchange',
                'images' => ['https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=600&auto=format&fit=crop'],
                'is_featured' => false,
                'meta_title' => '2019-2021 Toyota RAV4 Passenger LED Headlight Assembly | OEM',
                'meta_description' => 'Shop replacement passenger-side LED headlight assembly for 2019-2021 Toyota RAV4. OEM part 81110-0R080. Free shipping.'
            ]
        ];

        foreach ($productsData as $productData) {
            $productData['slug'] = Str::slug($productData['name']);
            Product::create($productData);
        }

        // 8. Seed Blogs
        $blogsData = [
            [
                'title' => '5 Key Checks When Buying a Used Engine Online',
                'summary' => 'Avoid costly repair scams by following our checklist to verify used engine mileage, compression scores, oil condition, and warranties.',
                'content' => '<h4>Introduction to Buying Used Motors</h4><p>Buying a recycled engine is a highly effective way to save thousands of dollars on replacement parts. However, buying without knowing the right details can lead to buying salvage junk. Here is our 5-step checklist:</p><ol><li><strong>Verify Mileage Documentation:</strong> Always ask for visual odometer readouts or a VIN check.</li><li><strong>Ask for Compression Tests:</strong> Healthy cylinder pressure indicates long engine life.</li><li><strong>Verify oil fill condition:</strong> Dark carbon or milky cream is a sign of engine neglect or head gasket failures.</li><li><strong>Confirm Part Compatibility:</strong> Check your specific make, year, model, and engine digit code.</li><li><strong>Review the Warranty terms:</strong> Never buy an engine without at least a 30 to 90-day exchange warranty.</li></ol>',
                'image' => 'https://images.unsplash.com/photo-1517524206127-48bbd363f3d7?q=80&w=600&auto=format&fit=crop',
                'category' => 'Buying Guides',
                'tags' => ['engine', 'used parts', 'buying guide', 'mechanic tips'],
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'author_id' => $superAdminUser->id,
                'meta_title' => 'Used Engine Checklist: 5 Things to Inspect Before Purchasing Online',
                'meta_description' => 'Save money and avoid lemons. Learn the five crucial inspection parameters (mileage checks, compression test values) for used engines.',
                'faq_schema' => [
                    ['question' => 'How can I verify the mileage of a used engine?', 'answer' => 'Ensure the supplier provides the donor vehicle VIN number, enabling you to check historical database entries via Carfax or AutoCheck.'],
                    ['question' => 'What is a good cylinder compression score?', 'answer' => 'Cylinder compression should be even across all cylinders, typically above 150 PSI for standard gasoline passenger cars, with less than a 10% variance.']
                ]
            ],
            [
                'title' => 'The Ultimate Guide to Automatic Transmission Swaps',
                'summary' => 'Learn how to handle automatic transmission diagnostics, fluid prep, and gear torque conversions for domestic and import vehicles.',
                'content' => '<h4>Understanding Transmission Conversions</h4><p>Swapping out a blown automatic transmission requires attention to detail. This guide covers solenoid prep, mounting alignment, torque converter seating, and transmission fluid flushing to secure your newly swapped gear assembly.</p>',
                'image' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=600&auto=format&fit=crop',
                'category' => 'Technical Tips',
                'tags' => ['transmission', 'diy swap', 'repair tips'],
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'author_id' => $superAdminUser->id,
                'meta_title' => 'How to Swap an Automatic Transmission Assembly | Step-by-Step',
                'meta_description' => 'A comprehensive guide on removing, aligning, and testing replacement automatic gearboxes for passenger cars and SUVs.'
            ]
        ];

        foreach ($blogsData as $blogData) {
            $blogData['slug'] = Str::slug($blogData['title']);
            Blog::create($blogData);
        }

        // 9. Seed Orders & Order Items
        $p1 = Product::where('sku', 'ENG-CAM-2018-25L')->first();
        $p2 = Product::where('sku', 'LGT-RAV-2020-LEDR')->first();

        // Order 1: Completed Engine order
        $order1 = Order::create([
            'order_number' => 'ORD-10001',
            'user_id' => null,
            'customer_name' => 'Robert Johnson',
            'customer_email' => 'robert.j@gmail.com',
            'customer_phone' => '313-555-0144',
            'billing_address' => '456 Grand River Ave, Detroit, MI 48201',
            'shipping_address' => '456 Grand River Ave, Detroit, MI 48201',
            'subtotal' => 1450.00,
            'shipping_cost' => 0.00,
            'tax' => 87.00,
            'total' => 1537.00,
            'status' => 'delivered',
            'payment_method' => 'Stripe',
            'payment_status' => 'paid',
            'transaction_id' => 'ch_1MabcDeFg12345',
            'tracking_number' => 'EST-987654321-US'
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $p1->id,
            'product_name' => $p1->name,
            'product_sku' => $p1->sku,
            'price' => 1450.00,
            'quantity' => 1
        ]);

        // Order 2: Processing Lighting order
        $order2 = Order::create([
            'order_number' => 'ORD-10002',
            'user_id' => null,
            'customer_name' => 'Emily Watson',
            'customer_email' => 'emily.watson@yahoo.com',
            'customer_phone' => '650-555-8812',
            'billing_address' => '102 El Camino Real, San Mateo, CA 94402',
            'shipping_address' => '102 El Camino Real, San Mateo, CA 94402',
            'subtotal' => 280.00,
            'shipping_cost' => 15.00,
            'tax' => 24.50,
            'total' => 319.50,
            'status' => 'processing',
            'payment_method' => 'PayPal',
            'payment_status' => 'paid',
            'transaction_id' => 'PAY-8X723654AH0981'
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $p2->id,
            'product_name' => $p2->name,
            'product_sku' => $p2->sku,
            'price' => 280.00,
            'quantity' => 1
        ]);

        // 10. Seed Contact Leads
        Lead::create([
            'name' => 'Marcus Vance',
            'email' => 'marcus.v@outlook.com',
            'phone' => '214-555-8022',
            'vin' => '1T1NK20D4H019842',
            'year' => '2019',
            'make' => 'Toyota',
            'model' => 'RAV4',
            'part_requested' => 'Passenger Side Rear Door Assembly',
            'notes' => 'Looking for paint code 070 Blizzard Pearl. Please let me know price including freight delivery to Dallas, TX.',
            'status' => 'new',
            'is_read' => false
        ]);

        Lead::create([
            'name' => 'Sarah Connor',
            'email' => 'sconnor@skynet.net',
            'phone' => '213-555-9000',
            'vin' => null,
            'year' => '2016',
            'make' => 'Ford',
            'model' => 'Mustang GT',
            'part_requested' => '6-Speed Manual Transmission',
            'notes' => 'Looking for MT82 manual transmission for Mustang V8. Prefer mileage under 60k.',
            'status' => 'contact_attempted',
            'assigned_to' => $supportUser->id,
            'is_read' => true
        ]);
    }
}
