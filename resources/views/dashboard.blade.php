<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Sistem CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/glass-theme.css') }}">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Sistem CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('crud.index') }}">Data CRUD</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-bold" href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5 text-center">
        <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5">
            <h2 class="mb-3">Selamat Datang, <span class="text-primary">{{ session('user') }}</span></h2>
            <p class="text-muted">Anda berhasil login ke sistem CRUD sederhana berbasis Laravel tanpa database.</p>
            <a href="{{ route('crud.index') }}" class="btn btn-success mt-3 align-self-center">
                Masuk ke Halaman CRUD
            </a>
        </div>
    </div>

</body>
</html>