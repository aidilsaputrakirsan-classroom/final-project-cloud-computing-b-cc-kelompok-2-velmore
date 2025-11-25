@extends('layout.main')

@section('title', 'Activity Log')

@section('sidebar')
    @include('partials.admin-sidebar')
@endsection

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📜 Activity Log</h4>

            <!-- FILTER -->
            <form class="d-flex" method="GET" action="{{ route('admin.activity.log') }}">
                
                <input type="text" name="user_id" class="form-control me-2" 
                       placeholder="Cari berdasarkan User ID"
                       value="{{ request('user_id') }}">

                <input type="date" name="date" class="form-control me-2"
                       value="{{ request('date') }}">

                <button class="btn btn-primary" type="submit">
                    Filter
                </button>
            </form>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>User ID</th>
                            <th>Aksi</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($logs as $log)
                        <tr>
                            <td>{{ $log['user_id'] ?? '-' }}</td>
                            <td>{{ $log['action'] ?? '-' }}</td>
                            <td>{{ $log['ip_address'] ?? '-' }}</td>
                            <td style="max-width: 300px; white-space: wrap;">
                                {{ $log['user_agent'] ?? '-' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($log['created_at'])->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Tidak ada activity log ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

@endsection
