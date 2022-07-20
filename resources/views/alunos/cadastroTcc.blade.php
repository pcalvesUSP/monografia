@extends('layouts.app')

@section('content')
  <style>
    input, select, textarea {
      border-style: solid;
      border-color: blue;
      font-family: sans-serif;
      position: relative;
      left: 20px;
    }

    .aluno {
      font-weight: bold;
      font-size: 18px;
    }

    #trabDupla {
      display:none;
    }
  </style>

  <h1>Cadastro de Monografia - Graduação</h1>
  <p class="aluno">ALUNO: {{ $numUSPAluno }} - {{ $nomeAluno }}</p>
  <form>
    Trabalho em Dupla? <input type="checkbox" name="dupla" id="dupla"><br/>
    <div id="trabDupla">
      Selecione a pessoa:
      <select name="pessoaDupla" id="pessoaDupla" @if ($readonly) tabindex="-1" aria-disabled="true" style="background: #EEE; pointer-events: none; touch-action: none;" @endif>
        @foreach ($listaAlunosDupla as $objAluno)
        <option value="{{ $objAluno->numUSP }}">{{ $objAluno->nome }}</option>
        @endforeach
        
      </select>
    </div>
    <br/>
    Selecione o orientador:
    <select name="orientador_id">
      @foreach ($listaOrientadores as $objOrientador)
      <option value="{{ $objOrientador->id }}">{{ $objOrientador->nome }}</option>
      @endforeach
    </select><br/>

    <label> T&iacute;tulo: </label><input type="text" name="titulo" maxlength="255" required><br/>
    Resumo: <textarea name="resumo" rows="10" cols="50" required></textarea><br/>
    Arquivo do TCC: <input type="file" name="template_apres" required><br/>
    Unitermo 1: <select name="unitermo1">
                  @foreach ($unitermos as $objUnitermos)
                  <option value="{{ $objUnitermos->id }}">{{ $objUnitermos->unitermo }}</option>
                  @endforeach
                </select><br/>
    Unitermo 2: <select name="unitermo2">
                  @foreach ($unitermos as $objUnitermos)
                  <option value="{{ $objUnitermos->id }}">{{ $objUnitermos->unitermo }}</option>
                  @endforeach
                </select><br/>
    Unitermo 3: <select name="unitermo3">
                  @foreach ($unitermos as $objUnitermos)
                  <option value="{{ $objUnitermos->id }}">{{ $objUnitermos->unitermo }}</option>
                  @endforeach
                </select><br/>
    Área Temática: <select name="cod_area_tamatica">
                  <option value="1">Uni 1</option>
                  <option value="2">Uni 2</option>
                  <option value="3">Uni 3</option>
                  <option value="4">Uni 4</option>
                </select><br/>
    <input type="hidden" name="ano" value = "<?=date('Y'); ?>">
    <input type="submit" name="enviar" value="Enviar">
  </form>
@endsection