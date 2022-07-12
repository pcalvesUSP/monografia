<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlunosController extends Controller
{
    //
    /**
     * Método Construtor
     */
    function __construct() {
        $login = PrincipalController::getDadosUsuario();
        if (empty($login)) {
            print "<script>alert('Favor realizar login'); window.location.assign('http://localhost:8000'); </script>";
			return;
        }
    }

    /** 
     * Método que chama o cadastro do TCC
     * @param numUSP número USP do aluno
     */
    function cadastroTcc($numUSP) {

        

        return view('alunos.cadastroTcc',['numUSP' => $numUSP]);
    }
}
