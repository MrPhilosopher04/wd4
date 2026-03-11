@extends('admin.dashboard')

@section('content')
<main class="main-content">
    <div class="page-header">
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <span class="sep">/</span>
            <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none;">Dashboard</a>
            <span class="sep">/</span>
            <span class="current">Roles</span>
        </div>
        <h2 id="pageTitle">Role Management</h2>
        <p id="pageDesc">Tambah, edit, dan hapus data role pengguna.</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-shield-alt"></i> Daftar Role</div>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Tambah Role</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Role</th>
                        <th>Tgl. Dibuat</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $i => $role)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $role->role_name }}</td>
                        <td>{{ $role->created_at?->format('d-m-Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn-action edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">Belum ada data role.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
