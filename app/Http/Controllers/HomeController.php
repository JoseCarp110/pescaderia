<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /*  public function __construct()
    {
        $this->middleware('auth');
    }
 */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    $productos = Producto::all();
    $otrosProductos = []; 

    return view('home', [
        'productos' => $productos, 
        'otrosProductos' => $otrosProductos
    ]);
    }

    public function mostrarProductos()
    {
    // Obtén los productos desde la base de datos
    $productos = Producto::all();  // O usa cualquier otra lógica de consulta
    
    // Inicializa la variable $otrosProductos
    $otrosProductos = [];  // O alguna lógica alternativa si es necesario

    // Carga la vista y pasa los productos
    return view('home', [
        'productos' => $productos, 
        'otrosProductos' => $otrosProductos
    ]);
    }

}
