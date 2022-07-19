<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unitermo extends Model
{
    private int $id;
    private string $unitermo;
    
    function setId($id) {
        $this->id = $id;
    }

    function setUnitermo(string $strUni) {
        $this->unitermo = $strUni;
    }

    function getId(): int {
        return $this->id;
    }

    function getUnitermo(): string {
        return $this->unitermo;
    }
}
