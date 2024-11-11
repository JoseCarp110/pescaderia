<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('user', 'productos')->get();
    
        // Verificar si no hay pedidos
        if ($pedidos->isEmpty()) {
            return view('pedidos.index')->with('mensaje', 'No hay pedidos cargados.');
        }
    
        return view('pedidos.index', compact('pedidos'));
    }

public function updateStatus(Request $request, $id)
{
    $pedido = Pedido::findOrFail($id);
    $pedido->status = $request->status;
    $pedido->save();

    return redirect()->route('pedidos.index')->with('success', 'Estado del pedido actualizado.');
}

public function checkout()
{
    $carrito = session()->get('carrito');

    if (empty($carrito)) {
        return redirect()->route('productos.index')->with('error', 'Tu carrito está vacío.');
    }

    $pedido = new Pedido();
    $pedido->user_id = auth()->id();  // Asume que el usuario está autenticado
    $pedido->total = array_sum(array_column($carrito, 'precio'));
    $pedido->save();

    foreach ($carrito as $id => $producto) {
        $pedido->productos()->attach($id, ['cantidad' => $producto['cantidad']]);
    }

    session()->forget('carrito');

    return redirect()->route('pedidos.index')->with('success', 'Pedido realizado con éxito.');
}


}
