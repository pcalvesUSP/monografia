<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Senhaunica\Senhaunica;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use App\Aluno;
use App\Orientador;

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
        else 
            return null;
    }

    /**
     * Método Login
     */
    function login () {

		if (empty($this->dadosUsuario)) {
            putenv('SENHAUNICA_KEY=eeusp');
            putenv('SENHAUNICA_SECRET=fyY31VRQWpCO90lCQ1PWR3KKdmfCfQaZiYbBN1LP');
            putenv('SENHAUNICA_CALLBACK_ID=9');

            //Somente para ambiente de teste
            //putenv('SENHAUNICA_DEV=teste123*');

            $auth = new Senhaunica();
            $this->dadosUsuario = (object)$auth->login();

            setcookie("loginUSP", json_encode($this->dadosUsuario), time()+3600);
        } 
        $this->accSystem();
    }
    
    function loginExternal () {
        
        if (empty($this->dadosUsuario)) {
            $result = new StdClass;
            $vinculo = new StdClass;

            $vinculo->tipoVinculo = "EXTERNO";
            $vinculo->codigoSetor = 0;
            $vinculo->nomeAbreviadoSetor = "Prof. Ext";
            $vinculo->nomeSetor = "Externo";
            $vinculo->codigoUnidade = 7;
            $vinculo->siglaUnidade = "EE";
            $vinculo->nomeUnidade = "Escola de Enfermagem";
            $vinculo->nomeVinculo = "Externo";
            $vunculo->nomeAbreviadoFuncao = "ORIENTADOR";
            $vinculo->tipoFuncao = "Docente";

            $result->loginUsuario = "26790587802";
            $result->nomeUsuario = "Nome Usuário";
            $result->tipoUsuario = "E";
            $result->emailPrincipalUsuario = "emailprincipal@xpto.com.br";
            $result->emailAlternativoUsuario = "";
            $result->emailUspUsuario = "";
            $result->numeroTelefoneFormatado = "(11) 55555-5555";
            $result->wuserid = "";
            $result->vinculo = [0 => $vinculo];

            $this->dadosUsuarios = $result;
            setcookie("loginUSP",json_encode($result),time()+3600,"/");
        }
        $this->accSystem();
    }

    function accSystem () {
              
        $usuario = $this->dadosUsuario;
        $vinculo = isset($usuario->vinculo)?$usuario->vinculo:null;
            
        echo "<h1> AGUARDE </h1>";

        if (ENV("APP_ENV") != "production") {
            print_r($usuario);
            echo "<br/>---------------------- <br/>";
            echo $usuario->loginUsuario."<br/>";        
            
            print_r($vinculo);
            echo "<br/>---------------------- <br/>";
        } 

        //print "<script>window.location.assign('".route('alunos.cadastroTcc',['numUSP' => $usuario->loginUsuario])."');  </script>";
        //return;

        if (empty($vinculo)) {
            print "<script>alert('1-Você não tem acesso ao sistema. Entre em contato com o Serviço de Graduacao.');  </script>";
            return;
            /*$dadosVinculo = new StdClass;
            $dadosVinculo->tipoVinculo = "SERVIDOR";
            $dadosVinculo->codigoUnidade = 7;
            $dadosVinculo->siglaUnidade = "EE";
            $vinculo[] = $dadosVinculo;*/
        }
    
        foreach ( $vinculo as $valor ) {
            $valor = (object)$valor;
            
            if ($valor->tipoVinculo == "ALUNOGR") {
                if (Aluno::where("id",$usuario->loginUsuario)->count() > 0) {
                    print "<script>window.location.assign('".route('alunos.index')."');  </script>";
                    return;
                }
            } elseif (Orientador::where("id",$usuario->loginUsuario)->count() > 0) {
                print "<script>window.location.assign('".route('orientador.index')."');  </script>";
                return redirect()->route('orientador.index');
            } else {
                $dadosGraduacao = explode(",", env('NUSP_GRADUACAO'));
                if (array_search($usuario->loginUsuario,$dadosGraduacao)  === false){
                   $this->logout();
                } else {
                    print "<script>window.location.assign('".route('orientador.index')."');  </script>";
                    return redirect()->route('orientador.index');
                }
            }
        }
    }

    /**
     * Método que busca as permissões de alunos
     * @param $tipoAcao Ação que o usuário quer realizar
     */
    static function getPermissao() {
        $dadosUsuario = PrincipalController::getDadosUsuario();
        if (empty($dadosUsuario)) {
            print "<script>alert('PGP - Favor realizar login.'); window.location.assign('" . env('APP_URL') . "'); </script>";
			return;
        }
               
        session()->pull('permissao', false);

        $vinculo = $dadosUsuario->vinculo;
        $permissao = false;

        foreach ( $vinculo as $key=>$valor ) {
            if ($valor->tipoVinculo == "ALUNOGR") {
                session(['permissao' => "CADASTRO_TCC, CORRIGIR_TCC,"]);
            } elseif (Orientador::where("id",$dadosUsuario->loginUsuario)->count() > 0) {
                session(['permissao' => "DEVOLVER_TCC, APROVAR_TCC, REPROVAR_TCC,"]);
            } else {
                $dadosGraduacao = explode(",", env('NUSP_GRADUACAO'));
                if (array_search($dadosUsuario->loginUsuario,$dadosGraduacao)  !== false ){
                    session(['permissao' => "EDITAR_TCC, DEVOLVER_TCC, APROVAR_TCC, REPROVAR_TCC,"]);
                }
            }

            if (session('permissao')) {
                $permissao = true;
                break;
            }
        }
        return $permissao;
    }

    /**
     * Método Logout
     * 
     */
    static function logout() {
        unset($_COOKIE['loginUSP']);
        return redirect()->route('home');
        //print "<script>window.location.assign('".route('home').");  </script>";
        //return;
    }
}
