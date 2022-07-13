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
    }
    
}
