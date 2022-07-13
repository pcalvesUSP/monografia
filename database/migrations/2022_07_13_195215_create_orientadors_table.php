<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrientadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //DB_PASSWORD=#EDjgtb!111
        Schema::create('orientadors', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->timestamps();
            $table->string('nome', 80);
            $table->string('password', 250)->nullable;
            $table->boolean('externo')->default(false);
            $table->foreignId('monografia_id')->constrained();
            
            $table->primary('id');
            $table->index(['id', 'monografia_id'])->unique();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orientadors');
    }
}
