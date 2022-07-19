<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonografiaController extends Controller
{

    private $usuarioLogado;

    function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
    }

    /** 
     * Método que chama o cadastro do TCC
     * @var $numUSP número USP do aluno
     */
    function cadastroMonografia($numUSP) {

        $auth = PrincipalController::getPermissao("CADASTRO_TCC");

        if (ENV("APP_ENV") != "production") 
            var_dump($auth);

        if (!$auth) {
            unset($_COOKIE["loginUSP"]);
            print "<script>alert('Favor realizar login'); window.location.assign('" . env('APP_URL') . "'); </script>";
			return;
        }

        $parametros = ["numUSP" => $numUSP
                      ,"nomeUsuario" => $this->usuarioLogado->nomeUsuario];

        return view('alunos.cadastroTcc',$parametros);
    }
}
