<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductosController extends Controller
{
    /**
     * Mostrar el formulario de creación.
     */
    public function create()
    {
        return view('productos.create');
    }

    
    /**
     * Guardar un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Subir la imagen
        if ($request->hasFile('imagen')) {
            $imageName = time().'.'.$request->imagen->extension();  
            $request->imagen->move(public_path('images'), $imageName);

            // Guardar el producto en la base de datos
            Producto::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'imagen_url' => '/images/' . $imageName,
            ]);
        }

        // Redirigir a la página de productos o mostrar un mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto agregado con éxito.');
    }

    
         /**
             * Mostrar la lista de productos.
           */
    public function index()
    {
        // Recuperar todos los productos desde la base de datos
        $productos = Producto::all();

        // Pasar los productos a la vista
        return view('productos.index', compact('productos'));
    }
}

