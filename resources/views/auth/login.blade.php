<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIPASTI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="auth-logo-icon">
                    <i class="fas fa-archive"></i>
                </div>
                <h2>SIPASTI</h2>
                <p>Sistem Informasi Pencatatan Arsip Statis Terintegrasi</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom: 16px;">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label">Username</label>
                    <div style="position: relative;">
                        <i class="fas fa-user"
                            style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:13px;"></i>
                        <input type="text" name="username" class="form-control" style="padding-left: 32px; width: 100%;"
                            placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 6px;">
                    <div style="display:flex; justify-content:space-between;">
                        <label class="form-label">Password</label>
                        <a href="#" style="font-size:12px; color:var(--accent); text-decoration:none;">Forgot
                            password?</a>
                    </div>
                    <div style="position: relative;">
                        <i class="fas fa-lock"
                            style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:13px;"></i>
                        <input type="password" name="password" id="passwordInput" class="form-control"
                            style="padding-left: 32px; padding-right: 36px; width: 100%;" placeholder="••••••••"
                            required>
                        <button type="button" onclick="togglePass()"
                            style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted);">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="check-row" style="margin: 12px 0 20px;">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="cursor:pointer;">Remember this device</label>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                    Sign In &nbsp;<i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="auth-footer">
                <p>Hanya untuk personel yang berwenang. Akses dipantau dan<br>dicatat oleh protokol keamanan Sistem
                    Manajemen Arsip.</p>
                <div style="margin-top:10px; display:flex; justify-content:center; gap:14px;">
                    <a href="#" style="color:var(--text-muted); font-size:11px; text-decoration:none;">🔒</a>
                    <a href="#" style="color:var(--text-muted); font-size:11px; text-decoration:none;">⚙️</a>
                </div>
            </div>
        </div>

        <div
            style="position:fixed; bottom:16px; left:0; right:0; text-align:center; font-size:11px; color:var(--text-muted); display:flex; justify-content:space-between; padding:0 24px;">
            <span>© 2026 Sistem Manajemen Arsip. Semua Hak Dilindungi.</span>
            <span>
                <a href="#" style="color:var(--text-muted); text-decoration:none; margin:0 8px;">Privacy Policy</a>
                <a href="#" style="color:var(--text-muted); text-decoration:none; margin:0 8px;">Terms of Service</a>
                <a href="#" style="color:var(--text-muted); text-decoration:none; margin:0 8px;">Contact Support</a>
            </span>
        </div>
    </div>

    <script>
        function togglePass() {
            const inp = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                inp.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
</body>

</html>