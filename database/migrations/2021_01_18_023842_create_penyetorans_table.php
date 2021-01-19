<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyetoransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyetorans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nasabah');
            $table->unsignedBigInteger('jenis_sampah');
            $table->integer('berat');
            $table->integer('penghasilan');
            $table->timestamps();

            $table->foreign('id_nasabah')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jenis_sampah')->references('id')->on('jenis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyetorans');
    }
}
