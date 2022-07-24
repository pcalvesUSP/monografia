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
            print "<script>alert('A1-Favor realizar login'); window.location.assign('http://localhost:8000'); </script>";
			return;
        }

        if ($this->usuarioLogado->permissao && 
            ( $this->usuarioLogado->vinculo[0]->tipoFuncao != "ALUNOGR" ||
            $this->usuarioLogado->vinculo[0]->tipoFuncao != "SUPER") ) {
                
            return PrincipalController::logout('A2-Usuário sem acesso a esta parte do sistema');
        }

    }

    /**
     * Método que acessa por default a monografia cadastrada.
     */
    public function index() {
        $monografia = new MonografiaController;
        $monografia->cadastroMonografia();
    }

    public function verificarParecer($monografia_id) {

        

    }
    
}
