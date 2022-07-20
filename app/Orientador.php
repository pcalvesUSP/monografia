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
}
