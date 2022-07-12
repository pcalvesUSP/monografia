<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunosController extends Controller
{
    //
    private $usuarioLogado;
    /**
     * Método Construtor
     */
    function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        if (empty($this->usuarioLogado)) {
            print "<script>alert('Favor realizar login'); window.location.assign('http://localhost:8000'); </script>";
			return;
        }
        $this->usuarioLogado = json_decode($this->usuarioLogado);
    }

    /** 
     * Método que chama o cadastro do TCC
     * @param numUSP número USP do aluno
     */
    function cadastroTcc($numUSP) {

        /*if (!$this->usuarioLogado->vinculo->tipoVinculo == "ALUNOGR") {
            unset($_COOKIE["loginUSP"]);
            print "<script>alert('Favor realizar login'); window.location.assign('http://localhost:8000'); </script>";
			return;
        }*/

        $parametros = ["numUSP" => $numUSP
                      ,"nomeUsuario" => $this->usuarioLogado->nomeUsuario];

        return view('alunos.cadastroTcc',$parametros);
    }
}
