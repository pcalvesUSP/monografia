<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Monografia extends Model
{
    protected $connection = 'mysql';
    
    public array $idAlunos;
    public array $idOrientadores;


    function setIdAluno (array $idAluno) {
        $this->idAlunos = $idAluno;
    }

    function setIdOrientador (array $idOrient) {
        $this->idOrientadores = $idOrient;
    }

    /** Grupo de Get */
    function getIdAluno () {
        return $this->idAlunos;
    }

    function getIdOrientador () {
        return $this->idOrientadores;
    }

    public function listMonografia($id_orientador = 0) {
        return $this->getMonografia(0,$id_orientador);
    }

    public function getMonografia($id = 0, $orientador_id = 0) {
        $alunos = array();
        $orientadores = array();

        $build = 
            $this->select("monografias.*", "o.id as numUspOrientador", "o.nome as nomeOrientador",
                          "alunos.id as numUspAluno", "alunos.nome as nomeAluno"
                         ) 
                 ->join("orient_monografia as om","om.monografia_id", "=" ,"monografias.id")
                 ->join("orientadors as o","o.id", "=", "om.orientador_id")
                 ->join("alunos","alunos.monografia_id","=","monografias.id");
        
        if ($id > 0)
            $build->where("monografias.id", $id);

        if ($id == 0 && $orientador_id > 0) {
            $lOr = DB::table('orient_monografia')
                     ->select('monografia_id')
                     ->where('orientador_id', '=', $orientador_id)
                     ->get();

            $arrArg = [];
            foreach ($lOr as $orientId) {
                $arrArg[] = $orientId->monografia_id;
            }

            $build->whereIn('monografias.id', $arrArg);
        }
    $build->orderBy("monografias.ano")->orderBy("alunos.nome");
        
        $listMonografia = $build->get();
        
        foreach($listMonografia as $objMonografia) {
            if ($id > 0) {
                $alunos[] = $objMonografia->numUspAluno;
                $orientadores[] = $objMonografia->numUspOrientador;
            } else {
                $alunos[$objMonografia->id] = $objMonografia->numUspAluno;
                $orientadores[$objMonografia->id] = $objMonografia->numUspOrientador;               
            }
        }

        $this->setIdAluno = $alunos;
        $this->setIdOrientador = $orientadores;
        
        return $listMonografia;
    }
}
