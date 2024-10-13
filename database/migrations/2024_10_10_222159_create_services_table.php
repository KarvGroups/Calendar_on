<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('price')->nullable();
            $table->time('time')->nullable();
            $table->unsignedBigInteger('id_categorias');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_categorias')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('id_empresa')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}
