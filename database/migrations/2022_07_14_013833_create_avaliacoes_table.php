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
            $table->foreignId('orientador_id')->constrained('orientadors');
            $table->foreignId('monografia_id')->constrained('monografias');
            $table->dateTime('dataParecer', 0);
            $table->text('parecer');
            $table->timestamps();

            $table->primary(['orientador_id', 'monografia_id', 'dataParecer']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        /*Schema::table('orient_monografia', function (Blueprint $table) {
            $table->dropForeign('avaliacoes_orientador_id_foreign');
            $table->dropForeign('avaliacoes_monografia_id_foreign');
        });*/
        Schema::dropIfExists('avaliacoes');
    }
}
