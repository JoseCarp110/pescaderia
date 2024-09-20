@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Panel de productos -->
        <div class="col-md-9">
            <h1 class="text-center my-4">
                {{ isset($esOferta) && $esOferta ? 'Ofertas Especiales' : 'Listado de Productos' }}
            </h1>

            <!-- Mensaje de éxito -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Buscador general -->
            <form action="{{ route('productos.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar productos..." value="{{ old('search', $search ?? '') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </div>
            </form>

            <!-- Filtros -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h4>Filtros</h4>

                    <!-- Filtro por más vendidos -->
                    <div class="form-group">
                        <label for="filtro_vendidos">Más Vendidos</label>
                        <select id="filtro_vendidos" class="form-control" onchange="applyFilter()">
                            <option value="">Selecciona una opción</option>
                            <option value="ventas_desc">Más vendidos</option>
                        </select>
                    </div>

                    <!-- Filtro por rango de precios -->
                    <div class="form-group">
                        <label for="rango_precios">Rango de Precios</label>
                        <input type="text" id="rango_precios" class="form-control" placeholder="Ej: 10-100" onchange="applyFilter()">
                    </div>

                    <!-- Filtro por orden de precio -->
                    <div class="form-group">
                        <label for="orden_precio">Ordenar por Precio</label>
                        <select id="orden_precio" class="form-control" onchange="applyFilter()">
                            <option value="">Selecciona una opción</option>
                            <option value="precio_asc">Menor a Mayor</option>
                            <option value="precio_desc">Mayor a Menor</option>
                        </select>
                    </div>

                    <!-- Filtro por categoría -->
                    <div class="form-group">
                        <label for="filtro_categoria">Categoría</label>
                        <select id="filtro_categoria" class="form-control" onchange="applyFilter()">
                            <option value="">Selecciona una categoría</option>
                            <option value="articulos_pesca">Artículos de Pesca</option>
                            <option value="alimentos">Alimentos</option>
                            <!-- Agrega más categorías aquí -->
                        </select>
                    </div>
                </div>

                <!-- Productos -->
                <div class="col-md-9">
                    <!-- Listado vertical de productos -->
                    <div class="row mt-4">
                        @foreach($productos as $producto)
                            <div class="col-12 mb-4">
                                <div class="card flex-row {{ $producto->es_oferta ? 'bg-warning text-white' : '' }}">
                                    <!-- Imagen del producto -->
                                    <img class="card-img-left img-fluid" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" 
                                        style="width: 150px; height: auto; object-fit: cover; margin: 10px;">

                                    <!-- Detalles del producto -->
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                                        <p class="card-text">{{ $producto->descripcion }}</p>
                                        <p class="card-text">
                                            <strong>Precio:</strong> 
                                            @if($producto->es_oferta && $producto->precio_oferta)
                                                <span style="font-size: 1.2em; font-weight: bold;">${{ $producto->precio_oferta }}</span>
                                                <span class="text-muted" style="text-decoration: line-through;">${{ $producto->precio }}</span>
                                            @else
                                                ${{ $producto->precio }}
                                            @endif
                                        </p>

                                        <!-- Opciones según el rol -->
                                        @if(Auth::check() && Auth::user()->role == 'admin')
                                            <!-- Botones de administrador: Editar y Eliminar -->
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-primary">Editar</a>
                                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">Eliminar</button>
                                                </form>
                                            </div>
                                        @else
                                            <!-- Botón de usuario común: Añadir al carrito -->
                                            <a href="#" class="btn btn-primary">Añadir al carrito</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function applyFilter() {
        const vendidos = document.getElementById('filtro_vendidos').value;
        const precios = document.getElementById('rango_precios').value;
        const ordenPrecio = document.getElementById('orden_precio').value;
        const categoria = document.getElementById('filtro_categoria').value;

        let url = new URL(window.location.href);

        if (vendidos) url.searchParams.set('vendidos', vendidos);
        if (precios) url.searchParams.set('precios', precios);
        if (ordenPrecio) url.searchParams.set('orden_precio', ordenPrecio);
        if (categoria) url.searchParams.set('categoria', categoria);

        window.location.href = url.toString();
    }
</script>

@endsection







