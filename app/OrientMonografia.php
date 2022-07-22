<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrientMonografia extends Model
{
    protected $table = "orient_monografia";

    /**
     * Método que lista todos os orientadores de uma determinada monografia
     * @var $monografia_id Id da Monografia
     */
    static function listOrientMonografia(int $monografia_id) {
        $dadosOrientadores = 
            OrientMonografia::join("orientadors as o","o.id","=","orient_monografia.orientador_id")
                            ->where("m.id",$monografia_id)
                            ->get();
        return $dadosOrientadores;
    }
}
