<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Rules\CountWord;

use App\Unitermo;
use App\Monografia;
use App\Aluno;
use App\Orientador;
use App\OrientMonografia;

class MonografiaController extends Controller
{
    private $usuarioLogado;

    function __construct() {
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        if (empty($this->usuarioLogado)) {
            return PrincipalController::logout('M1-Favor realizar login');
        }
        
        $auth = $this->usuarioLogado->permissao;
        if (!$auth) {
            return PrincipalController::logout('M2-Usuário não autorizado');
        }
    }

    /** 
     * Método que chama o cadastro do TCC
     * @param string $numUSP número USP do aluno, caso não informado, busca o usuário logado
     * @param int $monografia_id Id da Monografia, caso não informada não realiza a busca
     */
    function cadastroMonografia($numUSP = null, $monografia_id = 0) {
        $Monografias = new Monografia();
        $this->usuarioLogado = PrincipalController::getDadosUsuario();
        
        dd(session('SSloginUSP'));

        $readonly = false;
        $publicar = false;
        $dadosMonografia = null;
        $dadosAlunoGrupo = array();
        $dadosOrientadores = array();
        $unitermos = Unitermo::all();
        $dadosAluno = Aluno::getDadosAluno(empty($numUSP)?$this->usuarioLogado->loginUsuario:$numUSP);
        $listaAlunosDupla = Aluno::getDadosAluno();
        $listaOrientadores = Orientador::all();

        $arrPermissao = explode(",", session('permissao'));
        if (array_search("CADASTRO_TCC",$arrPermissao) === false && 
            array_search("CORRIGIR_TCC",$arrPermissao) === false &&
            array_search("EDITAR_TCC",$arrPermissao) === false
        ) {
            $readonly = true;
        }

        if (array_search("APROVAR_TCC",$arrPermissao) !== false ||
            array_search("EDITAR_TCC",$arrPermissao) !== false
        ) {
            $publicar = true;   
        }

        if ($this->usuarioLogado->vinculo[0]->tipoVinculo == "ALUNOGR" && 
            Aluno::where("id",$this->usuarioLogado->loginUsuario)->count() > 0) 
        {
           $readonly = true;
           $dadosAlunoMono = Aluno::where("id",$this->usuarioLogado->loginUsuario)->get();
           $dadosMonografia = $Monografias->getMonografia($dadosAlunoMono->first('monografia_id'));

           foreach ($Monografias->getIdAluno() as $idAluno) {
                $objAluno = Aluno::find($idAluno);
                if ($idAluno == $this->usuarioLogado->loginUsuario) {
                    $nomeAluno = $this->usuarioLogado;
                } else {
                    $dadosAlunoGrupo[] = $objAluno;
                }
           }
 
        } else {
            
            if ($monografia_id > 0) {
                $dadosMonografia = $Monografias->getMonografia($monografia_id);
            } else {
                return PrincipalController::logout('M4-Erro ao selecionar Monografia.');
            }
            
            if (Orientador::where("id",$this->usuarioLogado->loginUsuario)->count() > 0 && 
                array_search($Monografias->getIdOrientador(),$this->usuarioLogado->loginUsuario) === false) 
            {
                return PrincipalController::logout('M5-Monografia não está sob sua Orientação');
            }
           
            if (!$dadosMonografia) {
                return PrincipalController::logout('M3-Não constam Monografias com este ID');
            } else {
                foreach ($dadosMonografia as $objMono) {
                    $objAluno = Aluno::find($objMono->numUspAluno);
                    if ($objAluno->id == $numUSP) {
                        $nomeAluno = $objAluno->nome;
                    } else {
                        $dadosAlunoGrupo[] = $objAluno;
                    }
                }
            } 
        } 

        if (!empty($dadosMonografia)) {
            $Orientadores = new Orientador();
            foreach ($dadosMonografia as $objMono) {
                $objOrientador = 
                    $Orientadores->listOrientador($objMono->numUspOrientador,$objMono->id);
                $dadosOrientadores[] = $objOrientador;
            }
        }

        $parametros = ["numUSPAluno"        => empty($numUSP)?$this->usuarioLogado->loginUsuario:$numUSP
                      ,"nomeAluno"          => $nomeAluno
                      ,"listaAlunosDupla"   => $listaAlunosDupla
                      ,"listaOrientadores"  => $listaOrientadores
                      ,"unitermos"          => $unitermos
                      ,"readonly"           => $readonly
                      ,"publicar"           => $publicar
                      ,"dadosMonografia"    => $dadosMonografia
                      ,"dadosAlunoGrupo"    => $dadosAlunoGrupo
                      ,"dadosOrientadores"  => $dadosOrientadores
                      ];

        return view('formMonografia',$parametros);
    }

    /**
     * Lista todas as monografias cadastradas conforme Orientador, ou caso passado como 0, todas as monografias
     */
    public function listMonografia(int $id_orientador = 0) {
        $dadosMonografias = [];
        $grupoAlunos = [];
        $numUsp = [];

        $Monografias = new Monografia();
        $dadosMonografias = $Monografias->getMonografia(0,$id_orientador);
        
        foreach ($dadosMonografias as $obj) {
            if (isset($grupoAlunos[$obj->id]) && $grupoAlunos[$obj->id] != $obj->numUspAluno )
                $grupoAlunos[$obj->id] .= "<br>".$obj->numUspAluno." ".$obj->nomeAluno;
            else {
                $grupoAlunos[$obj->id] = $obj->numUspAluno." ".$obj->nomeAluno;
                $numUsp[$obj->id] = $obj->numUspAluno;
            }
        }

        $parametros = ["dadosMonografias" => $dadosMonografias->unique()
                      ,"grupoAlunos"      => $grupoAlunos
                      ,"numUsp"           => $numUsp
                      ];

        return view('listMonografia',$parametros);

    }

    /**
     * Verifica lista de pareceres para determinada Monografia
     */
    public function listarPareceres(int $monografia_id) {

    }

    /**
     * Persiste os dados do TCC no Banco de Dados
     */ 
    public function salvar(Request $request) {

        $rules = [];
        if ($request->input('dupla')) {
            $rules['pessoaDupla'] = "required";
            $messages['pessoaDupla.required'] = "Favor informar o componente do grupo de trabalho.";
        }

        $rules['orientador_id'] = "required";
        $rules['titulo']        = "required|min:3|max:255";
        $rules['resumo']        = ["required","min:3",new CountWord];
        $rules['unitermo1']     = "required";
        $rules['unitermo2']     = "required";
        $rules['unitermo3']     = "required";

        $messages['required']   = "Favor informar o :attribute da monografia.";
        $messages['min']        = "O :attribute deve conter no mínimo 3 caracteres";

        $messages['titulo.max'] = "O título deve conter no máximo 255 caracteres";

        if ($request->hasFile('template_apres') && $request->file('template_apres')->isValid()) {
            $arquivo = $request->file('template_apres');

            $arquivo->getClientOriginalName();
            $arquivo->move(public_path('upload'),$file->getClientOriginalName());
        } else {
            $rules['template_apres'] = [function ($attribute, $value, $fail) {
                                            $fail($attribute.' é inválido.');
                                        }];
        }

        $request->validate($rules,$messages);
    }
}
