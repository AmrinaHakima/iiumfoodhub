<!DOCTYPE html>
<html>
<head>
    <title>IIUMFoodHub - Dashboard</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; margin: 0; }
        .header { background: #4FB0BD; color: white; padding: 20px; }
        .card { background: white; margin: 15px; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>IIUMFoodHub</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <form action="/logout" method="POST"> @csrf <button type="submit">Logout</button></form>
    </div>

    <div class="container">
        <h3>Select a Cafe</h3>
        <div class="card">
            <strong>Cafe Halimah</strong><br>
            <small>Mahallah Halimatus Saadiah</small>
        </div>
        <!-- Add more cafes here -->
    </div>
</body>
</html>