<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replicado extends Model
{
    protected $connection = 'sqlsrv';
    
    /**
     * Método para pegar os dados de Alunos na tabela do replicado
     * 
     */
    function getDadosPessoas($codpes) {
        //Buscar no banco de dados replicado
        
        return array();

    }
}
