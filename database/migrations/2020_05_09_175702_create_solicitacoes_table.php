<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('namesolicitante', 255)->nullable(false);
            $table->string('nameramal', 5)->nullable(false);
            $table->string('nameroteiro', 255)->nullable(false);
            $table->string('namefinalidade', 255)->nullable(false);
            $table->dateTime('datahorasaida')->nullable(false);
            $table->dateTime('datahoraretorno')->nullable(false);
            $table->string('nameusuario', 255)->nullable(false);

            $table->string('namemotorista', 255)->nullable(false);
            $table->string('veiculo', 255)->nullable(false);
            $table->dateTime('datahorasaidaautorizada')->nullable(false);
            $table->dateTime('datahoraretornoautorizada')->nullable(false);
            $table->integer('kminicial')->nullable(false);
            $table->integer('kmfinal')->nullable();
            $table->string('autorizacao', 50)->nullable(false);
            $table->date('data')->nullable(false);
            $table->string('observ', 255)->nullable(false);
            $table->string('statussolicitacao', 50)->default(' ');

            $table->string('justificativa', 255)->nullable(false);
            
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
        Schema::dropIfExists('solicitacoes');
    }
}
