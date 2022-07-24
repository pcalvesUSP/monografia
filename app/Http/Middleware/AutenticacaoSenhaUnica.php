<?php

namespace App\Http\Middleware;

use Uspdev\Senhaunica\Senhaunica;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use App\Orientador;

use Closure;

class AutenticacaoSenhaUnica
{
    private $dadosUsuario;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string Método de Login, pode ser SENHAUNICA e EXTERNO
     * @return mixed
     */
    public function handle($request, Closure $next, $metodoLogin)
    {       
        $this->dadosUsuario = \App\Http\Controllers\PrincipalController::getDadosUsuario();
        if (empty($this->dadosUsuario)) {
            if ($metodoLogin == "SENHAUNICA") {
                putenv('SENHAUNICA_KEY=eeusp');
                putenv('SENHAUNICA_SECRET=fyY31VRQWpCO90lCQ1PWR3KKdmfCfQaZiYbBN1LP');
                putenv('SENHAUNICA_CALLBACK_ID=9');
    
                //Somente para ambiente de teste
                //putenv('SENHAUNICA_DEV=teste123*');
    
                $auth = new Senhaunica();
                $this->dadosUsuario = (object)$auth->login();
    
            } elseif ($metodoLogin == "EXTERNO") {
                $senha = crypt($senha);
                $objUser = $User::where('email',$email)->where('password',$senha);
    
                if ($objUser){
    
                    $result = new StdClass;
                    $vinculo = array();
    
                    $vinculo = ["tipoVinculo"        => "EXTERNO"
                               ,"codigoSetor"        => 0
                               ,"nomeAbreviadoSetor" => "Prof. Ext"
                               ,"nomeSetor"          => "Externo"
                               ,"codigoUnidade"      => 7
                               ,"siglaUnidade"       => "EE"
                               ,"nomeUnidade"        => "Escola de Enfermagem"
                               ,"nomeVinculo"        => "Externo"
                               ,"nomeAbreviadoFuncao"=> "ORIENTADOR"
                               ,"tipoFuncao"         => "ORIENTADOR"
                               ];
    
                    $result->loginUsuario           = $objUser->email;
                    $result->nomeUsuario            = $objUser->name;
                    $result->tipoUsuario            = "E";
                    $result->emailPrincipalUsuario  = $objUser->email;;
                    $result->emailAlternativoUsuario= "";
                    $result->emailUspUsuario        = "";
                    $result->numeroTelefoneFormatado= "(11) 55555-5555";
                    $result->wuserid                = "";
                    $result->vinculo                = [0 => $vinculo];
    
                    $this->dadosUsuario = $result;
                } else {
                    return Response("Usuário não encontrado");
                }
            } else {
                //Response ERRO Metodologia
            }
            $this->getPermissao();
        } 
        return $next($request);
    }

    /**
     * Método que verifica a permissão do usuário e seta variável de sessão
     */
    public function getPermissao() {
        session()->pull('permissao', null);
        session()->pull('loginUSP', null);

        $vinculo = $this->dadosUsuario->vinculo;
        $permissao = false;
        $dadosGraduacao = explode(",", env('NUSP_GRADUACAO'));
        $dadosSuperUser = explode(",", env('NUSP_SUPERUSER'));

        foreach ( (object)$vinculo as $valor ) {
            if ($valor["tipoVinculo"] == "ALUNOGR") {
                $this->dadosUsuario->vinculo[0]["tipoFuncao"] = "ALUNOGR";
                session(['permissao' => session('permissao')."CADASTRO_TCC, CORRIGIR_TCC, EXCLUIR_TCC,"]);
            } elseif (Orientador::where("id",$this->dadosUsuario->loginUsuario)->count() > 0) {
                $this->dadosUsuario->vinculo[0]["tipoFuncao"] = "ORIENTADOR";
                session(['permissao' => session('permissao')."DEVOLVER_TCC, APROVAR_TCC, REPROVAR_TCC,"]);
            } elseif (array_search($this->dadosUsuario->loginUsuario,$dadosGraduacao)  !== false ) {
                session(['permissao' => session('permissao')."EDITAR_TCC, EXCLUIR_TCC, CADASTRO_ORIENTADOR, CADASTRO_PARAMETROS"]);
                $this->dadosUsuario->vinculo[0]["tipoFuncao"] = "GRADUACAO";
            } elseif (array_search($this->dadosUsuario->loginUsuario,$dadosSuperUser)  !== false ) {
                session(['permissao' => session('permissao')."EDITAR_TCC, EXCLUIR_TCC, CADASTRO_ORIENTADOR, CADASTRO_PARAMETROS, DEVOLVER_TCC, APROVAR_TCC, REPROVAR_TCC,"]);
                $this->dadosUsuario->vinculo[0]["tipoFuncao"] = "SUPER";
            }

            if (strlen(session('permissao')) > 0) {
                $permissao = true;
            }
        }
        $this->dadosUsuario->permissao = $permissao;
        session(['SSloginUSP' => json_encode($this->dadosUsuario)]);
        
        //setcookie("loginUSP", json_encode($this->dadosUsuario), time()+3600);
        return response('loginUSP')->cookie( 'loginUSP', json_encode($this->dadosUsuario), time()+3600 );
        
    }    

}
