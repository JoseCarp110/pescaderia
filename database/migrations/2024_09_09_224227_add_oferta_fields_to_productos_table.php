<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->boolean('es_oferta')->default(false)->after('precio');
        $table->decimal('precio_oferta', 8, 2)->nullable()->after('es_oferta');
    });
}

public function down(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn('es_oferta');
        $table->dropColumn('precio_oferta');
    });
}

};
