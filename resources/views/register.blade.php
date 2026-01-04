<form action="/register" method="POST">
    @csrf
    <h2>Register IIUMFoodHub</h2>
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
    <a href="/login">Already have an account? Login</a>
</form>