@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="col-md-8">
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

           <!-- Categoría y Precio en la misma fila -->
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="categoria_id">Categoría</label>
        <select name="categoria_id" id="categoria_id" class="form-control">
            <option value="">Selecciona una categoría</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
            <!-- Opción para añadir nueva categoría -->
            <option value="nueva_categoria">Agregar nueva categoría</option>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="precio">Precio</label>
        <input type="number" name="precio" class="form-control" id="precio" required step="0.01">
    </div>
</div>

<script>
    document.getElementById('categoria_id').addEventListener('change', function() {
        if (this.value === 'nueva_categoria') {
            window.location.href = "{{ route('categorias.create') }}";
        }
    });
</script>
            <br>

            <!-- Imagen del Producto -->
            <div class="form-group">
                <label for="imagen">Imagen del Producto</label>
                <input type="file" name="imagen" class="form-control-file" id="imagen" required>
            </div>
            <br>

            <!-- Oferta Checkbox y Precio de Oferta Alineados -->
            <div class="form-row align-items-center" style="max-width: 600px;">
                <div class="form-group col-auto">
                    <label for="es_oferta" class="mr-2">Poner en Oferta</label>
                    <input type="checkbox" name="es_oferta" id="es_oferta" value="1" {{ old('es_oferta') ? 'checked' : '' }} onchange="toggleOferta()">
                </div>
                <div class="form-group col-auto d-flex align-items-center" style="margin-left: 20px;">
                    <label for="precio_oferta" class="mr-2" style="margin-right: 10px;">Precio de Oferta</label>
                    <input type="number" name="precio_oferta" id="precio_oferta" class="form-control" value="{{ old('precio_oferta') }}" style="width: 150px;" disabled>
                </div>
            </div>

            <!-- Botón de Enviar -->
            <button type="submit" class="btn btn-primary">Agregar Producto</button>
            <a href="{{ route('productos.index') }}" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</div>

<script>
    function toggleOferta() {
        const ofertaCheckbox = document.getElementById('es_oferta');
        const precioOfertaInput = document.getElementById('precio_oferta');
        precioOfertaInput.disabled = !ofertaCheckbox.checked;
    }

    // Inicializar al cargar la página
    window.onload = function() {
        toggleOferta();
    };
</script>

@endsection

