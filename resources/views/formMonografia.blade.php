@extends('layouts.app')

@section('content')
  <!--script src="js/validacaoFormMonografia.js"></script-->
  <style>
    .grupo:before, .grupo:after {
        content: " ";
        display: table;
    }

    .grupo:after {
        clear: both;
    }

    .campo {
        margin-left: 5px;
    }

    .campo label {
        color: rgb(115, 116, 117);
        display: block;
        background: rgb(247, 247, 252);
    }

    input, select, textarea, button {
        border-style: solid;
        border-color: blue;
        font-family: sans-serif;
    }

    #dupla {
        position: relative;
        left: 150px;
        top: -27px;
    }

    .erro{
        color: red;
        font-size: 12px;
        font-weight: bold;
        border: red;
        background: rgb(206, 206, 206)
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

    #fieldsMonografia {
        width:100%;
        background: rgb(230, 230, 231)
    }
  </style>

  <h1>Cadastro de Monografia - Graduação</h1>
  <p class="aluno">ALUNO: {{ $numUSPAluno }} - {{ $nomeAluno }}</p>
  <form id="formMonografia" method="post" action="{{ route("salvarMonografia") }}">
    <fieldset id="fieldsMonografia" class="grupo">
      <div class="campo">
        <label for="dupla">Trabalho em Dupla?</label> <input type="checkbox" name="dupla" id="dupla" value="1" @if ($readonly) disabled readonly class="inputReadonly" @endif @if (old('dupla') == 1) checked @endif><br/>
        <div id="trabDupla">
          <label for="passoaDupla">Selecione o membro do grupo de trabalho:</label>
          <select name="pessoaDupla" id="pessoaDupla" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
            <option value="">Selecione</option>
            @foreach ($listaAlunosDupla as $objAluno)
            <option value="{{ $objAluno->numUSP }}" @if (old('pessoaDupla') == $objAluno->numUSP) selected @endif>{{ $objAluno->numUSP}} - {{$objAluno->nome }}</option>
            @endforeach
            
          </select>
        </div>
        <div class="erro" id="edupla">{{  $errors->has('pessoaDupla') ? $errors->first('pessoaDupla'):null }}</div>
        <br/>
      </div>
      
      <div class="campo">
        <label for="orientador_id">Selecione o orientador principal:</label>
        <select name="orientador_id" id="orientador_id" required @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
          <option value="">Selecione</option>
          @foreach ($listaOrientadores as $objOrientador)
          <option value="{{ $objOrientador->id }}" @if (old('orientador_id') == $objOrientador->id) selected @endif>{{ $objOrientador->nome }}</option>
          @endforeach
        </select>
        <div class="erro">{{  $errors->has('orientador_id') ? $errors->first('orientador_id'):null }}</div>
      </div>
      <br/>
      @if (!$readonly)
        <div class="campo">
          <label for="orientador_secundario_id">Selecione o(s) orientador(es) secundário(s), se houver:</label>
          <div id="orientadorSecundario">
            <select name="orientador_secundario_id_1" id="orientador_secundario_id_1">
              <option value="">Selecione</option>
              @foreach ($listaOrientadores as $objOrientador)
              <option value="{{ $objOrientador->id }}">{{ $objOrientador->nome }}</option>
              @endforeach
            </select>
          </div>
          <div id="novosOrientadores"></div>
          <button value="addOrientador" name="addOrientador" id="addOrientador" ind="1">+</button>
        </div>
        <br/>
      @elseif (!empty($orientadorSecundario))
      {{ $orientadorSecundario }}
      @endif

      <div class="campo">
        <label for="titulo"> T&iacute;tulo: </label><input type="text" name="titulo" id="titulo" maxlength="255" value="{{ old('titulo') }}" required @if ($readonly) class="inputReadonly" readonly @endif>
        <div class="erro">{{  $errors->has('titulo') ? $errors->first('titulo'):null }}</div><br/>
      </div>
      <div class="campo">
        <label for="resumo">Resumo:</label> <textarea name="resumo" id="resumo" rows="10" cols="50" required @if ($readonly) class="inputReadonly" readonly @endif>{{ old('resumo') }}</textarea>
        <div class="erro">{{  $errors->has('resumo') ? $errors->first('resumo'):null }}</div><br/>
      </div>
      <br/>
      @if ($publicar)
        <div class="campo">
          <label for="publicar">Publicar Trabalho?</label>
          Sim -> <input type="radio" id="publicar" name="publicar" value="1" @if (old('publicar') == 1) checked @endif>&nbsp;&nbsp;&nbsp;&nbsp;
          Não -> <input type="radio" id="publicar" name="publicar" value="0" @if (old('publicar') == 0) checked @endif>
          <div class="erro">{{  $errors->has('publicar') ? $errors->first('publicar'):null }}</div>
        </div>
        <br/>
      @endif
      
      <div class="campo">
        <label for="template_apres">Arquivo do TCC: </label><input type="file" name="template_apres" id="template_apres" required>
      </div>
      <br/>
      
      <div class="campo">
        <label for="unitermo1">Unitermo 1: </label>
        <select name="unitermo1" id="unitermo1" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
            <option value="">Selecione</option>
            @foreach ($unitermos as $objUnitermos)
            <option value="{{ $objUnitermos->id }}" @if (old('unitermo1') == $objUnitermos->id) selected @endif>{{ $objUnitermos->unitermo }}</option>
            @endforeach
        </select>
        <div class="erro">{{  $errors->has('unitermo1') ? $errors->first('unitermo1'):null }}</div>
      </div>
      <br/>
      
      <div class="campo">
        <label for="unitermo2">Unitermo 2: </label>
        <select name="unitermo2" id="unitermo2" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
            <option value="">Selecione</option>
            @foreach ($unitermos as $objUnitermos)
            <option value="{{ $objUnitermos->id }}" @if (old('unitermo2') == $objUnitermos->id) selected @endif>{{ $objUnitermos->unitermo }}</option>
            @endforeach
        </select>
        <div class="erro">{{  $errors->has('unitermo2') ? $errors->first('unitermo2'):null }}</div>
      </div>
      <br/>
      
      <div class="campo">
      <label for="unitermo3"> Unitermo 3: </label>
        <select name="unitermo3" id="unitermo3" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
            <option value="">Selecione</option>
            @foreach ($unitermos as $objUnitermos)
            <option value="{{ $objUnitermos->id }}" @if (old('unitermo3') == $objUnitermos->id) selected @endif>{{ $objUnitermos->unitermo }}</option>
            @endforeach
        </select>
        <div class="erro">{{  $errors->has('unitermo3') ? $errors->first('unitermo3'):null }}</div>
      </div>
      <br/>
      
      <div class="campo">
      <label for="cod_area_tematica"> Área Temática: </label>
        <select name="cod_area_tematica" id="cod_area_tematica" @if ($readonly) tabindex="-1" aria-disabled="true" class="selectReadonly" @endif>
            <option value="">Selecione</option>
            <option value="1" @if (old('cod_area_tematica') == 1) selected @endif>Uni 1</option>
            <option value="2" @if (old('cod_area_tematica') == 2) selected @endif>Uni 2</option>
            <option value="3" @if (old('cod_area_tematica') == 3) selected @endif>Uni 3</option>
            <option value="4" @if (old('cod_area_tematica') == 4) selected @endif>Uni 4</option>
        </select>
        <div class="erro">{{  $errors->has('cod_area_tematica') ? $errors->first('cod_area_tematica'):null }}</div><br/>
      </div>
      <input type="hidden" name="ano" vaue = "<?=date('Y'); ?>">
      @csrf
      @if (!$readonly) 
          <input type="submit" name="enviar" id="buttonSubmit" value="Enviar">
      @endif
    <fieldset>
  </form>
@endsection