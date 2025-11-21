@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="theme-title mb-4">Edit Buku</h1>
@endsection

@section('content')
@include('buku.partials._form', [
    'formTitle' => 'Edit Buku',
    'formSubtitle' => 'Perbarui informasi dan sampul buku yang sudah ada',
    'actionUrl' => route('buku.update', $buku->id),
    'method' => 'PUT',
    'buku' => $buku,
    'kategori' => $kategori
])
@endsection
