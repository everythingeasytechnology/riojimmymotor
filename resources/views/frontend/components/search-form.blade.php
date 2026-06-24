<div class="text-center mb-4 font-poppins">
    <h3 class="fw-bold text-dark fs-5" style="margin-bottom: 8px; line-height: 1.4;">Grade A Used Engine's & Transmission's Available Across USA</h3>
    <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.5;">
        Speak with a specialist now.<br>
        <strong>Get exact engine price in under 60 seconds.</strong>
    </p>
</div>

<form id="inquiryForm" class="d-flex flex-column gap-3">
    @csrf
    <!-- Year / Make / Model -->
    <div>
        <input type="text" name="vehicle" class="form-control form-control-lg bg-white border-secondary-subtle font-poppins" placeholder="Year / Make / Model" required style="padding: 14px; font-size: 16px; border-radius: 6px;">
    </div>

    <!-- Engine Size (Optional) -->
    <div>
        <input type="text" name="engine_size" class="form-control form-control-lg bg-white border-secondary-subtle font-poppins" placeholder="Engine Size (Optional)" style="padding: 14px; font-size: 16px; border-radius: 6px;">
    </div>

    <!-- Your Phone Number -->
    <div>
        <input type="tel" name="phone" class="form-control form-control-lg bg-white border-secondary-subtle font-poppins" placeholder="Your Phone Number" required style="padding: 14px; font-size: 16px; border-radius: 6px;">
    </div>

    <!-- Submit Button -->
    <div class="mt-2">
        <button type="submit" class="btn btn-danger w-100 py-3 fw-bold text-white border-0 font-poppins" style="background-color: #c62828; font-size: 18px; border-radius: 6px; letter-spacing: 0.5px;">
            Call Now to Check Price
        </button>
    </div>

    <!-- Alert Container -->
    <div id="inquiryAlert" class="mt-2 d-none alert font-poppins" role="alert" style="font-size: 14px; padding: 12px;"></div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('inquiryForm');
    const alertBox = document.getElementById('inquiryAlert');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Reset alert
            alertBox.classList.add('d-none');
            alertBox.classList.remove('alert-success', 'alert-danger');

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting Request...';

            const formData = new FormData(form);

            fetch('{{ route("inquiry.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;

                if (data.success) {
                    alertBox.classList.remove('d-none');
                    alertBox.classList.add('alert-success');
                    alertBox.textContent = data.message;
                    form.reset();
                } else {
                    alertBox.classList.remove('d-none');
                    alertBox.classList.add('alert-danger');
                    alertBox.textContent = data.message || 'An error occurred. Please try again.';
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                alertBox.classList.remove('d-none');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = 'A connection error occurred. Please try again.';
                console.error('Error:', error);
            });
        });
    }
});
</script>
