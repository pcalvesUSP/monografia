<?php

//$usuario = \App\Http\Controllers\PrincipalController::getDadosUsuario();

/*$admin = [
    [
        'text' => '<i class="fas fa-atom"></i>  SubItem 1',
        'url' => 'subitem1',
    ],
    [
        'text' => 'SubItem 2',
        'url' =>  '/subitem2',
        'can' => 'admin',
    ],
    [
        'type' => 'divider',
    ],
    [
        'type' => 'header',
        'text' => 'TESTE',
    ],
    [
        'text' => 'SubItem 3',
        'url' => 'subitem3',
    ],
];*/

$alunos = [
    [
        'text' => 'Cadastro Monografia',
        'url' => '/alunos/cadastroMonografia/',
        //'can' => 'ALUNOGR'
    ],
    /*[
        'text' => 'SubItem 2',
        'url' => 'subitem2',
        'can' => 'admin',
    ],*/
];

$orientadores = [
    [
        'text' => 'Listar Monografias',
        'url' => '/orientador/',
        //'can' => 'ALUNOGR'
    ],
];

$graduacao = [
    [
        'text' => 'Listar Monografias',
        'url' => '/orientador/',
        //'can' => 'ALUNOGR'
    ],
];


$menu = [
    [
        'text' => '<i class="fas fa-home"></i> Home',
        'url' => '/',
    ],
    /*[
        # este item de menu será substituido no momento da renderização
        'key' => 'menu_dinamico',
    ],*/
    [
        'text' => 'Alunos',
        'submenu' => $alunos,
        //'can' => 'user',
    ],
    /*[
        'text' => 'Está logado',
        'url' => config('app.url') . '/logado', // com caminho absoluto
        'can' => 'user',
    ],*/
    [
        'text' => 'Orientadores',
        'submenu' => $orientadores
        //'url' => 'gerente',
        //'can' => 'gerente',
    ],
    [
        'text' => 'Graduação',
        'submenu' => $graduacao
        //'can' => 'admin',
    ],
];

$right_menu = [
    /*[
        // menu utilizado para views da biblioteca senhaunica-socialite.
        'key' => 'senhaunica-socialite',
    ],
    [
        'text' => '<i class="fas fa-cog"></i>',
        'title' => 'Configurações',
        'target' => '_blank',
        'url' => config('app.url') . '/item1',
        'align' => 'right',
    ],*/
];


return [
    # valor default para a tag title, dentro da section title.
    # valor pode ser substituido pela aplicação.
    'title' => config('app.name'),

    # USP_THEME_SKIN deve ser colocado no .env da aplicação 
    'skin' => env('USP_THEME_SKIN', 'uspdev'),

    # chave da sessão. Troque em caso de colisão com outra variável de sessão.
    'session_key' => 'laravel-usp-theme',

    # usado na tag base, permite usar caminhos relativos nos menus e demais elementos html
    # na versão 1 era dashboard_url
    'app_url' => config('app.url'),

    # login e logout
    'logout_method' => 'GET',
    'logout_url' => 'logout',
    'login_url' => 'login',

    # menus
    'menu' => $menu,
    //'right_menu' => $right_menu,
];
