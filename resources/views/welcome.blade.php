<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        /* styles.css */
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            background: url('{{ asset('image/desk.jpg') }}') no-repeat center center fixed;
            background-size: cover; /* Ensures the image covers the viewport */
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Semi-transparent overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
            z-index: 1; /* Ensures it sits below the content */
        }

        .landing-container {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            width: 90%;
            max-width: 1200px;
            color: #fff;
            z-index: 2; /* Ensures content is above the overlay */
        }

        .content {
            max-width: 50%;
            margin-top: 50px;
        }

        .content h1 {
            font-size: 3rem;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .content h2 {
            font-size: 1.5rem;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 30px;
            width: 350px; /* Increased width */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            color: #000;
            border: 3px solid #FFD700; /* Yellow border */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-box:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .login-box h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.6rem;
            font-weight: 600;
            color: #333;
        }

        .login-box form {
            display: flex;
            flex-direction: column;
        }

        .login-box label {
            margin-bottom: 5px;
            font-size: 1rem;
            font-weight: 500;
        }

        .login-box input {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        .login-box button {
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-box button:hover {
            background-color: #0056b3;
        }

        /* Error styling */
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            body,
            html {
                background-size: cover; /* Ensures better fit on smaller screens */
                background-position: center;
            }

            .content h1 {
                font-size: 2.5rem;
            }

            .content h2 {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 768px) {
            .landing-container {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .content {
                max-width: 100%;
                margin-top: 20px;
            }

            .login-box {
                width: 100%;
                max-width: 380px;
            }
        }

        @media (max-width: 480px) {
            body,
            html {
                background-size: cover;
                background-position: top center; /* Adjust for small screens */
            }

            .content h1 {
                font-size: 2rem;
            }

            .content h2 {
                font-size: 1rem;
            }

            .login-box {
                padding: 20px;
                box-shadow: none; /* Simplify shadow for smaller screens */
            }

            .login-box input,
            .login-box button {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="landing-container">
        <div class="content">
            <h1>LA UNION SENIOR HIGH SCHOOL</h1>
            <h2>Student Grading System</h2>
        </div>
        <div class="login-box">
            <h3>Sign In</h3>
            <form action="/login" method="POST">
                @csrf
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
