<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Senhaunica\Senhaunica;
use Illuminate\Support\Facades\Route;


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
        $user = isset($_COOKIE["loginUSP"])? json_decode($_COOKIE["loginUSP"]):null;
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

        if (ENV("APP_ENV") != "production") {
            print_r($usuario);
            echo "<br/>---------------------- <br/>";
            echo $usuario->loginUsuario."<br/>";
                    
            $vinculo = isset($usuario->vinculo)?$usuario->vinculo:null;
            
            print_r($vinculo);
            echo "<br/>---------------------- <br/>";
        }

        print "<script>window.location.assign('".route('alunos.cadastroTcc',['numUSP' => $usuario->loginUsuario])."');  </script>";
        return;
        //return redirect()->route('alunos.cadastroTcc',['numUSP' => $usuario->loginUsuario]);

        if (empty($vinculo)) {
            print "<script>alert('1-Você não tem acesso ao sistema. Entre em contato com o Serviço de Graduacao.');  </script>";
            return;
            /*$dadosVinculo = new StdClass;
            $dadosVinculo->tipoVinculo = "SERVIDOR";
            $dadosVinculo->codigoUnidade = 7;
            $dadosVinculo->siglaUnidade = "EE";
            $vinculo[] = $dadosVinculo;*/
        }
    
        foreach ( (array)$vinculo as $valor ) {
            
            print "<script>window.location.assign('".route('alunos.cadastroTcc',['numUSP' => $usuario->loginUsuario])."');  </script>";
            return;
            
            // NÃO FUNCIONA - PESQUISAR: redirect()->route('alunos.cadastroTcc',['numUSP' => $usuario->loginUsuario]);
            //return;

            if ( $valor['tipoVinculo'] == "ALUNOGR" && $valor['codigoUnidade'] == 7 ) {
                print "<script>window.location.assign('".route('alunos.cadastroTcc',['numUSP' => $usuario->loginUsuario])."');  </script>";
                return;
            } else {
                /*$query= $this->db->query("SELECT * FROM orientadores where id_orientador = ".$usuario->loginUsuario); // VERIFICA ORIENTADOR
                $results_array = $query->result();

                if (!empty($results_array)) { 
                    redirect()->route('orientadores');
                } else {
                    $query= $this->db->query("SELECT * FROM comissao where num_usp =". $usuario->loginUsuario);// VERIFICA GRADUAÇÃO
                    $results_array = $query->result();
                        
                    if (!empty($results_array)) redirect()->route('graduacao');
                };*/
            }
        }
        
        if (empty($results_array)) {
            print "<script>alert('Você não tem acesso ao sistema. Entre em contato com o Serviço de Graduacao.');  </script>";
            return;
        }
    }

    /**
     * Método que busca as permissões de alunos
     * @param $tipoAcao Ação que o usuário quer realizar
     */
    static function getPermissao($tipoAcao) {
        $dadosUsuario = PrincipalController::getDadosUsuario();
        if (empty($dadosUsuario)) {
            print "<script>alert('PGP - Favor realizar login.'); window.location.assign('" . env('APP_URL') . "'); </script>";
			return;
        }
        $vinculo = $dadosUsuario->vinculo;
        $permissao = false;

        foreach ( $vinculo as $key=>$valor ) {
            if ($key == "tipoVinculo") {
                //Busca Permissao pelo tipo de ação
                $permissao = true;

                /*foreach ($arrUsuariosPermitidos as $user) {
                    if ( !isset($permissao[$ind])) break;
        
                    if (substr_compare($user,$permissao[$ind]) == 0) {
                        $auth = true;
                        break;
                    }
                    $ind++;
                }*/
            }
        }
        return $permissao;       

    }

    /**
     * Método Logout
     * 
     */
    function logout() {
        unset($_COOKIE["loginUSP"]);
        print "<script>window.location.assign('".route('home').");  </script>";
        return;
}
}
