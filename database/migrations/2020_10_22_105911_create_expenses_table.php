<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->string('name_expense', 50)->nullable(false);
            $table->string('description', 255);
            $table->decimal('unitary_value', 10, 2)->nullable(false);
            $table->integer('amount', 10);
            $table->decimal('discount', 3,2);
            $table->dateTime('data')->nullable(false);
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
        Schema::dropIfExists('expenses');
    }
}
