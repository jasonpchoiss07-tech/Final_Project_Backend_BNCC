<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChipiChapa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); min-height: 100vh; display:flex; align-items:center; }
        .auth-card { border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.2); border: none; }
        .auth-logo { font-size: 2rem; font-weight: 800; color: #2c3e50; }
        .btn-auth { background: #3498db; border: none; padding: .75rem; font-weight: 600; border-radius: 8px; }
        .btn-auth:hover { background: #2980b9; }
        .form-control:focus { box-shadow: 0 0 0 .2rem rgba(52,152,219,.25); border-color: #3498db; }
        .input-group-text { background: #f8f9fa; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card auth-card p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="auth-logo"><i class="bi bi-shop text-primary"></i> ChipiChapa</div>
                        <p class="text-muted mt-1">Masuk ke akun Anda</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="contoh@gmail.com" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-auth btn-primary w-100 text-white">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Belum punya akun?
                            <a href="{{ route('register') }}" class="text-primary fw-semibold">Daftar di sini</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
