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
        Schema::create('products_catalogue', function (Blueprint $table) {
            $table->id();
            $table->nestedSet();
            $table->text('image')->nullable();
            $table->longtext('album')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_catalogue', function (Blueprint $table) {
            $table->dropNestedSet();
        });
        Schema::dropIfExists('products_catalogue');
    }
};
