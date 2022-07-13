<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->int('ano');
            $table->timestamps();

            $table->date('dataInicioCadastro');
            $table->date('dataFimCadastro');
            $table->date('dataInicioAvaliacao');
            $table->date('dataFimAvaliacao');

            $table->primary('ano');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parametros');
    }
}
