<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'imagen_url', 'precio', 'es_oferta', 'precio_oferta', 'categoria_id','cantidad'];

    // Relacion con la Tabla Categorias.
    public function categoria()
    {
    return $this->belongsTo(Categoria::class);
    }

    // Relacion con la tabla Productos:
    public function pedidos()
    {
    return $this->belongsToMany(Pedido::class, 'pedido_producto')->withPivot('cantidad', 'precio');
    }

    
    public function getImagenUrlAttribute()
    {
    $ruta = $this->attributes['imagen_url'] ?? null;

    if ($ruta && file_exists(public_path('storage/' . $ruta))) {
        return asset('storage/' . $ruta);
    } else {
        return asset('images/default.jpg');
    }
    }


}
