<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment... | Rio Jimmy Motor</title>
    <!-- CSS for beautiful styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .loader-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }
        .spinner-wrapper {
            position: relative;
            margin-bottom: 25px;
        }
        .spinner-custom {
            width: 70px;
            height: 70px;
            border: 6px solid #f3f3f3;
            border-top: 6px solid #D91E18;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .logo-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            color: #D91E18;
        }
    </style>
</head>
<body>
    <div class="loader-card">
        <div class="spinner-wrapper">
            <div class="spinner-custom"></div>
            <div class="logo-placeholder">
                <i class="fa fa-credit-card"></i>
            </div>
        </div>
        <h4 class="fw-bold text-dark mb-2">Connecting to Secure Payment Gateway</h4>
        <p class="text-muted mb-4 small">Please do not close this window or click back. We are preparing your secure checkout session.</p>
        <div class="d-flex justify-content-center align-items-center gap-2">
            <span class="badge bg-light text-dark border px-3 py-2">
                Order: <strong class="text-danger">{{ $order->order_number }}</strong>
            </span>
            <span class="badge bg-light text-dark border px-3 py-2">
                Total: <strong class="text-danger">${{ number_format($order->total, 2) }}</strong>
            </span>
        </div>
        <button id="rzp-button" class="btn btn-danger w-100 py-2.5 mt-4 fw-bold d-none" style="background-color: #D91E18; border: none;">
            Pay Now
        </button>
    </div>

    <!-- Razorpay Checkout Script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ $keyId }}",
            "amount": "{{ intval(round($order->total * 100)) }}",
            "currency": "USD",
            "name": "Rio Jimmy Motor",
            "description": "Order #{{ $order->order_number }}",
            "order_id": "{{ $razorpayOrder['id'] }}",
            "handler": function (response) {
                var redirectUrl = "{{ route('checkout.success') }}?order={{ $order->order_number }}" +
                    "&razorpay_payment_id=" + encodeURIComponent(response.razorpay_payment_id) +
                    "&razorpay_order_id=" + encodeURIComponent(response.razorpay_order_id) +
                    "&razorpay_signature=" + encodeURIComponent(response.razorpay_signature);
                window.location.href = redirectUrl;
            },
            "prefill": {
                "name": "{{ $order->customer_name }}",
                "email": "{{ $order->customer_email }}",
                "contact": "{{ $order->customer_phone }}"
            },
            "theme": {
                "color": "#D91E18"
            },
            "modal": {
                "ondismiss": function(){
                    window.location.href = "{{ route('checkout') }}?cancel_order={{ $order->order_number }}";
                }
            }
        };

        var rzp = new Razorpay(options);

        // Auto open when ready
        window.onload = function() {
            try {
                rzp.open();
            } catch(e) {
                console.error("Razorpay loading error", e);
                // Fallback to show button if auto-open fails
                document.getElementById('rzp-button').classList.remove('d-none');
            }
        };

        document.getElementById('rzp-button').onclick = function(e){
            rzp.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
