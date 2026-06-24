<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display gateways settings dashboard.
     */
    public function index()
    {
        $gateways = [
            'stripe' => [
                'enabled' => Setting::getValue('payment_stripe_enabled', '0'),
                'public_key' => Setting::getValue('payment_stripe_public', ''),
                'secret_key' => Setting::getValue('payment_stripe_secret', ''),
                'mode' => Setting::getValue('payment_stripe_mode', 'sandbox'),
                'webhook' => Setting::getValue('payment_stripe_webhook', '')
            ],
            'razorpay' => [
                'enabled' => Setting::getValue('payment_razorpay_enabled', '0'),
                'key_id' => Setting::getValue('payment_razorpay_key', ''),
                'key_secret' => Setting::getValue('payment_razorpay_secret', ''),
                'mode' => Setting::getValue('payment_razorpay_mode', 'sandbox')
            ]
        ];

        return view('admin.payments.index', compact('gateways'));
    }

    /**
     * Update gateway configurations in settings.
     */
    public function update(Request $request)
    {
        // 1. Stripe config
        Setting::setValue('payment_stripe_enabled', $request->has('stripe_enabled') ? '1' : '0');
        Setting::setValue('payment_stripe_public', $request->stripe_public_key);
        Setting::setValue('payment_stripe_secret', $request->stripe_secret_key);
        Setting::setValue('payment_stripe_mode', $request->stripe_mode);
        Setting::setValue('payment_stripe_webhook', $request->stripe_webhook);

        // Force disable PayPal
        Setting::setValue('payment_paypal_enabled', '0');

        // 2. Razorpay config
        Setting::setValue('payment_razorpay_enabled', $request->has('razorpay_enabled') ? '1' : '0');
        Setting::setValue('payment_razorpay_key', $request->razorpay_key_id);
        Setting::setValue('payment_razorpay_secret', $request->razorpay_key_secret);
        Setting::setValue('payment_razorpay_mode', $request->razorpay_mode);

        return redirect()->route('admin.payments.index')->with('success', 'Payment gateway configurations saved.');
    }
}
