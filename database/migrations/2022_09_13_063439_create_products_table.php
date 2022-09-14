<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->default(0);
            $table->unsignedBigInteger('catalogue_id');
            $table->string('name');
            $table->decimal('price')->default(0);
            $table->decimal('price_promotion')->default(0);
            $table->longText('description')->nullable();
            $table->text('canonical');
            $table->unsignedBigInteger('user_id')->default(0);
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
        Schema::dropIfExists('products');
    }
};
