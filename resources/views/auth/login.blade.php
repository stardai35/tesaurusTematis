<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Tesaurus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 35%, #5ba89f 70%, #a8dadc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
        }

        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(30, 86, 160, 0.15), 0 0 40px rgba(0, 0, 0, 0.08);
        }

        .login-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .logo {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        h1 {
            font-size: 1.75rem;
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: #374151;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 0.875rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            background: #fafbfc;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #1e56a0;
            background: white;
            box-shadow: 0 0 0 3px rgba(30, 86, 160, 0.08);
        }

        input::placeholder {
            color: #9ca3af;
        }

        .form-error {
            color: #dc2626;
            font-size: 0.8125rem;
            margin-top: 0.375rem;
        }

        .remember-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            margin-top: 1.5rem;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #1e56a0;
        }

        .remember-group label {
            margin: 0;
            font-weight: 400;
            cursor: pointer;
            color: #6b7280;
        }

        .btn {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #1e56a0 0%, #2e7ea6 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(30, 86, 160, 0.25);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(30, 86, 160, 0.35);
        }

        .btn:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f3f4f6;
            text-align: center;
        }

        .back-link {
            color: #1e56a0;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .back-link:hover {
            color: #163d6f;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            .logo {
                font-size: 2.5rem;
                margin-bottom: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <!-- Header -->
            <div class="login-header">
                <span class="logo">📚</span>
                <h1>Admin Panel</h1>
                <p class="subtitle">Kelola Tesaurus Tematis Bahasa Indonesia</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="admin@tesaurus.local"
                        required 
                        autofocus
                    >
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        placeholder="Masukkan password"
                        required
                    >
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="remember-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn">Masuk</button>
            </form>

            <!-- Footer -->
            <div class="login-footer">
                <a href="{{ route('home') }}" class="back-link">← Kembali ke Website</a>
            </div>
        </div>
    </div>
</body>
</html>
