<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orientador;

class OrientadorController extends Controller
{
    function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        if (empty($this->usuarioLogado)) {
            print "<script>alert('O1-Favor realizar login'); window.location.assign('" . env('APP_URL') . "'); </script>";
			return;
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
