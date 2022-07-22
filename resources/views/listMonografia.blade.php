@extends('layouts.app')

@section('content')

<h1>TESTE</h1>
<table id="listMonografias" border="1">
    <tr>
        <th>Titulo</th>
        <th>Aluno(s)</th>
        <th>Ano</th>
        <th>Ações</th>
    </tr>
@foreach ($dadosMonografias as $objMonografia)
    <tr>
        <td>{{ $objMonografia->titulo }}</td>
        <td>{{ $grupoAlunos[$objMonografia->id] }}</td>
        <td>{{ $objMonografia->ano }}</td>
        <td><a href="{{ route('orientador.edicao',['idMono'=>$objMonografia->id,'numUsp'=>$numUsp[$objMonografia->id]]) }}">EDITAR</a> | DEVOLVER | APROVAR | REPROVAR</td>
    </tr>
@endforeach
</table>
@endsection