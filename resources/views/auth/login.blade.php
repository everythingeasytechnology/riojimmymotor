<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login | Rio Jimmy Motor</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <style>
        :root {
            --primary-red: #D91E18;
            --primary-red-hover: #b8140f;
            --dark-black: #111111;
            --bg-gradient: linear-gradient(135deg, #1f1f1f 0%, #111111 100%);
            --font-poppins: 'Poppins', sans-serif;
        }

        body {
            font-family: var(--font-poppins);
            background: var(--bg-gradient);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            color: #ffffff;
            position: relative;
        }

        /* Decorative background light circles */
        .circle-bg {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(217, 30, 24, 0.15) 0%, rgba(0,0,0,0) 70%);
            z-index: 1;
        }
        .circle-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
        }
        .circle-2 {
            width: 500px;
            height: 500px;
            bottom: -150px;
            right: -150px;
        }

        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 430px;
            padding: 20px;
        }

        .login-card {
            background: rgba(30, 30, 30, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
            padding: 40px 30px;
            transition: transform 0.3s ease;
        }

        .brand-logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-logo-container img {
            height: 80px;
            max-height: 80px;
            object-fit: contain;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            color: #ffffff;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #aaaaaa;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #cccccc;
            margin-bottom: 8px;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #888888;
            border-radius: 8px 0 0 8px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 12px;
            font-size: 14px;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(217, 30, 24, 0.25);
            color: #ffffff;
        }

        /* Checkbox styling */
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }

        .form-check-label {
            font-size: 13px;
            color: #bbbbbb;
            cursor: pointer;
        }

        .btn-submit {
            background: var(--primary-red);
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            width: 100%;
            margin-top: 15px;
            box-shadow: 0 4px 15px rgba(217, 30, 24, 0.3);
        }

        .btn-submit:hover {
            background: var(--primary-red-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(217, 30, 24, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .error-message-block {
            font-size: 13px;
            color: #ff4d4d;
            background: rgba(255, 77, 77, 0.1);
            border-left: 3px solid #ff4d4d;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
        }

        .back-link a {
            color: #888888;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: var(--primary-red);
        }
    </style>
</head>
<body>

    <div class="circle-bg circle-1"></div>
    <div class="circle-bg circle-2"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-logo-container">
                <img src="{{ asset('frontend/images/riojimmymotorLogo.webp') }}" alt="Rio Jimmy Motor Logo">
            </div>

            <h2 class="login-title">Control Center</h2>
            <p class="login-subtitle">Sign in to manage riojimmymotor portal</p>

            @if ($errors->any())
                <div class="error-message-block">
                    @foreach ($errors->all() as $error)
                        <div class="d-flex align-items-center">
                            <i class="fa fa-circle-exclamation me-2"></i>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success py-2 px-3 small border-0 mb-3" style="background: rgba(40, 167, 69, 0.15); color: #2ecc71; border-left: 3px solid #2ecc71;">
                    <i class="fa fa-circle-check me-2"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required autocomplete="email" autofocus>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="mb-3 form-check d-flex align-items-center">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label ms-2" for="remember">Remember me on this device</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-submit">
                    SECURE SIGN IN <i class="fa fa-arrow-right-to-bracket ms-2"></i>
                </button>
            </form>

            <div class="back-link">
                <a href="{{ url('/') }}"><i class="fa fa-arrow-left me-1"></i> Back to Homepage</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
