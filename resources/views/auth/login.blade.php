<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    
    <div class="container">
        <h1>Login</h1>

        @if (session('error'))
            <div style="color: red; margin-bottom: 10px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <!-- Email Input -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email')
                <div style="color: red; font-size: 14px;">{{ $message }}</div>
            @enderror

            <!-- Password Input -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            @error('password')
                <div style="color: red; font-size: 14px;">{{ $message }}</div>
            @enderror

            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>
