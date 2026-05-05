<x-layout>
    <style>
        .login-page {
            background-color: #f3e3cb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 350px;
            border-bottom: 5px solid #ff4a00;
        }

        .login-title {
            color: #dd0d22;
            text-align: center;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .login-group {
            margin-bottom: 15px;
        }

        .login-label {
            font-size: 0.9rem;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .login-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ff9b9e;
            border-radius: 8px;
            box-sizing: border-box;
            outline: none;
        }

        .login-input:focus {
            border-color: #dd0d22;
        }

        .login-button {
            width: 100%;
            background-color: #dd0d22;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: #ff4a00;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
        }

        .login-link {
            color: #ff4a00;
            text-decoration: none;
            font-weight: bold;
        }

        .login-error-list {
            color: #dd0d22;
            font-size: 0.8rem;
            margin-bottom: 10px;
            padding-left: 15px;
        }
    </style>

    <div class="login-page">
        <div class="login-card">
            <h2 class="login-title">CraveCart</h2>

            @if ($errors->any())
                <ul class="login-error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="login-group">
                    <label class="login-label">Email Address</label>
                    <input type="email" name="email" class="login-input" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="login-group">
                    <label class="login-label">Password</label>
                    <input type="password" name="password" class="login-input" required>
                </div>

                <button type="submit" class="login-button">LOGIN</button>
            </form>

            <div class="login-footer">
                <p>
                    New to CraveCart?
                    <a href="{{ route('register') }}" class="login-link">Create Account</a>
                </p>
            </div>
        </div>
    </div>
</x-layout>