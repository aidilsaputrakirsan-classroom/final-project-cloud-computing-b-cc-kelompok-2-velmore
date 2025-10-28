@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="text-primary">Edit Buku</h1>
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Buku</h6>
        </div>
        <div class="card-body">
            <form action="/buku/{{ $buku->id }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row g-3">
                    {{-- Judul --}}
                    <div class="col-md-6">
                        <label for="Judul" class="text-primary font-weight-bold">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul) }}">
                        @error('judul')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kode Buku --}}
                    <div class="col-md-6">
                        <label for="kode_buku" class="text-primary font-weight-bold">Kode Buku</label>
                        <input type="text" name="kode_buku" class="form-control" value="{{ old('kode_buku',$buku->kode_buku) }}">
                        @error('kode_buku')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-6">
                        <label for="kategori" class="text-primary font-weight-bold">Kategori</label>
                        <select class="form-control" name="kategori_buku[]" id="multiselect" multiple="multiple">
                            @forelse ($kategori as $item)
                                <option value="{{ $item->id }}"
                                    {{ in_array($item->id, $buku->kategori_buku ?? []) ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @empty
                                <option disabled>Tidak ada kategori</option>
                            @endforelse
                        </select>
                        @error('kategori')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pengarang --}}
                    <div class="col-md-6">
                        <label for="pengarang" class="text-primary font-weight-bold">Pengarang</label>
                        <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $buku->pengarang) }}">
                        @error('pengarang')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Penerbit --}}
                    <div class="col-md-6">
                        <label for="penerbit" class="text-primary font-weight-bold">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit', $buku->penerbit) }}">
                        @error('penerbit')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tahun Terbit --}}
                    <div class="col-md-6">
                        <label for="tahun_terbit" class="text-primary font-weight-bold">Tahun Terbit</label>
                        <input type="text" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                        @error('tahun_terbit')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-12">
                        <label for="deskripsi" class="text-primary font-weight-bold">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="2">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Upload Gambar --}}
                    <div class="col-12">
                        <label for="gambar" class="text-primary font-weight-bold">Tambah Sampul Buku</label>
                        <input type="file" name="gambar" id="gambar" class="form-control">
                        @error('gambar')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end mt-3">
                    <a href="/buku" class="btn btn-danger mx-2">Kembali</a>
                    <button type="submit" class="btn btn-primary px-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('#multiselect').select2({
            allowClear: true,
            width: '100%'
        });
    </script>
@endsection
