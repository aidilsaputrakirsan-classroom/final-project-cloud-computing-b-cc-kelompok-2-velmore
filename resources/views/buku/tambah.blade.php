@extends('layout.main')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('judul')
    <h1 class="theme-title mb-4">Tambah Buku Baru</h1>
@endsection

@section('content')
@include('buku.partials._form', [
    'formTitle' => 'Tambah Buku Baru',
    'formSubtitle' => 'Lengkapi informasi buku dengan detail yang akurat',
    'actionUrl' => route('buku.store'),
    'method' => 'POST',
    'buku' => null
])
@endsection
