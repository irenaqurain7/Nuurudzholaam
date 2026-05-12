@extends('teacher.layout')

@section('teacher-content')
<h1 class="h2 mb-4">Ubah Foto Profil</h1>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('teacher.upload-photo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="photo" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" required onchange="previewImage(event)">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Preview Foto</label>
                        <div class="text-center">
                            <img id="imagePreview" src="" alt="Preview" style="max-width: 100%; max-height: 300px; display: none;" class="rounded border">
                            @if(!isset($imagePreview))
                                <div id="noPreview" class="bg-light p-5 rounded border">
                                    <p class="text-muted">Pratinjau akan ditampilkan di sini</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Foto
                    </button>
                    <a href="{{ route('teacher.profile') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Foto Profil Saat Ini</h5>
            </div>
            <div class="card-body text-center">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="img-fluid rounded" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light p-5 rounded">
                        <i class="fas fa-user-circle fa-5x text-muted"></i>
                        <p class="text-muted mt-3">Belum ada foto profil</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const noPreview = document.getElementById('noPreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (noPreview) noPreview.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
