<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    private int $id;
    private string $nome;
    private int $monografia_id;
    
    function setId(int $id) {
        $this->id = $id;
    }

    function setNome(string $nome) {
        $this->nome = $nome;
    }

    function setMonografiaId(int $monografia_id) {
        $this->monografia_id = $monografia_id;
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getMonografiaId() {
        return $this->monografia_id;
    }
    
    /**
     * Método para pegar os dados de Alunos na tabela do replicado
     * 
     */
    static function getDadosAluno(int $codpes = 0) {
        //Buscar no banco de dados replicado
        $replicado = new Replicado;
        
        return $replicado->getDadosPessoas($codpes,"ALUNOGR");
        
    }
}
