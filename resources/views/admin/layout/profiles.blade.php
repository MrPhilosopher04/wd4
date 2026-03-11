@extends('admin.dashboard')

@section('content')
<main class="main-content">
    <div class="page-header">
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <span class="sep">/</span>
            <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none;">Dashboard</a>
            <span class="sep">/</span>
            <span class="current">Profiles</span>
        </div>
        <h2 id="pageTitle">User Profiles</h2>
        <p id="pageDesc">Kelola data profil pengguna.</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-id-card"></i> Daftar Profil Pengguna</div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pengguna</th>
                        <th>Jabatan</th>
                        <th>Jurusan</th>
                        <th>Unit Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $i => $profile)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $profile->user->name ?? 'N/A' }}</td>
                        <td>{{ $profile->jabatan ?? 'N/A' }}</td>
                        <td>{{ $profile->nama_jurusan ?? 'N/A' }}</td>
                        <td>{{ $profile->nama_unit ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Belum ada data profil.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
