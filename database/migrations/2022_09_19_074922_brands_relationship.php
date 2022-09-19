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
        Schema::create('brands_relationship', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalogue_id');
            $table->unsignedBigInteger('object_id');
            $table->foreign('catalogue_id')
                ->references('id')
                ->on('products_catalogue')
                ->onDelete('cascade');
            $table->foreign('object_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
