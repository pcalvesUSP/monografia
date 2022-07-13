<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->foreignId('id_aluno')->constrained();
            $table->foreignId('id_orientador')->constrained();
            $table->foreignId('id_monografia')->constrained();
            $table->dateTime('dataParecer',0);
            $table->text('parecer');
            $table->timestamps();

            $table->primary(['id_aluno', 'id_orientador', 'id_monografia', 'dataParecer']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avaliacoes');
    }
}
