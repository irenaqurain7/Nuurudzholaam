@extends('teacher.layout')

@section('teacher-content')
<style>
    :root {
        --hijau-islam: #2D4438;
        --hijau-light: #486E5A;
        --emas: #709D88;
        --emas-light: #E2ECE8;
        --text-dark: #1C2D25;
        --text-light: #5A7E6B;
        --bg-light: #F4F7F5;
        --putih: #ffffff;
    }

    .upload-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 30px;
    }

    .upload-card {
        background: var(--putih);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(45, 68, 56, 0.08);
        overflow: hidden;
    }

    .upload-card-header {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
        padding: 20px;
        font-weight: 600;
    }

    .upload-card-header i {
        margin-right: 10px;
    }

    .upload-card-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-group small {
        font-size: 13px;
        color: var(--text-light);
        display: block;
        margin-top: 6px;
    }

    .form-group input[type="file"] {
        display: block;
        width: 100%;
        padding: 12px 15px;
        border: 2px dashed var(--emas);
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: rgba(226, 236, 232, 0.3);
    }

    .form-group input[type="file"]:hover {
        border-color: var(--hijau-light);
        background-color: rgba(226, 236, 232, 0.5);
    }

    .preview-container {
        margin-bottom: 25px;
        text-align: center;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--emas-light);
        border-radius: 8px;
        overflow: hidden;
    }

    #imagePreview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        object-fit: cover;
    }

    #noPreview {
        color: var(--text-light);
        text-align: center;
        padding: 40px 20px;
    }

    .button-group {
        display: flex;
        gap: 12px;
    }

    .btn {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-upload {
        background: linear-gradient(135deg, var(--hijau-islam) 0%, var(--hijau-light) 100%);
        color: var(--putih);
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(45, 68, 56, 0.2);
    }

    .btn-cancel {
        background: var(--emas-light);
        color: var(--text-dark);
    }

    .btn-cancel:hover {
        background: var(--emas);
        color: var(--text-dark);
    }

    .current-photo {
        text-align: center;
    }

    .photo-display {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        margin: 0 auto 20px;
        border: 4px solid var(--emas);
        overflow: hidden;
        background-color: var(--emas-light);
        display: flex;
        align-items: center;
        justify-content: center;
        object-fit: cover;
    }

    .no-photo {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 15px;
        color: var(--text-light);
    }

    .no-photo i {
        font-size: 3rem;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .upload-container {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<h1 class="page-title">Ubah Foto Profil</h1>

<div class="upload-container">
    <!-- Upload Section -->
    <div class="upload-card">
        <div class="upload-card-header">
            <i class="fas fa-cloud-upload-alt"></i>Unggah Foto Baru
        </div>
        <div class="upload-card-body">
            <form action="{{ route('teacher.upload-photo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="photo">Pilih Foto <span style="color: #dc3545;">*</span></label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" required onchange="previewImage(event)">
                    <small>Format: JPG, PNG, GIF | Max: 2MB</small>
                    @error('photo')
                        <div style="color: #dc3545; font-size: 13px; margin-top: 8px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Preview Foto</label>
                    <div class="preview-container">
                        <img id="imagePreview" src="" alt="Preview" style="display: none;">
                        <div id="noPreview" class="no-photo">
                            <i class="fas fa-image"></i>
                            <span>Pratinjau akan ditampilkan di sini</span>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-upload">
                        <i class="fas fa-upload"></i>Unggah Foto
                    </button>
                    <a href="{{ route('teacher.profile') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Current Photo Section -->
    <div class="upload-card">
        <div class="upload-card-header">
            <i class="fas fa-image"></i>Foto Profil Saat Ini
        </div>
        <div class="upload-card-body current-photo">
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Current Profile" class="photo-display">
                <p style="color: var(--text-dark); font-weight: 600; margin-bottom: 10px;">Foto Aktif</p>
                <p style="color: var(--text-light); font-size: 13px; margin: 0;">Upload foto baru untuk menggantinya</p>
            @else
                <div class="no-photo" style="padding: 40px 20px; height: 100%;">
                    <i class="fas fa-user-circle"></i>
                    <span style="text-align: center;">Belum ada foto profil<br><small>Upload foto pertama Anda</small></span>
                </div>
            @endif
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
