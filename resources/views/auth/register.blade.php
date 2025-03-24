<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediClinic - Create Patient Account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4ecf7 100%);
            min-height: 100vh;
        }
        .login-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 15px;
        }
        .login-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            background-color: white;
        }
        .login-header {
            background-color: #1e88e5;
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #1565c0;
        }
        .login-body {
            padding: 40px;
        }
        .login-image {
            background-image: url('https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3');
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 100%;
            border-radius: 0 15px 15px 0;
        }
        .login-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(21, 101, 192, 0.6);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            color: white;
        }
        .btn-custom-primary {
            background-color: #1e88e5;
            border-color: #1e88e5;
            color: white;
            padding: 10px 20px;
            font-weight: 500;
        }
        .btn-custom-primary:hover {
            background-color: #1565c0;
            border-color: #1565c0;
            color: white;
        }
        .social-btn {
            width: 100%;
            margin: 8px 0;
            padding: 10px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .social-btn i {
            margin-right: 10px;
            font-size: 18px;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        .divider-text {
            padding: 0 10px;
            color: #757575;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(21, 101, 192, 0.25);
            border-color: #1976d2;
        }
        .secure-info {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: #616161;
            margin-top: 15px;
        }
        .secure-info i {
            margin-right: 5px;
            color: #43a047;
        }
    </style>
</head>
<body>
    <div class="login-container d-flex align-items-center">
        <div class="container">
            <div class="row login-card">
                <div class="col-md-6 p-0">
                    <div class="login-header">
                        <h3><i class="fas fa-heartbeat me-2"></i> MediClinic</h3>
                        <p class="mb-0">Patient Portal Registration</p>
                    </div>
                    <div class="login-body">
                        <h4 class="mb-4">Create Your Account</h4>
                        
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small class="form-text text-muted">Password must be at least 8 characters</small>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and <a href="#" class="text-decoration-none">Privacy Policy</a></label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom-primary">Create Account</button>
                            </div>
                        </form>
                        
                        <div class="divider">
                            <span class="divider-text">or register with</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{ url('auth/google') }}" class="btn social-btn btn-outline-danger">
                                    <i class="fab fa-google"></i> Google
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{ url('auth/facebook') }}" class="btn social-btn btn-outline-primary">
                                    <i class="fab fa-facebook-f"></i> Facebook
                                </a>
                            </div>
                        </div>
                        
                        <div class="secure-info mt-4">
                            <i class="fas fa-lock"></i>
                            <span>Your information is securely encrypted and protected</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0 d-none d-md-block">
                    <div class="login-image">
                        <div class="login-image-overlay">
                            <h3 class="mb-4">Join Our Healthcare Community</h3>
                            <p>Creating an account gives you access to personalized healthcare services and resources.</p>
                            <hr class="my-4">
                            <div>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Book appointments online</p>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Access your medical history</p>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Request prescription refills</p>
                                <p><i class="fas fa-check-circle me-2"></i> Receive health reminders</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <p class="small text-muted">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>