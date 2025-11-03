@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('content')
<h1 class="text-white mb-4">Tambah Buku</h1>

<form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        {{-- Kolom Kiri --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                @error('judul') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Kode Buku</label>
                <input type="text" name="kode_buku" class="form-control" value="{{ old('kode_buku') }}">
                @error('kode_buku') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Pengarang</label>
                <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}">
                @error('pengarang') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Kategori</label>
                <select class="form-control" name="kategori_buku[]" multiple="multiple">
                    @forelse ($kategori as $item)
                        <option value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                    @empty
                        <option disabled>Tidak ada kategori</option>
                    @endforelse
                </select>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
                @error('penerbit') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit') }}">
                @error('tahun_terbit') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group mb-3">
                <label class="text-white font-weight-bold">Gambar</label>
                <input type="file" name="gambar" class="form-control">
                @error('gambar') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary px-4">Simpan</button>
    </div>
</form>
@endsection
