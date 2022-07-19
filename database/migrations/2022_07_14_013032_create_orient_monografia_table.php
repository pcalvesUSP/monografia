<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrientMonografiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orient_monografia', function (Blueprint $table) {
            $table->foreignId('orientador_id')->constrained('orientadors');
            $table->foreignId('monografia_id')->constrained('monografias');
  
            $table->timestamps();

            $table->unique(['orientador_id', 'monografia_id']);

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
        Schema::dropIfExists('orient_monografia');
    }
}
