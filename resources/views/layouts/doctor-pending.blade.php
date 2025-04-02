php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Verification - MediClinic</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4ecf7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
        }
        .pending-container {
            max-width: 800px;
            padding: 40px;
        }
        .pending-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            background-color: white;
        }
        .pending-header {
            background-color: #f6c23e;
            color: #856404;
            padding: 25px;
            text-align: center;
        }
        .pending-body {
            padding: 40px;
        }
        .pending-icon {
            font-size: 4rem;
            color: #f6c23e;
            margin-bottom: 1.5rem;
        }
        .steps-container {
            margin-top: 2rem;
            counter-reset: step;
        }
        .step {
            position: relative;
            padding-left: 45px;
            margin-bottom: 1.5rem;
        }
        .step:before {
            counter-increment: step;
            content: counter(step);
            position: absolute;
            left: 0;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #f6c23e;
            color: white;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        .help-link {
            color: #4e73df;
            text-decoration: none;
        }
        .help-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="pending-container">
        <div class="pending-card">
            <div class="pending-header">
                <h3><i class="fas fa-exclamation-circle mr-2"></i> Account Verification Pending</h3>
                <p class="mb-0">Your provider account is awaiting admin verification</p>
            </div>
            <div class="pending-body text-center">
                <div class="pending-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                
                <h4 class="mb-3">Thank you for registering as a healthcare provider!</h4>
                <p class="text-muted mb-4">
                    Your account has been created successfully, but requires verification before you can access all features.
                    Our administrative team will review your credentials and information typically within 24-48 hours.
                </p>
                
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> You will receive an email when your// filepath: c:\Users\Youcode\Desktop\clinique api\plateforme_gestion_clinique\resources\views\auth\doctor-pending.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending Verification - MediClinic</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4ecf7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
        }
        .pending-container {
            max-width: 800px;
            padding: 40px;
        }
        .pending-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            background-color: white;
        }
        .pending-header {
            background-color: #f6c23e;
            color: #856404;
            padding: 25px;
            text-align: center;
        }
        .pending-body {
            padding: 40px;
        }
        .pending-icon {
            font-size: 4rem;
            color: #f6c23e;
            margin-bottom: 1.5rem;
        }
        .steps-container {
            margin-top: 2rem;
            counter-reset: step;
        }
        .step {
            position: relative;
            padding-left: 45px;
            margin-bottom: 1.5rem;
        }
        .step:before {
            counter-increment: step;
            content: counter(step);
            position: absolute;
            left: 0;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #f6c23e;
            color: white;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        .help-link {
            color: #4e73df;
            text-decoration: none;
        }
        .help-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="pending-container">
        <div class="pending-card">
            <div class="pending-header">
                <h3><i class="fas fa-exclamation-circle mr-2"></i> Account Verification Pending</h3>
                <p class="mb-0">Your provider account is awaiting admin verification</p>
            </div>
            <div class="pending-body text-center">
                <div class="pending-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                
                <h4 class="mb-3">Thank you for registering as a healthcare provider!</h4>
                <p class="text-muted mb-4">
                    Your account has been created successfully, but requires verification before you can access all features.
                    Our administrative team will review your credentials and information typically within 24-48 hours.
                </p>
                
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> You will receive an email when your