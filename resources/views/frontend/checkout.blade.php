@extends('frontend.layouts.master')

@section('meta_title', 'Checkout | Rio Jimmy Motor')
@section('meta_description', 'Complete your order for premium certified auto parts. Secure checkout with flexible payment methods.')

@section('content')
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/parts') }}">Auto Parts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5 font-poppins">
    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="row g-5">
            <!-- Left Column: Billing Details -->
            <div class="col-lg-7">
                <h3 class="fw-bold text-dark mb-4 pb-2 border-bottom">BILLING DETAILS</h3>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="fw-bold"><i class="fa fa-triangle-exclamation me-2"></i>Please check the following errors:</h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="fw-bold"><i class="fa fa-triangle-exclamation me-2"></i>Error:</h6>
                        <p class="mb-0">{{ session('error') }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-3">
                    <!-- Email address -->
                    <div class="col-12">
                        <label for="email" class="form-label fw-semibold text-dark">Email address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control py-2.5 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- First name & Last name -->
                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-semibold text-dark">First name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control py-2.5 @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label fw-semibold text-dark">Last name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control py-2.5 @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Company name -->
                    <div class="col-12">
                        <label for="company_name" class="form-label fw-semibold text-dark">Company name (optional)</label>
                        <input type="text" class="form-control py-2.5" id="company_name" name="company_name" value="{{ old('company_name') }}">
                    </div>

                    <!-- Country / Region -->
                    <div class="col-12">
                        <label for="country" class="form-label fw-semibold text-dark">Country / Region <span class="text-danger">*</span></label>
                        <select class="form-select py-2.5" id="country" name="country" disabled style="background-color: #f8f9fa;">
                            <option value="US" selected>United States (US)</option>
                        </select>
                    </div>

                    <!-- Street address -->
                    <div class="col-12">
                        <label for="street_address" class="form-label fw-semibold text-dark">Street address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control py-2.5 mb-2 @error('street_address') is-invalid @enderror" id="street_address" name="street_address" placeholder="House number and street name" value="{{ old('street_address') }}" required>
                        @error('street_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input type="text" class="form-control py-2.5" id="street_address_2" name="street_address_2" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('street_address_2') }}">
                    </div>

                    <!-- Town / City -->
                    <div class="col-12">
                        <label for="city" class="form-label fw-semibold text-dark">Town / City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control py-2.5 @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- State -->
                    <div class="col-12">
                        <label for="state" class="form-label fw-semibold text-dark">State <span class="text-danger">*</span></label>
                        <select class="form-select py-2.5 @error('state') is-invalid @enderror" id="state" name="state" required>
                            <option value="" disabled selected>Select a state...</option>
                            @php
                                $states = [
                                    'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California',
                                    'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District of Columbia',
                                    'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois',
                                    'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana',
                                    'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota',
                                    'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
                                    'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
                                    'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon',
                                    'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota',
                                    'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia',
                                    'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
                                ];
                            @endphp
                            @foreach ($states as $code => $name)
                                <option value="{{ $code }}" {{ old('state') == $code || (old('state') == '' && $code == 'NY') ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ZIP Code -->
                    <div class="col-12">
                        <label for="zip_code" class="form-label fw-semibold text-dark">ZIP Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control py-2.5 @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                        @error('zip_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-12">
                        <label for="phone" class="form-label fw-semibold text-dark">Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control py-2.5 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Checkbox options -->
                    <div class="col-12 mt-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="create_account" name="create_account" value="1">
                            <label class="form-check-label text-muted" for="create_account">
                                Create an account?
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <h3 class="fw-bold text-dark mt-5 mb-4 pb-2 border-bottom">ADDITIONAL INFORMATION</h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="order_notes" class="form-label fw-semibold text-dark">Order notes (optional)</label>
                        <textarea class="form-control" id="order_notes" name="order_notes" rows="4" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('order_notes') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Details -->
            <div class="col-lg-5">
                <div class="order-summary-card p-4 rounded shadow-sm" style="background-color: #f8f9fa; border: 1px solid #e9ecef; position: sticky; top: 100px;">
                    <h3 class="fw-bold text-center text-dark mb-4 tracking-wide">YOUR ORDER</h3>

                    <!-- Order Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless align-middle mb-0">
                            <thead>
                                <tr class="border-bottom text-muted" style="font-size: 14px;">
                                    <th class="ps-0 pb-3" style="width: 65%;">PRODUCT</th>
                                    <th class="pe-0 text-end pb-3">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $item)
                                    <tr class="border-bottom">
                                        <td class="ps-0 py-3 text-dark fw-medium small">
                                            {{ $item['name'] }} <strong class="text-muted">× {{ $item['quantity'] }}</strong>
                                        </td>
                                        <td class="pe-0 text-end py-3 text-dark fw-semibold">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="border-bottom">
                                    <td class="ps-0 py-3 text-muted fw-semibold">Subtotal</td>
                                    <td class="pe-0 text-end py-3 fw-bold text-danger">
                                        ${{ number_format($subtotal, 2) }}
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="ps-0 py-3 text-muted fw-bold">Total</td>
                                    <td class="pe-0 text-end py-3 fw-bold text-danger" style="font-size: 22px;">
                                        ${{ number_format($total, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Options -->
                    <div class="payment-methods-block mt-4 mb-4">
                        <!-- Razorpay Card Payment Option -->
                        @if($siteSettings->get('payment_razorpay_enabled', '0') === '1')
                        <div class="form-check mb-3">
                            <input class="form-check-input payment-radio" type="radio" name="payment_method" id="payment_razorpay" value="razorpay">
                            <label class="form-check-label fw-bold text-dark d-flex align-items-center flex-wrap" for="payment_razorpay" style="cursor: pointer;">
                                Credit Card/Debit Card/NetBanking 
                                <span class="ms-2 d-inline-flex align-items-center">
                                    <img src="https://razorpay.com/favicon.png" alt="Razorpay Logo" style="height: 16px; margin-right: 4px;"> 
                                    <strong style="color: #0b2265; font-size: 13px;">Pay by Razorpay</strong>
                                </span>
                            </label>
                            
                            <!-- Razorpay Info Box -->
                            <div class="mt-2 p-3 bg-white rounded border text-muted small d-none" id="razorpay-info-box">
                                <i class="fa fa-shield-halved text-success me-1"></i> Pay securely using Razorpay gateway. Supports all major cards and banking channels.
                            </div>
                        </div>
                        @endif

                        <!-- Stripe Card Payment Option -->
                        @if($siteSettings->get('payment_stripe_enabled', '0') === '1')
                        <div class="form-check mb-3 pt-2 border-top">
                            <input class="form-check-input payment-radio" type="radio" name="payment_method" id="payment_stripe" value="stripe">
                            <label class="form-check-label fw-bold text-dark d-flex align-items-center flex-wrap" for="payment_stripe" style="cursor: pointer;">
                                Credit/Debit Card (Stripe)
                                <span class="ms-2 d-inline-flex align-items-center">
                                    <i class="fab fa-cc-stripe fs-4 text-primary"></i>
                                </span>
                            </label>
                            
                            <!-- Stripe Info Box -->
                            <div class="mt-2 p-3 bg-white rounded border text-muted small d-none" id="stripe-info-box">
                                <i class="fa fa-shield-halved text-success me-1"></i> Pay securely with your credit/debit card via Stripe.
                            </div>
                        </div>
                        @endif

                        <!-- PayPal Payment Option -->
                        @if($siteSettings->get('payment_paypal_enabled', '0') === '1')
                        <div class="form-check mb-3 pt-2 border-top">
                            <input class="form-check-input payment-radio" type="radio" name="payment_method" id="payment_paypal" value="paypal">
                            <label class="form-check-label fw-bold text-dark d-flex align-items-center flex-wrap" for="payment_paypal" style="cursor: pointer;">
                                PayPal
                                <span class="ms-2 d-inline-flex align-items-center">
                                    <i class="fab fa-cc-paypal fs-4" style="color: #003087;"></i>
                                </span>
                            </label>
                            
                            <!-- PayPal Info Box -->
                            <div class="mt-2 p-3 bg-white rounded border text-muted small d-none" id="paypal-info-box">
                                <i class="fa fa-shield-halved text-success me-1"></i> Pay securely using PayPal wallet.
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Privacy and Consent -->
                    <div class="disclaimer-text text-muted small mb-4 lh-base">
                        Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="#" class="text-danger fw-semibold">privacy policy</a>.
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="subscribe_newsletter" name="subscribe_newsletter" value="1" checked>
                        <label class="form-check-label text-muted small" for="subscribe_newsletter">
                            Subscribe to our Newsletter
                        </label>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" class="btn btn-danger w-100 py-3 text-uppercase font-poppins fw-bold text-white shadow" style="background-color: #D91E18; border: none; letter-spacing: 1px; border-radius: 4px; font-size: 16px; transition: background-color 0.2s;">
                        PLACE ORDER
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentRadios = document.querySelectorAll('.payment-radio');
        const razorpayInfoBox = document.getElementById('razorpay-info-box');
        const stripeInfoBox = document.getElementById('stripe-info-box');
        const paypalInfoBox = document.getElementById('paypal-info-box');

        function toggleInfoBoxes() {
            if (razorpayInfoBox) razorpayInfoBox.classList.add('d-none');
            if (stripeInfoBox) stripeInfoBox.classList.add('d-none');
            if (paypalInfoBox) paypalInfoBox.classList.add('d-none');

            const checkedRadio = document.querySelector('.payment-radio:checked');
            if (checkedRadio) {
                if (checkedRadio.value === 'razorpay' && razorpayInfoBox) {
                    razorpayInfoBox.classList.remove('d-none');
                } else if (checkedRadio.value === 'stripe' && stripeInfoBox) {
                    stripeInfoBox.classList.remove('d-none');
                } else if (checkedRadio.value === 'paypal' && paypalInfoBox) {
                    paypalInfoBox.classList.remove('d-none');
                }
            }
        }

        // Auto check the first visible payment option
        if (paymentRadios.length > 0) {
            const checkedRadio = document.querySelector('.payment-radio:checked');
            if (!checkedRadio) {
                paymentRadios[0].checked = true;
            }
        }

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', toggleInfoBoxes);
        });

        toggleInfoBoxes();
    });
</script>
@endpush
@endsection
