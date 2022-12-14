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
            $table->unsignedBigInteger('catalogue_id');
            $table->text('catalogue')->nullable();
            $table->unsignedBigInteger('brand_id')->default(0);
            $table->decimal('price')->default(0);
            $table->decimal('price_promotion')->default(0);
            $table->text('image')->nullable();
            $table->longtext('album')->nullable();
            $table->unsignedBigInteger('viewed')->default(0);
            $table->smallInteger('rate')->default(0);
            $table->tinyInteger('hot')->default(0);
            $table->tinyInteger('publish')->default(0);
            $table->tinyInteger('trash')->default(0);
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
                ->on('products_catalogue')
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
        Schema::dropIfExists('products');
    }
};
