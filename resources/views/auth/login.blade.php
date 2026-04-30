<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CraveCart | Login</title>
    <style>
        :root {
            --bg-cream: #f3e3cb;
            --cc-red: #dd0d22;
            --cc-orange: #ff4a00;
            --cc-pink: #ff9b9e;
        }

        body {
            background-color: var(--bg-cream);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 350px;
            border-bottom: 5px solid var(--cc-orange);
        }

        h2 { 
            color: var(--cc-red); 
            text-align: center; 
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-group { margin-bottom: 15px; }

        label { font-size: 0.9rem; color: #555; display: block; margin-bottom: 5px; }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--cc-pink);
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
        }

        input:focus { border-color: var(--cc-red); }

        button {
            width: 100%;
            background-color: var(--cc-red);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover { background-color: var(--cc-orange); }

        .footer-links {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
        }

        .footer-links a { color: var(--cc-orange); text-decoration: none; font-weight: bold; }
        
        .error-list { color: var(--cc-red); font-size: 0.8rem; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>CraveCart</h2>

        @if ($errors->any())
            <div class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">LOGIN</button>
        </form>

        <div class="footer-links">
            <p>New to CraveCart? <a href="{{ route('register') }}">Create Account</a></p>
        </div>
    </div>

</body>
</html>