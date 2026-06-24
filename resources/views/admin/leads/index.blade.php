@extends('admin.layouts.admin')

@section('admin-content')

    <!-- Page Title & Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold m-0" style="font-size: 28px;">Customer Leads & Inquiries</h2>
            <span class="text-muted small">Manage quotes requests and contact forms submissions.</span>
        </div>
        <button class="btn btn-sm btn-outline-secondary" onclick="alert('Exporting leads data CSV (Mockup)')"><i class="fa fa-file-export me-1"></i> Export Leads</button>
    </div>

    <!-- Leads Table Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <span><i class="fa fa-headset text-danger me-2"></i>Contact Leads Submissions</span>
        </div>
        <div class="admin-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0 text-dark font-poppins">
                    <thead class="table-light">
                        <tr>
                            <th width="40">Status</th>
                            <th>Contact Info</th>
                            <th>Vehicle Application</th>
                            <th>Requested Part</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr class="{{ !$lead->is_read ? 'table-warning fw-bold' : '' }}" id="lead-row-{{ $lead->id }}">
                                <td>
                                    @if(!$lead->is_read)
                                        <span class="badge bg-danger rounded-circle p-1" title="New Unread Lead"><span class="visually-hidden">New</span></span>
                                    @else
                                        <i class="fa fa-check-circle text-success" title="Read Lead"></i>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-dark d-block">{{ $lead->name }}</span>
                                    <span class="text-muted small d-block">{{ $lead->email }}</span>
                                    <span class="text-muted small">{{ $lead->phone }}</span>
                                </td>
                                <td>
                                    <span class="text-dark d-block">{{ $lead->year }} {{ $lead->make }} {{ $lead->model }}</span>
                                    <span class="text-muted small">VIN: <code>{{ $lead->vin ?? 'Not Provided' }}</code></span>
                                </td>
                                <td>{{ $lead->part_requested }}</td>

                                <td>
                                    <div class="d-flex gap-2">
                                        @if(!$lead->is_read)
                                            <button class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="markAsRead({{ $lead->id }})" title="Mark Read"><i class="fa fa-eye"></i></button>
                                        @endif
                                        <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1" title="Delete Inquiry"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Fallback Mock items for visualization when DB is empty -->
                            @for($i=1; $i<=3; $i++)
                                <tr class="{{ $i === 1 ? 'table-warning fw-bold' : '' }}">
                                    <td>
                                        @if($i === 1)
                                            <span class="badge bg-danger rounded-circle p-1" title="New Unread Lead"><span class="visually-hidden">New</span></span>
                                        @else
                                            <i class="fa fa-check-circle text-success"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-dark d-block">Client Name {{ $i }}</span>
                                        <span class="text-muted small d-block">client{{ $i }}@example.com</span>
                                        <span class="text-muted small">(555) 000-000{{ $i }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark d-block">2018 Toyota Camry</span>
                                        <span class="text-muted small">VIN: <code>4T1BF1FKXJU12345{{ $i }}</code></span>
                                    </td>
                                    <td>Complete Engine Block Assembly (2.5L)</td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-secondary btn-sm px-2 py-1" onclick="alert('Mark Read complete (Mockup)')"><i class="fa fa-eye"></i></button>
                                            <button class="btn btn-outline-danger btn-sm px-2 py-1" onclick="alert('Delete complete (Mockup)')"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('admin-scripts')
    <script>
        function markAsRead(leadId) {
            const url = "{{ route('admin.leads.read', ':id') }}".replace(':id', leadId);
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById('lead-row-' + leadId);
                    if (row) {
                        row.classList.remove('table-warning', 'fw-bold');
                    }
                    window.location.reload();
                } else {
                    alert('Error marking lead as read: ' + (data.message || 'unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Connection error occurred while marking lead as read.');
            });
        }
    </script>
@endpush
