<?php
session_start();

// Basic Logic to handle form submissions
$message = "";
$view = isset($_GET['view']) ? $_GET['view'] : 'login';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        // Logic for registration would go here (e.g., saving to database)
        $message = "Registration successful! Please login.";
        $view = 'login';
    } elseif (isset($_POST['login'])) {
        // Logic for login (e.g., verifying credentials)
        // Redirecting to the main app (index.php)
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIUMFoodHub - Auth</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #55b9c2; --bg: #f5f5f5; --text-dark: #333; --text-light: #777; }
        body { font-family: 'Segoe UI', sans-serif; background: #333; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        
        .phone-screen { 
            width: 375px; height: 812px; background: white; 
            position: relative; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); border-radius: 20px;
        }

        /* Branding Section */
        .brand-section { 
            background: var(--primary); color: white; 
            padding: 60px 30px; text-align: center;
            border-bottom-left-radius: 50px; border-bottom-right-radius: 50px;
        }
        .brand-section h1 { margin: 0; font-size: 32px; }
        .brand-section p { margin: 10px 0 0; opacity: 0.9; font-size: 14px; }

        .form-container { padding: 40px 30px; }
        .form-title { font-size: 22px; font-weight: bold; color: var(--text-dark); margin-bottom: 25px; }

        .input-group { margin-bottom: 20px; position: relative; }
        .input-group i { 
            position: absolute; left: 15px; top: 50%; 
            transform: translateY(-50%); color: var(--primary); 
        }
        .input-group input {
            width: 100%; padding: 12px 15px 12px 45px;
            border: 1px solid #ddd; border-radius: 10px;
            box-sizing: border-box; outline: none; font-size: 14px;
            transition: 0.3s;
        }
        .input-group input:focus { border-color: var(--primary); box-shadow: 0 0 5px rgba(85, 185, 194, 0.3); }

        .btn-main {
            width: 100%; background: var(--primary); color: white;
            border: none; padding: 15px; border-radius: 10px;
            font-size: 16px; font-weight: bold; cursor: pointer;
            margin-top: 10px; box-shadow: 0 4px 10px rgba(85, 185, 194, 0.4);
        }

        .switch-text { text-align: center; margin-top: 25px; font-size: 14px; color: var(--text-light); }
        .switch-text a { color: var(--primary); text-decoration: none; font-weight: bold; }

        .alert { 
            background: #d4edda; color: #155724; padding: 10px; 
            border-radius: 8px; margin-bottom: 15px; font-size: 13px; text-align: center; 
        }
    </style>
</head>
<body>

<div class="phone-screen">
    <div class="brand-section">
        <h1>IIUMFoodHub</h1>
        <p>Your favorite campus meals, delivered.</p>
    </div>

    <div class="form-container">
        <?php if($message): ?>
            <div class="alert"><?= $message ?></div>
        <?php endif; ?>

        <?php if($view == 'login'): ?>
            <!-- LOGIN FORM -->
            <div class="form-title">Login</div>
            <form action="auth.php?view=login" method="POST">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name="email" placeholder="Matric No / Email" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="btn-main">Login</button>
            </form>
            <div class="switch-text">
                Don't have an account? <a href="auth.php?view=register">Register here</a>
            </div>

        <?php else: ?>
            <!-- REGISTRATION FORM -->
            <div class="form-title">Create Account</div>
            <form action="auth.php?view=register" method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fullname" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="matric" placeholder="Matric Number" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="register" class="btn-main">Register</button>
            </form>
            <div class="switch-text">
                Already have an account? <a href="auth.php?view=login">Login here</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>