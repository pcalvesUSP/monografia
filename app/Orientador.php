<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orientador extends Model
{
    /**
     * Método para pegar os dados de Docentes (Orientadores) na tabela do replicado
     * 
     */
    static function getDadosOrientador(int $codpes = 0) {
        //Buscar no banco de dados replicado
        $replicado = new Replicado;
        
        return $replicado->getDadosPessoas($codpes,"DOCENTE");
        
    }

    /**
     * Recupera todos os dados de Orientador
     */
    public function listOrientador($id_orientador, $id_monografias = 0) {

        $build = 
            $this->join("orient_monografia as om","om.orientador_id","=","orientadors.id")
                 ->select("orientadors.*","om.principal")
                 ->where("orientadors.id",$id_orientador);
        
        if ($id_monografias > 0) {
            $build->where("om.monografia_id",$id_monografias);
        }

        return $build->get();

    }
}
