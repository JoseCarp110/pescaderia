@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h2 class="mb-4">Gestión de Pedidos</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($mensaje))
        <!-- Mensaje cuando no hay pedidos -->
        <div class="alert alert-info">
            <h4>{{ $mensaje }}</h4>
            <p>Actualmente no hay ningún pedido registrado en el sistema.</p>
        </div>

        <div>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Volver al Inicio</a>
        </div>
    @else
        <!-- Tabla de pedidos cuando hay datos -->
        <table class="table table-bordered text-center">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->user->name }}</td>
                        <td>${{ $pedido->total }}</td>
                        <td>{{ ucfirst($pedido->status) }}</td>
                        <td>
                            <form action="{{ route('pedidos.updateStatus', $pedido->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="form-control">
                                    <option value="pendiente" {{ $pedido->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="enviado" {{ $pedido->status == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                    <option value="entregado" {{ $pedido->status == 'entregado' ? 'selected' : '' }}>Entregado</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
