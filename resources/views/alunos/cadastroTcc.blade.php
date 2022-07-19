@extends('layouts.app')

@section('content')
  <style>
    input, select, textarea {
      border-style: solid;
      border-color: blue;
      font-family: sans-serif;
      position: relative;
      left: 10px;
    }
  </style>

  <h1>Cadastro de Monografia - Graduação</h1>
  <p>{{ $numUSP }} - {{ $nomeUsuario }}</p>
  <form>
    Trabalho em Dupla? <input type="checkbox" name="dupla"><br/>
    <div id="trabDupla" style="display:none">
      Selecione a pessoa:
      <select name="pessoaDupla">
        <option value="1">Pessoa 1 - NUSP 000000</option>
        <option value="2">Pessoa 2 - NUSP 000000</option>
        <option value="3">Pessoa 3 - NUSP 000000</option>
        <option value="4">Pessoa 4 - NUSP 000000</option>
      </select>
    </div>
    <br/>
    Selecione o orientador:
    <select name="orientador_id">
      <option value="1">Orientador 1 - NUSP 000000</option>
      <option value="2">Orientador 2 - NUSP 000000</option>
      <option value="3">Orientador 3 - NUSP 000000</option>
      <option value="4">Orientador 4 - NUSP 000000</option>
    </select><br/>

    <label> T&iacute;tulo: </label><input type="text" name="titulo" maxlength="255" required><br/>
    Resumo: <textarea name="resumo" rows="10" cols="50" required></textarea><br/>
    Arquivo do TCC: <input type="file" name="template_apres" required><br/>
    Unitermo 1: <select name="unitermo1">
                  <option value="1">Uni 1</option>
                  <option value="2">Uni 2</option>
                  <option value="3">Uni 3</option>
                  <option value="4">Uni 4</option>
                </select><br/>
    Unitermo 2: <select name="unitermo2">
                  <option value="1">Uni 1</option>
                  <option value="2">Uni 2</option>
                  <option value="3">Uni 3</option>
                  <option value="4">Uni 4</option>
                </select><br/>
    Unitermo 3: <select name="unitermo3">
                  <option value="1">Uni 1</option>
                  <option value="2">Uni 2</option>
                  <option value="3">Uni 3</option>
                  <option value="4">Uni 4</option>
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