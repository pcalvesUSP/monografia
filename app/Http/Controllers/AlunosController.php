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
    public function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        if (empty($this->usuarioLogado)) {
            print "<script>alert('Favor realizar login'); window.location.assign('http://localhost:8000'); </script>";
			return;
        }
    }

    /**
     * Método que acessa por default a monografia cadastrada.
     */
    public function index() {
        $monografia = new Monografia;
        $monografia->cadastroMonografia();
    }

    public function verificarParecer($monografia_id) {

        

    }
    
}
