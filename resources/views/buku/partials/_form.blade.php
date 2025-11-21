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
/* Default (light mode) */
.form-subtitle {
    color: #4b5563; /* abu-abu gelap */
}

/* Dark mode */
body.dark-mode .form-subtitle {
    color: #e5e7eb !important; /* abu terang */
}

</style>

<div class="card p-4">
    <h3>{{ $formTitle }}</h3>
    <p class="form-subtitle">{{ $formSubtitle }}</p>
    <hr>

    <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <label class="fw-bold">Judul Buku</label>
        <input class="form-control mb-3" name="judul" value="{{ $buku->judul ?? '' }}" required>

        <label class="fw-bold">Kode Buku</label>
        <input class="form-control mb-3" name="kode_buku" value="{{ $buku->kode_buku ?? '' }}" required>

        <label class="fw-bold">Pengarang</label>
        <input class="form-control mb-3" name="pengarang" value="{{ $buku->pengarang ?? '' }}" required>

        <label class="fw-bold">Penerbit</label>
        <input class="form-control mb-3" name="penerbit" value="{{ $buku->penerbit ?? '' }}" required>

        <label class="fw-bold">Tahun Terbit</label>
        <input class="form-control mb-3" name="tahun_terbit" value="{{ $buku->tahun_terbit ?? '' }}" required>

        <label class="fw-bold">Kategori</label>
        <select name="id_kategori" class="form-control mb-3" required>
            <option value="">-- pilih kategori --</option>
            @foreach($kategori as $k)
                <option value="{{ $k['id'] }}" 
                    {{ isset($buku) && $buku->id_kategori == $k['id'] ? 'selected' : '' }}>
                    {{ $k['nama'] }}
                </option>
            @endforeach
        </select>

        <label class="fw-bold">Deskripsi</label>
        <textarea class="form-control mb-3" name="deskripsi" required>{{ $buku->deskripsi ?? '' }}</textarea>

       <label class="fw-bold">Gambar Buku</label>
        <input id="gambar" type="file" class="form-control mb-3" name="gambar">

        <div id="imagePreview" style="display:none; margin-top:10px;"></div>

        <button class="btn btn-primary">Simpan</button>
        <a href="/buku" class="btn btn-secondary">Kembali</a>
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
