@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Listado de Productos</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Primera fila con 4 paneles separados -->
    <div class="row mt-4">
        @foreach($productos->take(4) as $producto)  <!-- Solo toma los primeros 4 productos -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <img class="card-img-top img-fluid" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ $producto->descripcion }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio }}</p>
                        <a href="#" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Segunda fila con un único panel que contiene 4 productos -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                @foreach($productos->skip(4)->take(4) as $producto) <!-- Omite los primeros 4 y toma los siguientes 4 productos -->
                    <div class="col-md-3">
                        <div class="card mb-2">
                            <img class="card-img-top img-fluid" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="height: 100px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ $producto->nombre }}</h6>
                                <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

