@extends('admin.dashboard')

@section('content')
<main class="main-content">
    <div class="page-header">
        <div class="breadcrumb">
            <i class="fas fa-home"></i>
            <span class="sep">/</span>
            <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none;">Dashboard</a>
            <span class="sep">/</span>
            <a href="{{ route('roles.index') }}" style="color: inherit; text-decoration: none;">Roles</a>
            <span class="sep">/</span>
            <span class="current">Edit Role</span>
        </div>
        <h2 id="pageTitle">Edit Role</h2>
        <p id="pageDesc">Ubah data role yang sudah ada.</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-edit"></i> Formulir Edit Role</div>
        </div>
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="role_name">Nama Role</label>
                    <input type="text" id="role_name" name="role_name" value="{{ $role->role_name }}" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</main>
@endsection
