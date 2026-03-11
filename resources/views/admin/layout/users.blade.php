@extends('admin.dashboard')

@section('content')
<main class="main-content">
    <div class="page-header">
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <span class="sep">/</span>
            <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none;">Dashboard</a>
            <span class="sep">/</span>
            <span class="current">Users</span>
        </div>
        <h2 id="pageTitle">User Management</h2>
        <p id="pageDesc">Tambah, edit, dan hapus data pengguna sistem.</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-users"></i> Daftar Pengguna</div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Role</th>
                        <th>Tgl. Dibuat</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->nik }}</td>
                        <td><span class="tag tag-{{ strtolower($user->role?->role_name ?? 'default') }}">{{ $user->role?->role_name ?? 'Tanpa Role' }}</span></td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn-action edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Belum ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
