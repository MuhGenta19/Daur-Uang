<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisSampahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_sampah', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('https://via.placeholder.com/150');
            $table->string('nama_kategori');
            $table->string('harga');
            $table->string('stok_gudang');
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
        Schema::dropIfExists('jenis_sampah');
    }
}
