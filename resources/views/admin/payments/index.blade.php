@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title -->
    <div class="mb-4">
        <h2 class="fw-bold m-0" style="font-size: 28px;">Payment Gateway Manager</h2>
        <span class="text-muted small">Enable payment methods and manage sandbox/live API configurations.</span>
    </div>

    <!-- Gateway Configs Form -->
    <form id="paymentSettingsForm" action="{{ route('admin.payments.update') }}" method="POST">
        @csrf

        <div class="row g-4 mb-5">
            
            <!-- Stripe Config Column -->
            <div class="col-lg-6 col-12">
                <div class="admin-card h-100">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <span><i class="fab fa-stripe text-danger me-2" style="font-size: 20px;"></i>Stripe Checkout Configuration</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="stripe_enabled" id="stripe_enabled" value="1" {{ $gateways['stripe']['enabled'] === '1' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="stripe_enabled">Active</label>
                        </div>
                    </div>
                    <div class="admin-card-body text-dark">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">STRIPE MODE</label>
                            <select class="form-select" name="stripe_mode">
                                <option value="sandbox" {{ $gateways['stripe']['mode'] === 'sandbox' ? 'selected' : '' }}>Test / Sandbox</option>
                                <option value="live" {{ $gateways['stripe']['mode'] === 'live' ? 'selected' : '' }}>Live Mode</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">STRIPE PUBLIC KEY</label>
                            <input type="text" class="form-control" name="stripe_public_key" value="{{ $gateways['stripe']['public_key'] }}" placeholder="pk_test_...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">STRIPE SECRET KEY</label>
                            <input type="password" class="form-control" name="stripe_secret_key" value="{{ $gateways['stripe']['secret_key'] }}" placeholder="sk_test_...">
                        </div>
                        <div>
                            <label class="form-label small fw-bold">STRIPE WEBHOOK SECRET</label>
                            <input type="text" class="form-control" name="stripe_webhook" value="{{ $gateways['stripe']['webhook'] }}" placeholder="whsec_...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Razorpay Config Column -->
            <div class="col-lg-6 col-12">
                <div class="admin-card">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-wallet text-danger me-2" style="font-size: 20px;"></i>Razorpay Configs</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="razorpay_enabled" id="razorpay_enabled" value="1" {{ $gateways['razorpay']['enabled'] === '1' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="razorpay_enabled">Active</label>
                        </div>
                    </div>
                    <div class="admin-card-body text-dark">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">RAZORPAY MODE</label>
                            <select class="form-select" name="razorpay_mode">
                                <option value="sandbox" {{ $gateways['razorpay']['mode'] === 'sandbox' ? 'selected' : '' }}>Test Mode</option>
                                <option value="live" {{ $gateways['razorpay']['mode'] === 'live' ? 'selected' : '' }}>Live Mode</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">KEY ID</label>
                            <input type="text" class="form-control" name="razorpay_key_id" value="{{ $gateways['razorpay']['key_id'] }}">
                        </div>
                        <div>
                            <label class="form-label small fw-bold">KEY SECRET</label>
                            <input type="password" class="form-control" name="razorpay_key_secret" value="{{ $gateways['razorpay']['key_secret'] }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PayGlocal Config Column -->
            <div class="col-lg-6 col-12">
                <div class="admin-card h-100">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <span><i class="fa fa-globe text-danger me-2" style="font-size: 20px;"></i>PayGlocal Configs</span>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" name="payglocal_enabled" id="payglocal_enabled" value="1" {{ $gateways['payglocal']['enabled'] === '1' ? 'checked' : '' }}>
                            <label class="form-check-label small" for="payglocal_enabled">Active</label>
                        </div>
                    </div>
                    <div class="admin-card-body text-dark" style="font-size: 0.9rem;">
                        <div class="alert alert-info small mb-3">
                            <strong>Setup Instructions:</strong> Download keys from PayGlocal GCC Dashboard (Configure → Key Management System), extract key IDs from filenames, and upload to storage/payments/payglocal/
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">PAYGLOCAL MODE</label>
                            <select class="form-select form-select-sm" name="payglocal_mode">
                                <option value="sandbox" {{ $gateways['payglocal']['mode'] === 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                                <option value="live" {{ $gateways['payglocal']['mode'] === 'live' ? 'selected' : '' }}>Live (Production)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">MERCHANT ID (MID)</label>
                            <input type="text" class="form-control form-control-sm" name="payglocal_merchant_id" value="{{ $gateways['payglocal']['merchant_id'] }}" placeholder="e.g., MID123456">
                            <small class="form-text text-muted">From GCC → Profile → My Account → TID Details</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">PUBLIC KEY ID (from PayGlocal certificate filename)</label>
                            <input type="text" class="form-control form-control-sm" name="payglocal_public_key_id" value="{{ $gateways['payglocal']['public_key_id'] }}" placeholder="e.g., 834hinrh-8r0n-4657-34nn-fnjhjre33uur">
                            <small class="form-text text-muted">Extract from public key .pem filename (text before first underscore)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">PRIVATE KEY ID (from your RSA key filename)</label>
                            <input type="text" class="form-control form-control-sm" name="payglocal_private_key_id" value="{{ $gateways['payglocal']['private_key_id'] }}" placeholder="e.g., 884hiurh-8e0b-4907-38nn-fuerikejr89">
                            <small class="form-text text-muted">Extract from private key .pem filename (text before first underscore)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">PUBLIC KEY FILE PATH</label>
                            <input type="text" class="form-control form-control-sm" name="payglocal_public_key_path" value="{{ $gateways['payglocal']['public_key_path'] }}" placeholder="payments/payglocal/public.pem">
                            <small class="form-text text-muted">Upload PayGlocal certificate to storage folder</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">PRIVATE KEY FILE PATH</label>
                            <input type="text" class="form-control form-control-sm" name="payglocal_private_key_path" value="{{ $gateways['payglocal']['private_key_path'] }}" placeholder="payments/payglocal/private.pem">
                            <small class="form-text text-muted">Upload your RSA private key to storage folder</small>
                        </div>

                        <div>
                            <label class="form-label small fw-bold">BASE URL</label>
                            <input type="text" class="form-control form-control-sm" name="payglocal_base_url" value="{{ $gateways['payglocal']['base_url'] }}" placeholder="https://api.uat.payglocal.in">
                            <small class="form-text text-muted">Leave empty for default (sandbox/UAT: https://api.uat.payglocal.in, live/production: https://api.prod.payglocal.in)</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Submit actions -->
        <div class="d-flex justify-content-end gap-2 mb-5">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Save Payment Configs</button>
        </div>
    </form>

@endsection

@push('admin-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('paymentSettingsForm');
            if (form) {
                const switches = form.querySelectorAll('.form-check-input[type="checkbox"]');
                switches.forEach(sw => {
                    sw.addEventListener('change', function() {
                        form.submit();
                    });
                });
            }
        });
    </script>
@endpush
