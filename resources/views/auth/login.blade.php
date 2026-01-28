<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Tesaurus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 50%, #a8dadc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 420px;
        }

        h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
            color: #1e56a0;
        }

        p {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        input {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9375rem;
        }

        input:focus {
            outline: none;
            border-color: #1e56a0;
        }

        .error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn {
            width: 100%;
            padding: 0.875rem;
            background: #1e56a0;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .btn:hover {
            background: #163d6f;
            transform: translateY(-1px);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .link {
            color: #1e56a0;
            text-decoration: none;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>📚 Admin Tesaurus</h1>
        <p>Silakan login untuk mengakses admin panel</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin: 0; font-weight: 400;">Ingat saya</label>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center;">
            <a href="{{ route('home') }}" class="link">← Kembali ke Website</a>
        </div>
    </div>
</body>
</html>
