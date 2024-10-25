<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name')->unique();
            $table->decimal('product_price', 10, 2);
            $table->unsignedInteger('product_category_id'); // Changement ici
            $table->string('product_image');
            $table->string('product_description');
            $table->integer('status');
            $table->timestamps();
            
            // Clé étrangère
            $table->foreign('produit_category_id')->references('id')->on('categories')->onDelete('cascade');
        });*/
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
