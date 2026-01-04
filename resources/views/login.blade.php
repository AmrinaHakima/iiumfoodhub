<form action="/login" method="POST">
    @csrf
    <h2>Login IIUMFoodHub</h2>
    @if($errors->any()) <p style="color:red">{{ $errors->first() }}</p> @endif
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <a href="/register">Don't have an account? Register</a>
</form>