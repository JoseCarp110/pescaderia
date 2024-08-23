@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Título del sitio -->
    <h1 class="text-center my-4">Acuario Burbujas</h1>

    <!-- Carrusel de Imágenes -->
    <div id="carouselExampleIndicators" class="carousel slide mb-5" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-200" src="https://via.placeholder.com/1200x400?text=Imagen+1" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-200" src="https://via.placeholder.com/1200x400?text=Imagen+2" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-200" src="https://via.placeholder.com/1200x400?text=Imagen+3" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Paneles con Productos en filas de 4 -->
    <div class="row mt-3">
        @foreach($productos->chunk(4) as $chunk)
            <div class="row w-100">
                @foreach($chunk as $producto)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img class="card-img-top img-fluid" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $producto->nombre }}</h5>
                                <p class="card-text">{{ $producto->descripcion }}</p>
                                <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio }}</p>
                                <a href="#" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- Panel Adicional para Otros Productos -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card-deck">
                @foreach($otrosProductos as $producto)
                    <div class="card">
                        <img class="card-img-top img-fluid" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="height: 150px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-text">{{ $producto->descripcion }}</p>
                            <a href="#" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
