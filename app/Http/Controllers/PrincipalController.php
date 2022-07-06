<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Senhaunica\Senhaunica;


class PrincipalController extends Controller
{
    /**
     * Método Login
     */
    function login () {
        putenv('SENHAUNICA_KEY=eeusp');
        putenv('SENHAUNICA_SECRET=fyY31VRQWpCO90lCQ1PWR3KKdmfCfQaZiYbBN1LP');
        putenv('SENHAUNICA_CALLBACK_ID=9');

        //Somente para ambiente de teste
        //putenv('SENHAUNICA_DEV=teste123*');

        $auth = new Senhaunica();
        $res = $auth->login();

        echo '<pre>';
        print_r($res);
        echo '<pre>';
    } 
}
