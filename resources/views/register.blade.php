<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | IIUMFoodHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-teal: #008080;
            --light-teal: #e0f2f1;
            --dark-teal: #006666;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-teal), #4db6ac);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-card h2 {
            color: var(--primary-teal);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.2rem;
            text-align: left;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-teal);
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid var(--light-teal);
            border-radius: 8px;
            outline: none;
            box-sizing: border-box;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: var(--primary-teal);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-teal);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: var(--dark-teal);
        }

        .footer-links {
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .footer-links a {
            color: var(--primary-teal);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="register-card">
    <i class="fa-solid fa-user-plus" style="font-size: 3rem; color: #008080; margin-bottom: 10px;"></i>
    <h2>Create Account</h2>
    <p class="subtitle">Join the IIUMFoodHub community</p>

    <form action="{{ url('/register') }}" method="POST">
        @csrf
        
        <div class="input-group">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Create Password" required>
        </div>

        <button type="submit">Register Now</button>
    </form>

    <div class="footer-links">
        Already have an account? <a href="{{ url('/login') }}">Login here</a>
    </div>
</div>
</body>
</html>