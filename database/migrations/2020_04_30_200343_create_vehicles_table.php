<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
        $table->increments('id')->nullable(false);
            //  $table->integer('user_id')->unsigned();
            //  $table->foreign('user_id')->references('id')->onDelete('cascade');
            $table->string('brand', 30)->nullable(false);
            $table->string('model', 30)->nullable(false);
            $table->string('placa', 30)->unique();
            $table->integer('year')->unsigned()->nullable(false);
            $table->string('situacao', 50)->nullable(false);
            $table->string('descricao', 255)->nullable(false);
        
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
        Schema::dropIfExists('vehicles');
    }
}
