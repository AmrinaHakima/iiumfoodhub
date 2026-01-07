<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | IIUMFoodHub</title>
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

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-card h2 {
            color: var(--primary-teal);
            margin-bottom: 1.5rem;
            font-weight: 700;
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

        .error-msg {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
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

<div class="login-card">
    <i class="fa-solid fa-bowl-food" style="font-size: 3rem; color: #008080; margin-bottom: 10px;"></i>
    <h2>IIUMFoodHub</h2>

    @if($errors->any()) 
        <div class="error-msg">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="input-group">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="input-group">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Log In</button>
    </form>
    <div class="footer-links">
        Don't have an account? <a href="{{ url('/register') }}">Register here</a>
    </div>
</div>
</body>
</html>