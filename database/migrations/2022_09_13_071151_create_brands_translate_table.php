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
        Schema::create('brands_translate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_id');
            $table->string('language');
            $table->text('name');
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->text('meta_title');
            $table->text('meta_description')->nullable();
            $table->text('canonical');
            $table->timestamps();
            $table->unsignedBigInteger('user_id_created')->default(0);
            $table->unsignedBigInteger('user_id_updated')->default(0);
            $table->foreign('user_id_created')
                ->references('id')
                ->on('users');
            $table->foreign('user_id_updated')
                ->references('id')
                ->on('users');
            $table->foreign('object_id')
                ->references('id')
                ->on('brands')
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
        Schema::dropIfExists('brands_translate');
    }
};
