<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_categoria');
			$table->foreign('id_categoria')->references('id')->on('categorias')->onDelete('cascade');
            $table->char('sku', 100)->nullable();
            $table->char('nombre', 100);
            $table->char('descripcion', 255)->nullable();
            $table->char('precio', 50);
            $table->char('descuento', 2)->nullable();
            $table->char('stock', 10)->nullable();
			$table->boolean('has_stock')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
