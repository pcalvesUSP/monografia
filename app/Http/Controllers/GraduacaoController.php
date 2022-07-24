<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraduacaoController extends Controller
{
    private $usuarioLogado;
    
    /**
     * Método Construtor
     */
    public function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        if (empty($this->usuarioLogado)) {
            print "<script>alert('G1-Favor realizar login'); window.location.assign('http://localhost:8000'); </script>";
			return;
        }

        if ($this->usuarioLogado->permissao && 
            ( $this->usuarioLogado->vinculo[0]["tipoFuncao"] != "GRADUACAO" ||
            $this->usuarioLogado->vinculo[0]["tipoFuncao"] != "SUPER") ) {
                
            return PrincipalController::logout('G2-Usuário sem acesso a esta parte do sistema');
        }
    }

    public function index() {
        $Monografias = new MonografiaController();
        //return $Monografias->listMonografia($this->usuarioLogado->loginUsuario);
        return $Monografias->listMonografia();
    }
}
