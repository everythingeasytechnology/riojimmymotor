@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title -->
    <div class="mb-4">
        <h2 class="fw-bold m-0" style="font-size: 28px;">Website Settings</h2>
        <span class="text-muted small">Configure site details, contact info, analytical script injectors, and SMTP.</span>
    </div>

    <!-- Main Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Tab Selectors -->
        <ul class="nav nav-tabs border-bottom-0 gap-2 mb-3" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active border shadow-sm rounded-top" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-pane" type="button" role="tab" aria-controls="general-pane" aria-selected="true"><i class="fa fa-gears me-1"></i> General Settings</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link border shadow-sm rounded-top" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#integrations-pane" type="button" role="tab" aria-controls="integrations-pane" aria-selected="false"><i class="fa fa-code-branch me-1"></i> Analytical Integrations</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link border shadow-sm rounded-top" id="smtp-tab" data-bs-toggle="tab" data-bs-target="#smtp-pane" type="button" role="tab" aria-controls="smtp-pane" aria-selected="false"><i class="fa fa-envelope-open-text me-1"></i> SMTP & Mailers</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link border shadow-sm rounded-top" id="security-tab" data-bs-toggle="tab" data-bs-target="#security-pane" type="button" role="tab" aria-controls="security-pane" aria-selected="false"><i class="fa fa-user-shield me-1"></i> Security Logs</button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content border p-4 rounded-bottom shadow-sm bg-white text-dark mb-4">
            
            <!-- Tab 1: General Settings -->
            <div class="tab-pane fade show active" id="general-pane" role="tabpanel" aria-labelledby="general-tab">
                <div class="row g-3">
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">SITE NAME *</label>
                        <input type="text" class="form-control" name="site_name" value="{{ $settings['site_name'] }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">SITE LOGO</label>
                        <input type="file" class="form-control" name="site_logo" accept="image/*">
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">CONTACT PHONE NUMBER *</label>
                        <input type="text" class="form-control" name="contact_phone" value="{{ $settings['contact_phone'] }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">CONTACT EMAIL ADDRESS *</label>
                        <input type="email" class="form-control" name="contact_email" value="{{ $settings['contact_email'] }}" required>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">OFFICE HEADQUARTERS ADDRESS *</label>
                        <input type="text" class="form-control" name="office_address" value="{{ $settings['office_address'] }}" required>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold">BUSINESS OPERATIONAL HOURS *</label>
                        <input type="text" class="form-control" name="business_hours" value="{{ $settings['business_hours'] }}" required>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Analytical Integrations -->
            <div class="tab-pane fade" id="integrations-pane" role="tabpanel" aria-labelledby="integrations-tab">
                <div class="row g-3">
                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold text-muted">GOOGLE ANALYTICS MEASUREMENT ID</label>
                        <input type="text" class="form-control" name="google_analytics_id" value="{{ $settings['google_analytics_id'] }}" placeholder="G-XXXXXXXXXX">
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold text-muted">MICROSOFT CLARITY PROJECT ID</label>
                        <input type="text" class="form-control" name="clarity_project_id" value="{{ $settings['clarity_project_id'] }}" placeholder="e.g. j7x8n1as">
                    </div>
                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold text-muted">FACEBOOK PIXEL ID</label>
                        <input type="text" class="form-control" name="facebook_pixel_id" value="{{ $settings['facebook_pixel_id'] }}" placeholder="e.g. 1234567890">
                    </div>

                    <div class="col-12 border-top pt-3">
                        <label class="form-label small fw-bold">CUSTOM HEADER SCRIPTS (&lt;head&gt;)</label>
                        <textarea class="form-control font-monospace" name="custom_header_scripts" rows="4" placeholder="<!-- Place custom tracking pixels or verification scripts here -->">{{ $settings['custom_header_scripts'] }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">CUSTOM FOOTER SCRIPTS (before &lt;/body&gt;)</label>
                        <textarea class="form-control font-monospace" name="custom_footer_scripts" rows="4" placeholder="<!-- Place live chat scripts or statistics tracking codes here -->">{{ $settings['custom_footer_scripts'] }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tab 3: SMTP Configuration -->
            <div class="tab-pane fade" id="smtp-pane" role="tabpanel" aria-labelledby="smtp-tab">
                <p class="small text-muted">Configure outbound SMTP mail server credentials for quote alerts and receipts.</p>
                <div class="row g-3" onclick="alert('SMTP configuration fields are preview only in settings panel (Mockup)')">
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold text-muted">SMTP HOST</label>
                        <input type="text" class="form-control" placeholder="smtp.mailgun.org" readonly>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small fw-bold text-muted">SMTP PORT</label>
                        <input type="text" class="form-control" placeholder="587" readonly>
                    </div>
                    <div class="col-md-3 col-6">
                        <label class="form-label small fw-bold text-muted">SMTP ENCRYPTION</label>
                        <input type="text" class="form-control" placeholder="TLS" readonly>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold text-muted">SMTP USERNAME</label>
                        <input type="text" class="form-control" placeholder="postmaster@autopartsmarket.com" readonly>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold text-muted">SMTP PASSWORD</label>
                        <input type="password" class="form-control" placeholder="••••••••••••••••" readonly>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold text-muted">MAIL SENDER EMAIL ADDRESS</label>
                        <input type="email" class="form-control" placeholder="no-reply@autopartsmarket.com" readonly>
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="form-label small fw-bold text-muted">MAIL SENDER DISPLAY NAME</label>
                        <input type="text" class="form-control" placeholder="Auto Parts Marketplace Notifications" readonly>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Security Logs -->
            <div class="tab-pane fade" id="security-pane" role="tabpanel" aria-labelledby="security-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0 fs-6">Recent Security & Login Logs</h5>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="alert('Two-Factor authentication setup completed (Mockup)')"><i class="fa fa-shield-halved me-1"></i> Enable 2FA Security</button>
                </div>
                
                <div class="table-responsive border rounded">
                    <table class="table table-hover align-middle m-0 font-poppins text-dark small">
                        <thead class="table-light">
                            <tr>
                                <th>Event Type</th>
                                <th>User Address</th>
                                <th>IP Address</th>
                                <th>Timestamp</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-circle-check text-success me-2"></i>Admin Dashboard Login</td>
                                <td>superadmin@autopartsmarket.com</td>
                                <td><code>192.168.1.45</code></td>
                                <td>2026-06-22 13:42:01</td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle">Success</span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-key text-warning me-2"></i>Password Key Update Attempt</td>
                                <td>support-agent@autopartsmarket.com</td>
                                <td><code>74.125.19.147</code></td>
                                <td>2026-06-21 09:15:30</td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle">Success</span></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-triangle-exclamation text-danger me-2"></i>Invalid Authentication Attempt</td>
                                <td>unknown-bot@hackers.ru</td>
                                <td><code>91.243.82.11</code></td>
                                <td>2026-06-20 23:59:12</td>
                                <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle">Blocked</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Submit actions -->
        <div class="d-flex justify-content-end gap-2 mb-5">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Save All Configurations</button>
        </div>
    </form>

@endsection
