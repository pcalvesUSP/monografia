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
        $user = isset($_COOKIE["loginUSP"])? $_COOKIE["loginUSP"]:null;
        return json_decode($user);
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
            $res = $auth->login();

            setcookie("loginUSP", json_encode($res), time()+3600);

        } 
        $this->accSystem();
    }
    
    function loginExternal () {
        
        if (empty($this->dadosUsuario)) {
            $result = array("loginUsuario"            => "26790587802"
                           ,"nomeUsuario"             => "Nome Usuário"
                           ,"tipoUsuario"             => "E"
                           ,"emailPrincipalUsuario"   => "emailprincipal@xpto.com.br"
                           ,"emailAlternativoUsuario" => ""
                           ,"emailUspUsuario"         => ""
                           ,"numeroTelefoneFormatado" => "(11) 55555-5555"
                           ,"wuserid"                 => 0
                           ,"vinculo"                 => [0 => array("tipoVinculo"        => "EXTERNO"
                                                                    ,"codigoSetor"        => "0"
                                                                    ,"nomeAbreviadoSetor" => "Prof. Ext"
                                                                    ,"nomeSetor"          => "Externo"
                                                                    ,"codigoUnidade"      => 7
                                                                    ,"siglaUnidade"       => "EE"
                                                                    ,"nomeUnidade"        => "Escola de Enfermagem"
                                                                    ,"nomeVinculo"        => "Externo"
                                                                    ,"nomeAbreviadoFuncao"=> "Orientador"
                                                                    ,"tipoFuncao"         => "Docente"
                                                         )]
                      );

            setcookie("loginUSP",json_encode($result),time()+3600,"/");
        }
        $this->accSystem();
    }

    function accSystem () {
        if (empty($this->dadosUsuario)) {
            $this->dadosUsuario = isset($_COOKIE["loginUSP"])?$_COOKIE["loginUSP"]:null;
        
            //print "<script>alert('Favor realizar login'); window.location.assign('http://www.ee.usp.br'); </script>";
			//return;

        }
        
        //$usuario = json_decode($dadosUsuario);
        $usuario = $this->dadosUsuario;
                
        $vinculo = isset($usuario->vinculo)?$usuario->vinculo:null;
        
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
        $dadosusuario = PrincipalController::getDadosUsuario();
        $vinculo = $dadosUsuario->vinculo;
        $permissao = false;

        foreach ( (array)$vinculo as $key=>$valor ) {
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
}
