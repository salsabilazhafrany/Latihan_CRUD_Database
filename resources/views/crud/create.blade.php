<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/glass-theme.css') }}">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Tambah Data Baru</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('crud.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keahlian</label>
                                <input type="text" name="keahlian" class="form-control @error('keahlian') is-invalid @enderror" value="{{ old('keahlian') }}" required>
                                @error('keahlian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('crud.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>