@extends('admin.dashboard')

@section('content')
<main class="main-content">
    <div class="page-header">
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <span class="sep">/</span>
            <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none;">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('users.index') }}" style="color: inherit; text-decoration: none;">Users</a>
            <span class="sep">/</span>
            <span class="current">Edit Pengguna</span>
        </div>
        <h2 id="pageTitle">Edit Pengguna</h2>
        <p id="pageDesc">Ubah data pengguna yang sudah ada di sistem.</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-edit"></i> Formulir Edit Pengguna</div>
        </div>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" value="{{ $user->nik }}" required>
                </div>
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select id="role_id" name="role_id" required>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password Baru (Opsional)</label>
                    <input type="password" id="password" name="password">
                    <small>Kosongkan jika tidak ingin mengubah password.</small>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</main>
@endsection
