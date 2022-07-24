<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Senhaunica\Senhaunica;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

class PrincipalController extends Controller
{
    
    private $dadosUsuario;

    /**
     * Método Construtor
     */
    function __construct() {
        $this->dadosUsuario = PrincipalController::getDadosUsuario();
    }

    static function getDadosUsuario() {
        $user = isset($_COOKIE['loginUSP'])? json_decode($_COOKIE['loginUSP']):null;
        if (!empty($user))
            return (object)$user;
        elseif (session('SSloginUSP')) {
            $user = json_decode(session('SSloginUSP'));
            return (object)$user;
        } else {
            return null;
        }
    }

    function index() {
        //return view('home');
        return "<script> window.location.assign('".route('acesso')."');  </script>";
    }

    function acesso () {
        
        $usuario = $this->dadosUsuario;
        $vinculo = isset($usuario->vinculo)?$usuario->vinculo:null;
        
        if (empty($vinculo)) {
            return $this->logout('P1-Você não tem acesso ao sistema. Entre em contato com o Serviço de Graduacao.');
        }

        foreach ( $vinculo as $valor ) {
            $valor = (object)$valor;
            
            if ($valor->tipoFuncao == "ALUNOGR") {
                return "<script>window.location.assign('".route('alunos.index')."');  </script>";
            } elseif ($valor->tipoFuncao == "ORIENTADOR") {
                return "<script>window.location.assign('".route('orientador.index')."');  </script>";
                //return redirect()->route('orientador.index');
            } elseif ($valor->tipoFuncao == "GRADUACAO") {
                return "<script>window.location.assign('".route('orientador.index')."');  </script>";
                //return redirect()->route('orientador.index');
            } elseif ($valor->tipoFuncao == "SUPER") {
                return view('home');
                //return redirect()->route('orientador.index');
            } else {
                return $this->logout();
            } 
    
        }
    }

    /**
     * Método Logout
     * 
     */
    static function logout($msg = "Agradecemos a Colaboração!") {
        setcookie("loginUSP", null, time()-3600);
        unset($_COOKIE['loginUSP']);
        session()->pull('SSloginUSP', null);
        return "<script>alert ('$msg'); window.location.assign('".route('home')."');  </script>";
    }
}
