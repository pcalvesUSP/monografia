<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitermosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unitermos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('unitermo', 45);
        });

        Schema::table('monografias', function (Blueprint $table) {
            $table->foreignId('unitermo1')->constrained('unitermos');
            $table->foreignId('unitermo2')->constrained('unitermos');
            $table->foreignId('unitermo3')->constrained('unitermos');
            
            /*$table->bigInteger('unitermo1');
            $table->bigInteger('unitermo2');
            $table->bigInteger('unitermo3');

            $table->foreign('unitermo1')->references('id')->on('unitermos');
            $table->foreign('unitermo2')->references('id')->on('unitermos');
            $table->foreign('unitermo3')->references('id')->on('unitermos');*/

        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monografias', function (Blueprint $table) {
            $table->dropForeign('unitermo1');
            $table->dropForeign('unitermo2');
            $table->dropForeign('unitermo3');
        });
        
        Schema::dropIfExists('unitermos');
    }
}
