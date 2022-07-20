<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unitermo;
use App\Monografia;
use App\Aluno;
use App\Orientador;
use App\OrientMonografia;

class MonografiaController extends Controller
{

    private $usuarioLogado;

    function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        if (empty($this->usuarioLogado)) {
            print "<script>alert('M1-Favor realizar login'); window.location.assign('" . env('APP_URL') . "'); </script>";
			return;
        }
    }

    /** 
     * Método que chama o cadastro do TCC
     * @var $numUSP número USP do aluno
     */
    function cadastroMonografia($numUSP = null) {

        $auth = PrincipalController::getPermissao("CADASTRO_TCC");

        if (ENV("APP_ENV") != "production") 
            var_dump($auth);

        if (!$auth) {
            unset($_COOKIE["loginUSP"]);
            print "<script>alert('M2-Usuário não autorizado'); window.location.assign('" . env('APP_URL') . "'); </script>";
			return;
        }

        $unitermos = Unitermo::all();
        $dadosAluno = Aluno::getDadosAluno(empty($numUSP)?$this->usuarioLogado->loginUsuario:$numUSP);
        $listaAlunosDupla = Aluno::getDadosAluno();
        $listaOrientadores = Orientador::all();

        $parametros = ["numUSPAluno"        => empty($numUSP)?$this->usuarioLogado->loginUsuario:$numUSP
                      ,"nomeAluno"          => $this->usuarioLogado->nomeUsuario //$dadosAluno->nome
                      ,"listaAlunosDupla"   => $listaAlunosDupla
                      ,"listaOrientadores"  => $listaOrientadores
                      ,"unitermos"          => $unitermos
                      ,"readonly"           => !empty($numUSP)?false:true
                      ];

        return view('alunos.cadastroTcc',$parametros);
    }
}
