<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orientador;

class OrientadorController extends Controller
{
    function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        if (empty($this->usuarioLogado)) {
            return PrincipalController::logout('O1-Favor realizar login');
        }

        if ($this->usuarioLogado->permissao && 
            ($this->usuarioLogado->vinculo[0]->tipoFuncao != "ORIENTADOR" ||
            $this->usuarioLogado->vinculo[0]->tipoFuncao != "SUPER") ) {

            return PrincipalController::logout('O2-Usuário sem acesso a esta parte do sistema');
        }
    }
    
    public function index() {
        $Monografias = new MonografiaController();
        //return $Monografias->listMonografia($this->usuarioLogado->loginUsuario);
        return $Monografias->listMonografia(904133);
    }

    public function edicaoMonografia($idMonografia, $numUsp) {
        $Monografias = new MonografiaController();
        return $Monografias->cadastroMonografia($numUsp,$idMonografia);
    }
}
