<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Senhaunica\Senhaunica;
use Illuminate\Support\Facades\Route;


class PrincipalController extends Controller
{
    
    $this->dadosUsuario;

    /**
     * Método Construtor
     */
    function __construct() {
        $this->dadosUsuario = get_cookie("loginUSP");
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

            setcookie("loginUSP",$result['body'],time()+3600,"/");
        } 
        this->accSystem();
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
                           ,"wuserid"                 => rand(10100,99100);
                           ,"vinculo"                 => array[]("tipoVinculo"        => "EXTERNO"
                                                                ,"codigoSetor"        => "0"
                                                                ,"nomeAbreviadoSetor" => "Prof. Ext"
                                                                ,"nomeSetor"          => "Externo"
                                                                ,"codigoUnidade"      => 7
                                                                ,"siglaUnidade"       => "EE"
                                                                ,"nomeUnidade"        => "Escola de Enfermagem"
                                                                ,"nomeVinculo"        => "Externo"
                                                                ,"nomeAbreviadoFuncao"=> "Orientador"
                                                                ,"tipoFuncao"         => "Docente"
                                                         )
                      );

            setcookie("loginUSP",$result,time()+3600,"/");
        }
        this->accSystem();
    }

    function accSystem () {
        $this->dadosUsuario = get_cookie("loginUSP");
        if (empty($this->dadosUsuario)) {

            print "<script>alert('Favor realizar login'); window.location.assign('http://www.ee.usp.br'); </script>";
			return;

        }
        //$usuario = json_decode($dadosUsuario);
        $usuario = (object)$dadosUsuario;
                
        $vinculo = isset($usuario->vinculo)?$usuario->vinculo:array();
        $vinculo = (array)$vinculo;

        if (!count($vinculo)) {
            $dadosVinculo = new StdClass;
            $dadosVinculo->tipoVinculo = "SERVIDOR";
            $dadosVinculo->codigoUnidade = 7;
            $dadosVinculo->siglaUnidade = "EE";
            $vinculo[] = $dadosVinculo;
        }

        foreach ( $vinculo as $valor ) {
            
            if ($valor->tipoVinculo=="ALUNOGR")&&($valor->codigoUnidade==7) {
                redirect()->route('alunos');
                return;
            } else {
                $query= $this->db->query("SELECT * FROM orientadores where id_orientador = ".$usuario->loginUsuario); // VERIFICA ORIENTADOR
                $results_array = $query->result();

                if (!empty($results_array)) { 
                    redirect()->route('orientadores');
                } else {
                    $query= $this->db->query("SELECT * FROM comissao where num_usp =". $usuario->loginUsuario);// VERIFICA GRADUAÇÃO
                    $results_array = $query->result();
                        
                    if (!empty($results_array)) redirect()->route('graduacao');
                };
            }
        }
        
        if (empty($results_array)) {
            print "<script>alert('Você não tem acesso ao sistema. Entre em contato com o Serviço de Graduacao.'); window.location.assign('http://www.ee.usp.br'); </script>";
            return;
        }
    }
}
