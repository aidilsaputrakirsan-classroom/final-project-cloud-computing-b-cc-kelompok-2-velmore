<style>
/* 🌗 THEME-AWARE FUTURISTIC STYLE */
.futuristic-form-card {
    border-radius: 25px;
    padding: 40px;
    backdrop-filter: blur(10px);
    transition: all 0.4s ease;
    border: 1px solid transparent;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.25);
}

/* Light Mode */
body.light-mode .futuristic-form-card {
    background: linear-gradient(135deg, rgba(250,250,250,0.8), rgba(240,240,240,0.7));
    border-color: rgba(200,200,200,0.4);
    color: #1a1a1a;
}
body.light-mode .theme-title { color: #1a1a1a; text-shadow: 0 0 10px rgba(79,172,254,0.2); }

/* Dark Mode */
body.dark-mode .futuristic-form-card {
    background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.03));
    border-color: rgba(255,255,255,0.15);
    color: white;
}
body.dark-mode .theme-title { color: white; text-shadow: 0 0 20px rgba(79,172,254,0.4); }

/* Label & Input */
.form-label-futuristic {
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.85rem;
    margin-bottom: 10px;
}
body.light-mode .form-label-futuristic { color: #667eea; }
body.dark-mode .form-label-futuristic { color: #a5b4fc; }

.form-control-futuristic {
    border-radius: 15px;
    padding: 15px 20px;
    font-size: 1rem;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}
body.light-mode .form-control-futuristic {
    background: rgba(255,255,255,0.9);
    color: #1a1a1a;
    border-color: rgba(0,0,0,0.05);
}
body.light-mode .form-control-futuristic:focus {
    border-color: #667eea;
    box-shadow: 0 0 10px rgba(102,126,234,0.3);
}
body.dark-mode .form-control-futuristic {
    background: rgba(255,255,255,0.08);
    color: white;
    border-color: rgba(255,255,255,0.1);
}
body.dark-mode .form-control-futuristic:focus {
    background: rgba(255,255,255,0.12);
    border-color: #667eea;
    box-shadow: 0 0 20px rgba(102,126,234,0.3);
}

/* File Upload */
.file-input-wrapper { position: relative; display: block; width: 100%; }
.file-input-wrapper input[type=file] { display: none; }

.file-input-label {
    border-radius: 15px;
    padding: 25px;
    text-align: center;
    border: 2px dashed;
    cursor: pointer;
    transition: all 0.3s ease;
}
body.light-mode .file-input-label {
    background: rgba(255,255,255,0.9);
    border-color: rgba(102,126,234,0.4);
    color: #1a1a1a;
}
body.light-mode .file-input-label:hover {
    background: rgba(102,126,234,0.1);
    border-color: #667eea;
}
body.dark-mode .file-input-label {
    background: rgba(255,255,255,0.08);
    border-color: rgba(102,126,234,0.5);
    color: rgba(255,255,255,0.7);
}
body.dark-mode .file-input-label:hover {
    background: rgba(255,255,255,0.12);
    border-color: #667eea;
}

/* Buttons */
.btn-futuristic {
    padding: 15px 45px;
    border-radius: 50px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.btn-primary-futuristic {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.btn-primary-futuristic:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(102,126,234,0.6);
}
.btn-secondary-futuristic {
    background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
    color: white;
}
.btn-secondary-futuristic:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(134,143,150,0.6);
}
</style>

<div class="futuristic-form-card">
    <div class="text-center mb-4">
        <h2>{{ $formTitle }}</h2>
        <p>{{ $formSubtitle }}</p>
    </div>

    <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div class="row">
            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="form-label-futuristic"><i class="fas fa-book me-2"></i>Judul Buku</label>
                    <input type="text" name="judul" class="form-control-futuristic"
                           value="{{ old('judul', $buku->judul ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label-futuristic"><i class="fas fa-barcode me-2"></i>Kode Buku</label>
                    <input type="text" name="kode_buku" class="form-control-futuristic"
                           value="{{ old('kode_buku', $buku->kode_buku ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label-futuristic"><i class="fas fa-user-edit me-2"></i>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control-futuristic"
                           value="{{ old('pengarang', $buku->pengarang ?? '') }}" required>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mb-4">
                    <label class="form-label-futuristic"><i class="fas fa-building me-2"></i>Penerbit</label>
                    <input type="text" name="penerbit" class="form-control-futuristic"
                           value="{{ old('penerbit', $buku->penerbit ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label-futuristic"><i class="fas fa-calendar-alt me-2"></i>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" min="1900" max="2100" class="form-control-futuristic"
                           value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label-futuristic"><i class="fas fa-align-left me-2"></i>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control-futuristic" required>{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Upload Gambar --}}
        <div class="mb-4">
            <label class="form-label-futuristic mb-3"><i class="fas fa-image me-2"></i>Sampul Buku</label>
            <div class="file-input-wrapper">
                <input type="file" name="gambar" id="gambar" accept="image/*" hidden>
                <label for="gambar" class="file-input-label">
                    <div class="file-input-icon"><i class="fas fa-cloud-upload-alt fa-3x"></i></div>
                    <div><strong>Klik untuk pilih/ubah sampul</strong><br><small>PNG, JPG, JPEG (Max. 2MB)</small></div>
                </label>
            </div>

            {{-- hanya tampilkan jika ada gambar --}}
            @if(!empty($buku?->gambar))
            <div class="image-preview mt-3 text-center" id="imagePreview">
                <img id="previewImg" src="{{ asset('storage/' . $buku->gambar) }}" alt="Sampul Buku"
                     style="max-width:180px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,0.25);transition:0.3s;">
            </div>
            @else
            <div class="image-preview mt-3 text-center" id="imagePreview" style="display:none;"></div>
            @endif
        </div>

        <div class="d-flex justify-content-end gap-3 mt-4">
            <a href="/buku" class="btn-futuristic btn-secondary-futuristic">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn-futuristic btn-primary-futuristic">
                <i class="fas fa-save me-2"></i>{{ $formTitle === 'Edit Buku' ? 'Simpan Perubahan' : 'Simpan Buku' }}
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputFile = document.getElementById('gambar');
    const previewContainer = document.getElementById('imagePreview');

    inputFile.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = event => {
            if (!previewContainer.querySelector('img')) {
                const img = document.createElement('img');
                img.id = 'previewImg';
                img.style.maxWidth = '180px';
                img.style.borderRadius = '15px';
                img.style.boxShadow = '0 5px 20px rgba(0,0,0,0.25)';
                previewContainer.appendChild(img);
            }
            const img = previewContainer.querySelector('img');
            img.src = event.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
});
</script>
