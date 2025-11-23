<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistem CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/glass-theme.css') }}">
</head>
<body class="d-flex align-items-center" style="height:100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4"> 
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4" style="color: #ff69b4;">Login Admin</h4>
                        
                        @if(session('error'))
                            <div class="alert alert-danger text-center py-2">{{ session('error') }}</div>
                        @endif
                        
                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-muted small">Email Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="admin@gmail.com">
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted small">Password</label>
                                <input type="password" name="password" class="form-control" required placeholder="******">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Masuk Sekarang</button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-3 text-muted small">&copy; {{ date('Y') }} Sistem Pink White</p>
            </div>
        </div>
    </div>
</body>
</html>