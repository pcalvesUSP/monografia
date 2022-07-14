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
        
        Schema::table('monografias', function (Blueprint $table) {
            $table->dropForeign('monografias_unitermo1_foreign');
            $table->dropForeign('monografias_unitermo2_foreign');
            $table->dropForeign('monografias_unitermo3_foreign');

            $table->dropColumn('unitermo1');
            $table->dropColumn('unitermo2');
            $table->dropColumn('unitermo3');
        });
        
        Schema::dropIfExists('unitermos');
    }
}
