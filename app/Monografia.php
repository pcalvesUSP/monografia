<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monografia extends Model
{
    protected $connection = 'mysql';
    
    private int $idTcc;
    private string $status;
    private string $titulo;
    private string $resumo;
    private bool $publicar;
    private string $pathArquivo;
    private string $ano;

    private int $idUnitermo1;
    private int $idUnitermo2;
    private int $idUnitermo3;
    private int $codAreaTematica;
    private array $idAluno;
    private array $idOrientador;


    function setIdTcc(int $id) {
        $this->idTcc = $id;
    }

    function setStatus(string $status) {
        $this->status = $status;
    }

    function setTitulo(string $titulo) {
        $this->titulo = $titulo;
    }

    function setResumo(string $resumo) {
        $this->resumo = $resumo;
    }
    
    function setPublicar(bool $publicar) {
        $this->publicar = $publicar;
    }
    
    function setPathArquivo(string $pathArquivo) {
        $this->$pathArquivo = $pathArquivo;
    }

    function setAno (string $ano) {
        $this->ano = $ano;
    }

    function setIdUnitermo1(int $id) {
        $this->idUnitermo1 = $id;
    }

    function setIdUnitermo2(int $id) {
        $this->idUnitermo2 = $id;
    }

    function setIdUnitermo3(int $id) {
        $this->idUnitermo3 = $id;
    }

    function setCodAreaTematica(int $cod) {
        $this->codAreaTematica = $cod;
    }

    function setIdAluno (array $idAluno) {
        $this->idAluno = $idAluno;
    }

    function setIdOrientador (array $idOrient) {
        $this->idOrientador = $idOrient;
    }

    /** Grupo de Get */
    function getIdTcc() {
        return $this->idTcc;
    }

    function getStatus() {
        return $this->status;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getResumo() {
        return $this->resumo;
    }
    
    function getPublicar() {
        return $this->publicar;
    }
    
    function getPathArquivo() {
        return $this->$pathArquivo;
    }

    function getAno () {
        return $this->ano;
    }

    function getIdUnitermo1() {
        return $this->idUnitermo1;
    }

    function getIdUnitermo2() {
        return $this->idUnitermo2;
    }

    function getIdUnitermo3() {
        return $this->idUnitermo3;
    }

    function getCodAreaTematica() {
        return $this->codAreaTematica;
    }

    function getIdAluno () {
        return $this->idAluno;
    }

    function getIdOrientador () {
        return $this->idOrientador;
    }
}
