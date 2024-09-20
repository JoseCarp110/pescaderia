@extends('layouts.app')

@section('content')
<div class="container">
    
    <!-- Carrusel de Imágenes -->
    <div id="carouselExampleIndicators" class="carousel slide mb-5" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/carruselpescaderia5.jpg') }}" alt="Primera promoción">
                <div class="carousel-caption d-none d-md-block">
                    <h5>¡Descuentos del 20% en productos seleccionados!</h5>
                    <p>Oferta válida hasta fin de mes.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/carruselpescaderia5.jpg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/carruselpescaderia5.jpg') }}" alt="Third slide">
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

<!-- Carrusel de Productos -->
<div id="productosCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($productos->chunk(4) as $index => $chunk)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="row">
                    @foreach($chunk as $producto)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img class="card-img-top img-fluid" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                                    <p class="card-text">{{ $producto->descripcion }}</p>
                                    <p class="card-text">
                                        <strong>Precio:</strong> 
                                        @if($producto->es_oferta && $producto->precio_oferta)
                                            <span class="text-danger">${{ $producto->precio_oferta }}</span>
                                            <span class="text-muted"><del>${{ $producto->precio }}</del></span>
                                        @else
                                            ${{ $producto->precio }}
                                        @endif
                                    </p>
                                    <a href="#" class="btn btn-primary">Comprar ahora</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($index == $productos->chunk(4)->count() - 1) <!-- Solo añade el botón en el último elemento -->
                    <div class="text-center mt-4">
                        <a href="{{ route('productos.index') }}" class="btn btn-primary">Ver más productos</a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#productosCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#productosCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- Productos Destacados -->
     <h2 class="text-center my-4">Productos Destacados</h2>
           <div id="productosDestacadosCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
               <div class="carousel-inner">
                   @foreach($productos->chunk(5) as $chunk)
                       <div class="carousel-item @if($loop->first) active @endif">
                          <div class="row">
                              @foreach($chunk as $producto)
                                <div class="col-md-2 mb-4">
                                   <div class="card h-100 border-0 shadow">
                                    <img class="card-img-top img-fluid" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                                      @if($producto->es_oferta)
                                      <span class="badge badge-danger">Oferta</span>
                                      @endif
                                       <div class="card-body text-center">
                                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                                         <p class="card-text text-muted">{{ $producto->descripcion }}</p>
                                         <p class="card-text">
                                           <strong>Precio:</strong>
                                              @if($producto->es_oferta && $producto->precio_oferta)
                                                <span class="text-danger">${{ $producto->precio_oferta }}</span>
                                                <span class="text-muted"><del>${{ $producto->precio }}</del></span>
                                              @else
                                                ${{ $producto->precio }}
                                              @endif
                                         </p>
                                         <a href="#" class="btn btn-primary btn-block">Comprar ahora</a>
                                       </div>
                                   </div>
                                </div>
                              @endforeach
                          </div>
                       </div>
                   @endforeach
               </div>
           <!-- Controles de navegación -->
               <a class="carousel-control-prev" href="#productosDestacadosCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
               </a>
               <a class="carousel-control-next" href="#productosDestacadosCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
               </a>
           </div>


<!-- OFERTAS ESPECIALES -->
 <h2 class="text-center my-4">Ofertas Especiales</h2>
  <div class="row mt-3">
    <!-- Primer producto como oferta del día -->
    @if($primerProducto = $productos->where('es_oferta', true)->first())
    <div class="col-md-4 mb-4">
        <div class="card h-100 bg-warning text-white">
            <div class="img-container">
                <img class="card-img-top" src="{{ $primerProducto->imagen_url }}" alt="{{ $primerProducto->nombre }}">
            </div>
            <div class="card-body text-center p-2">
                <h4 class="card-title">Oferta del Día: {{ $primerProducto->nombre }}</h4>
                <p class="card-text">{{ $primerProducto->descripcion }}</p>
                <p class="card-text"><strong>Precio:</strong> ${{ $primerProducto->precio_oferta }}</p>
                <a href="#" class="btn btn-dark btn-sm">Comprar ahora</a>
            </div>
        </div>
    </div>
    @endif

    <!-- Otros productos en el mismo panel OFERTAS -->
  <div class="col-md-8 mb-4">
    <div class="card h-100 bg-warning text-white">
        <div class="card-body p-0">
            <div id="ofertasProductosCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    @foreach($productos->where('es_oferta', true)->skip(1)->chunk(3) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row no-gutters">
                            @foreach($chunk as $producto)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 border-0 bg-warning text-white">
                                    <div class="img-container">
                                        <img class="card-img-top" src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                                    </div>
                                    <div class="card-body text-center p-2">
                                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                                        <p class="card-text">{{ $producto->descripcion }}</p>
                                        <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio_oferta }}</p>
                                        <a href="#" class="btn btn-dark btn-sm">Comprar ahora</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Botones de control -->
                <a class="carousel-control-prev" href="#ofertasProductosCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#ofertasProductosCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>

            <!-- Botón de "Ver más Ofertas" -->
            <div class="text-center mt-4">
                <a href="{{ route('productos.ofertas') }}" class="btn btn-dark">Ver más Ofertas</a>
            </div>
        </div>
    </div>
   </div>
 </div>

<h2 class="text-center my-4">Formas de Pago</h2>
<div class="row justify-content-center">
    <div class="col-md-1 text-center">
        <img src="images/logos/visa-logo.png" alt="Visa" class="img-fluid mb-2">
        <p>Visa</p>
    </div>
    <div class="col-md-1 text-center">
        <img src="images/logos/mastercard-logo.png" alt="Mastercard" class="img-fluid mb-2">
        <p>Mastercard</p>
    </div>
    <div class="col-md-1 text-center">
        <img src="images/logos/paypal-logo.png" alt="PayPal" class="img-fluid mb-2">
        <p>PayPal</p>
    </div>
    <!-- Agrega más métodos de pago -->
</div>
@endsection
