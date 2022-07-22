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

    .selectReadonly {
      background: #EEE;
      pointer-events: none;
      touch-action: none;
    }

    .inputReadonly {
      background: #EEE;
    }

    #trabDupla {
      display:none;
    }
  </style>

  <h1>Cadastro de Monografia - Graduação</h1>
  <p class="aluno">ALUNO: {{ $numUSPAluno }} - {{ $nomeAluno }}</p>
  <form>
    Trabalho em Dupla? <input type="checkbox" name="dupla" id="dupla" value="1" @if ($readonly) disabled readonly class="inputReadonly" @endif @if (old('dupla') == 1) checked @endif><br/>
    <div id="trabDupla">
      Selecione a pessoa:
      <select name="pessoaDupla" id="pessoaDupla" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
        @foreach ($listaAlunosDupla as $objAluno)
        <option value="{{ $objAluno->numUSP }}" @if (old('pessoaDupla') == $objAluno->numUSP) selected @endif>{{ $objAluno->nome }}</option>
        @endforeach
        
      </select>
    </div>
    <br/>
    Selecione o orientador principal:
    <select name="orientador_id" required @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
      @foreach ($listaOrientadores as $objOrientador)
      <option value="{{ $objOrientador->id }}">{{ $objOrientador->nome }}</option>
      @endforeach
    </select><br/>

    Selecione o(s) orientador(es) secundário(s) - se houver:
    <select name="orientador_secundario_id[]" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
      @foreach ($listaOrientadores as $objOrientador)
      <option value="{{ $objOrientador->id }}">{{ $objOrientador->nome }}</option>
      @endforeach
    </select><br/>

    <label> T&iacute;tulo: </label><input type="text" name="titulo" maxlength="255" value="{{ old('titulo') }}" required @if ($readonly) class="inputReadonly" readonly @endif><br/>
    Resumo: <textarea name="resumo" rows="10" cols="50" required @if ($readonly) class="inputReadonly" readonly @endif>{{ old() }}</textarea><br/>
    @if ($publicar)
      <br/>
      Publicar Trabalho?
      <input type="radio" id="publicar" name="publicar" value="1">&nbsp;Sim
      <input type="radio" id="publicar" name="publicar" value="0">&nbsp;Não
      <br/>
    @endif
    Arquivo do TCC: <input type="file" name="template_apres" required><br/>
    Unitermo 1: <select name="unitermo1" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
                  @foreach ($unitermos as $objUnitermos)
                  <option value="{{ $objUnitermos->id }}">{{ $objUnitermos->unitermo }}</option>
                  @endforeach
                </select><br/>
    Unitermo 2: <select name="unitermo2" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
                  @foreach ($unitermos as $objUnitermos)
                  <option value="{{ $objUnitermos->id }}">{{ $objUnitermos->unitermo }}</option>
                  @endforeach
                </select><br/>
    Unitermo 3: <select name="unitermo3" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
                  @foreach ($unitermos as $objUnitermos)
                  <option value="{{ $objUnitermos->id }}">{{ $objUnitermos->unitermo }}</option>
                  @endforeach
                </select><br/>
    Área Temática: <select name="cod_area_tamatica" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
                  <option value="1">Uni 1</option>
                  <option value="2">Uni 2</option>
                  <option value="3">Uni 3</option>
                  <option value="4">Uni 4</option>
                </select><br/>
    <input type="hidden" name="ano" value = "<?=date('Y'); ?>">
    @csrf
    @if (!$readonly) 
        <input type="submit" name="enviar" value="Enviar">
    @endif
  </form>
@endsection