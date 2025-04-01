<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediClinic - Create Account</title>
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
            max-height: 75vh;
            overflow-y: auto;
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
        .role-selector {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .role-option {
            flex: 1;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .role-option:hover {
            border-color: #1e88e5;
            background-color: #f5f9ff;
        }
        .role-option.selected {
            border-color: #1e88e5;
            background-color: #f5f9ff;
        }
        .role-option .icon {
            font-size: 28px;
            margin-bottom: 10px;
            color: #1e88e5;
        }
        .role-option .role-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        .role-option .role-description {
            font-size: 13px;
            color: #616161;
        }
        .role-specific-fields {
            display: none;
            animation: fadeIn 0.5s;
        }
        .form-section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e88e5;
            margin-top: 15px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 8px;
        }
        .status-active {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Add responsive adjustments */
        @media (max-width: 767px) {
            .login-card {
                max-height: none;
            }
            .login-body {
                max-height: none;
            }
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
                        <p class="mb-0">Registration Portal</p>
                    </div>
                    <div class="login-body">
                        <h4 class="mb-4">Create Your Account</h4>
                        
                        <form action="{{ route('register') }}" method="POST" id="registerForm">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label mb-3">I am registering as a:</label>
                                <div class="role-selector">
                                    <div class="role-option" data-role="patient">
                                        <div class="icon"><i class="fas fa-user"></i></div>
                                        <div class="role-title">Patient</div>
                                        <div class="role-description">Book appointments and access healthcare services</div>
                                        <span class="status-badge status-active">Active Immediately</span>
                                    </div>
                                    <div class="role-option" data-role="doctor">
                                        <div class="icon"><i class="fas fa-user-md"></i></div>
                                        <div class="role-title">Medical Provider</div>
                                        <div class="role-description">Healthcare professionals offering services</div>
                                        <span class="status-badge status-pending">Requires Verification</span>
                                    </div>
                                </div>
                                <input type="hidden" name="role" id="role_input" value="patient">
                                @error('role')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-section-title">Personal Information</div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" required>
                                    <small class="form-text text-muted">Password must be at least 8 characters</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                        id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                    id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Address</label>
                                <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                    id="adresse" name="adresse" rows="2" required>{{ old('adresse') }}</textarea>
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Patient-specific fields -->
                            <div id="patient-fields" class="role-specific-fields">
                                <div class="form-section-title">Patient Information</div>
                                <div class="mb-3">
                                    <label for="assurance" class="form-label">Insurance Information</label>
                                    <input type="text" class="form-control @error('assurance') is-invalid @enderror" 
                                        id="assurance" name="assurance" value="{{ old('assurance') }}">
                                    <small class="form-text text-muted">Enter your insurance provider and policy number</small>
                                    @error('assurance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                    <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                        id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}">
                                    @error('emergency_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Doctor-specific fields -->
                            <div id="doctor-fields" class="role-specific-fields">
                                <div class="form-section-title">Professional Information</div>
                                <div class="mb-3">
                                    <label for="speciality" class="form-label">Medical Specialty</label>
                                    <select class="form-control @error('speciality') is-invalid @enderror" 
                                        id="speciality" name="speciality">
                                        <option value="">Select your specialty</option>
                                        <option value="Cardiologie" {{ old('speciality') == 'Cardiologie' ? 'selected' : '' }}>Cardiology</option>
                                        <option value="Dermatologie" {{ old('speciality') == 'Dermatologie' ? 'selected' : '' }}>Dermatology</option>
                                        <option value="Gastroentérologie" {{ old('speciality') == 'Gastroentérologie' ? 'selected' : '' }}>Gastroenterology</option>
                                        <option value="Gynécologie" {{ old('speciality') == 'Gynécologie' ? 'selected' : '' }}>Gynecology</option>
                                        <option value="Ophtalmologie" {{ old('speciality') == 'Ophtalmologie' ? 'selected' : '' }}>Ophthalmology</option>
                                        <option value="Pédiatrie" {{ old('speciality') == 'Pédiatrie' ? 'selected' : '' }}>Pediatrics</option>
                                        <option value="Psychiatrie" {{ old('speciality') == 'Psychiatrie' ? 'selected' : '' }}>Psychiatry</option>
                                        <option value="Radiologie" {{ old('speciality') == 'Radiologie' ? 'selected' : '' }}>Radiology</option>
                                        <option value="Médecine générale" {{ old('speciality') == 'Médecine générale' ? 'selected' : '' }}>General Medicine</option>
                                        <option value="Autre" {{ old('speciality') == 'Autre' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('speciality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="license_number" class="form-label">License/Registration Number</label>
                                    <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                                        id="license_number" name="license_number" value="{{ old('license_number') }}">
                                    <small class="form-text text-muted">This will be verified by our administration</small>
                                    @error('license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="biography" class="form-label">Professional Biography</label>
                                    <textarea class="form-control @error('biography') is-invalid @enderror" 
                                        id="biography" name="biography" rows="3">{{ old('biography') }}</textarea>
                                    <small class="form-text text-muted">Briefly describe your education, experience, and expertise</small>
                                    @error('biography')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                            <h3 class="mb-4" id="benefitsTitle">Join Our Healthcare Community</h3>
                            <p id="benefitsDescription">Creating an account gives you access to personalized healthcare services and resources.</p>
                            <hr class="my-4">
                            <div id="patientBenefits">
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Book appointments online</p>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Access your medical history</p>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Request prescription refills</p>
                                <p><i class="fas fa-check-circle me-2"></i> Receive health reminders</p>
                            </div>
                            <div id="doctorBenefits" style="display:none;">
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Manage your appointment schedule</p>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Access patient records securely</p>
                                <p class="mb-1"><i class="fas fa-check-circle me-2"></i> Collaborate with other providers</p>
                                <p><i class="fas fa-check-circle me-2"></i> Build your professional profile</p>
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
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Role selection handling
        const roleOptions = document.querySelectorAll('.role-option');
        const roleInput = document.getElementById('role_input');
        const patientFields = document.getElementById('patient-fields');
        const doctorFields = document.getElementById('doctor-fields');
        const patientBenefits = document.getElementById('patientBenefits');
        const doctorBenefits = document.getElementById('doctorBenefits');
        const benefitsTitle = document.getElementById('benefitsTitle');
        const benefitsDescription = document.getElementById('benefitsDescription');
        const registerForm = document.getElementById('registerForm');
        
        // Set default role and display
        let selectedRole = 'patient';
        patientFields.style.display = 'block';
        
        // Function to update displayed fields based on role
        function updateRoleDisplay(role) {
            // Update hidden input
            roleInput.value = role;
            
            // Update role option styling
            roleOptions.forEach(option => {
                if(option.dataset.role === role) {
                    option.classList.add('selected');
                } else {
                    option.classList.remove('selected');
                }
            });
            
            // Show/hide appropriate fields
            if(role === 'patient') {
                patientFields.style.display = 'block';
                doctorFields.style.display = 'none';
                patientBenefits.style.display = 'block';
                doctorBenefits.style.display = 'none';
                benefitsTitle.textContent = 'Join Our Patient Community';
                benefitsDescription.textContent = 'Creating an account gives you access to personalized healthcare services and resources.';
                
                // Update required fields
                document.getElementById('assurance').required = true;
                document.getElementById('emergency_contact').required = true;
                document.getElementById('speciality').required = false;
                document.getElementById('license_number').required = false;
            } else {
                patientFields.style.display = 'none';
                doctorFields.style.display = 'block';
                patientBenefits.style.display = 'none';
                doctorBenefits.style.display = 'block';
                benefitsTitle.textContent = 'Join Our Provider Network';
                benefitsDescription.textContent = 'Create your professional profile and connect with patients seeking your expertise.';
                
                // Update required fields
                document.getElementById('assurance').required = false;
                document.getElementById('emergency_contact').required = false;
                document.getElementById('speciality').required = true;
                document.getElementById('license_number').required = true;
            }
        }
        
        // Role option click event listeners
        roleOptions.forEach(option => {
            option.addEventListener('click', function() {
                selectedRole = this.dataset.role;
                updateRoleDisplay(selectedRole);
            });
        });
        
        // Initial selection (for cases with validation errors)
        const initialRole = roleInput.value || 'patient';
        updateRoleDisplay(initialRole);
        
        // Form validation
        registerForm.addEventListener('submit', function(event) {
            let hasErrors = false;
            
            // Validate role-specific required fields
            if(selectedRole === 'doctor') {
                if(!document.getElementById('speciality').value) {
                    document.getElementById('speciality').classList.add('is-invalid');
                    hasErrors = true;
                }
                
                if(!document.getElementById('license_number').value) {
                    document.getElementById('license_number').classList.add('is-invalid');
                    hasErrors = true;
                }
            }
            
            if(hasErrors) {
                event.preventDefault();
                window.scrollTo(0, 0);
            }
        });
    });
    </script>
</body>
</html>