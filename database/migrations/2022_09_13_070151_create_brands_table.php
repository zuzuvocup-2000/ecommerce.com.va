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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catalogue_id');
            $table->text('keyword');
            $table->text('image')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id_created')->default(0);
            $table->unsignedBigInteger('user_id_updated')->default(0);
            $table->foreign('user_id_created')
                ->references('id')
                ->on('users');
            $table->foreign('user_id_updated')
                ->references('id')
                ->on('users');
            $table->foreign('catalogue_id')
                ->references('id')
                ->on('brands_catalogue')
                ->onDelete('cascade');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
};
