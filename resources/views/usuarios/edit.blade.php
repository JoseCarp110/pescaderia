@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Editar Usuario</h1>

    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Campo para el nombre -->
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $usuario->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para el correo electrónico -->
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $usuario->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para la contraseña actual -->
        <div class="form-group">
            <label for="current_password">Contraseña Actual</label>
            <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para la nueva contraseña -->
        <div class="form-group">
            <label for="new_password">Nueva Contraseña</label>
            <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror">
            @error('new_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para confirmar la nueva contraseña -->
        <div class="form-group">
            <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
        </div>

        <!-- Campo para el rol (solo visible para administradores y cuando no se edita a sí mismo) -->
        @if(Auth::user()->role == 'admin' && Auth::user()->id != $usuario->id)
        <div class="form-group">
            <label for="role">Rol</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $usuario->role == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        @endif
        
        <!-- Campo para subir foto de perfil -->
        <div class="form-group">
            <label for="profile_picture">Foto de Perfil</label>
            <input type="file" name="profile_picture" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror">
               @error('profile_picture')
                   <div class="invalid-feedback">{{ $message }}</div>
               @enderror
        </div>

        <!-- Botones de acción -->
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
