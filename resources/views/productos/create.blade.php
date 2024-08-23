@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Agregar Nuevo Producto</h1>

     <!-- Mensaje de éxito -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Formulario para agregar un nuevo producto -->
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Nombre del Producto -->
        <div class="form-group">
            <label for="nombre">Nombre del Producto</label>
            <input type="text" name="nombre" class="form-control" id="nombre" required>
        </div>

        <!-- Descripción del Producto -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control" id="descripcion" rows="3"></textarea>
        </div>

        <!-- Precio del Producto -->
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" name="precio" class="form-control" id="precio" required step="0.01">
        </div>

        <!-- Imagen del Producto -->
        <div class="form-group">
            <label for="imagen">Imagen del Producto</label>
            <input type="file" name="imagen" class="form-control-file" id="imagen" required>
        </div>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </form>
</div>
@endsection
