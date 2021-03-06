<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKkdvvtxtxctTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kkdvvtxtxct', function (Blueprint $table) {
            $table->increments('id');
            $table->string('masokk')->nullable();
            $table->string('madichvu')->nullable();
            $table->string('loaixe')->nullable();
            $table->string('tendichvu')->nullable();
            $table->string('qccl')->nullable();
            $table->string('dvt')->nullable();
            $table->double('giakk')->nullable();
            $table->string('trenkmlk')->nullable();
            $table->double('giakkden')->nullable();//Them
            $table->double('giakktl')->nullable();//Them
            $table->double('giakklk')->nullable();
            $table->string('trenkm')->nullable();
            $table->double('giakklkden')->nullable();//Them
            $table->double('giakklktl')->nullable();//Them
            $table->string('ghichu')->nullable();
            $table->string('thuevat')->nullable();
            $table->text('pag')->nullable();
            $table->text('ghichu_pag')->nullable();
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
        Schema::drop('kkdvvtxtxct');
    }
}
