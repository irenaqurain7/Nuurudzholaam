@extends('student.layout')

@section('student-content')
<style>
    :root {
        --primary: #2d5016;
        --text-primary: #1a1a1a;
        --text-secondary: #666;
        --text-muted: #999;
        --border: #e5e5e5;
        --bg-light: #f9f9f9;
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .page-header p {
        color: var(--text-secondary);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    .section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .section h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.6rem 0.875rem;
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 0.95rem;
        color: var(--text-primary);
        background-color: white;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(45, 80, 22, 0.1);
    }

    .form-helper {
        display: block;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
    }

    .preview-container {
        border: 2px dashed var(--border);
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background-color: var(--bg-light);
        margin: 1rem 0;
    }

    .preview-image {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        display: none;
    }

    .preview-placeholder {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .btn {
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        width: 100%;
        justify-content: center;
        margin-bottom: 0.75rem;
    }

    .btn-primary:hover {
        background-color: #1f3a0f;
    }

    .btn-secondary {
        background-color: white;
        border: 1.5px solid var(--primary);
        color: var(--primary);
        width: 100%;
        justify-content: center;
    }

    .btn-secondary:hover {
        background-color: var(--primary);
        color: white;
    }

    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.3rem;
    }

    .current-photo {
        border-radius: 8px;
        object-fit: cover;
        max-width: 100%;
        margin: 1rem 0;
    }

    .current-photo-placeholder {
        background-color: var(--bg-light);
        border-radius: 8px;
        padding: 3rem;
        text-align: center;
        color: var(--text-muted);
    }

    .current-photo-placeholder i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .form-mb {
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.5rem;
        }

        .section {
            padding: 1.5rem;
        }
    }
</style>

<div class="page-header">
    <h1>Ubah Foto Profil</h1>
    <p>Pilih foto baru untuk profil Anda</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('student.upload-photo.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section">
                <h5><i class="fas fa-image"></i>Pilih Foto</h5>

                <div class="form-group form-mb">
                    <label for="photo">Foto (JPG, PNG, GIF)</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" required onchange="previewImage(event)">
                    <span class="form-helper">Maksimal 2MB</span>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group form-mb">
                    <label>Preview Foto</label>
                    <div class="preview-container">
                        <img id="imagePreview" src="" alt="Preview" class="preview-image">
                        <div id="noPreview" class="preview-placeholder">
                            <i class="fas fa-image fa-2x" style="color: #ddd;"></i>
                            <p>Pratinjau akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i>Simpan Foto
                    </button>
                </div>
                <a href="{{ route('student.profile') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="section">
            <h5><i class="fas fa-camera"></i>Foto Saat Ini</h5>

            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="current-photo" style="width: 100%; height: 200px;">
            @else
                <div class="current-photo-placeholder">
                    <i class="fas fa-user-circle"></i>
                    <p>Belum ada foto profil</p>
                </div>
            @endif
        </div>

        <div class="section" style="background-color: #fafafa; border-color: var(--border);">
            <h5><i class="fas fa-info-circle"></i>Tips</h5>
            <p style="font-size: 0.9rem; color: var(--text-secondary); margin: 0; line-height: 1.5;">
                Gunakan foto yang jelas dan profesional. Format yang didukung: JPG, PNG, GIF dengan ukuran maksimal 2MB.
            </p>
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
