<?php

// arquivo de configuração da sidebar principal
return [
    "sideBarHeaderName" => "MultiStore",
    "sideBarHeaderRoute" => "loja.dashboard.index",
    "params" => function() { return ['loja' => session('loja_slug')]; },
    "sideBarItems" => [
        [
            "name" => "Dashboard",
            "icon" => "bi bi-app",
            "route" => "loja.dashboard.index",
            "params" => function() { return ['loja' => session('loja_slug')]; }
        ],
        [
            "name" => "Colaboradores",
            "icon" => "bi bi-people",
            "route" => "loja.dashboard.colaboradores.index",
            "params" => function() { return ['loja' => session('loja_slug')]; }
        ],
        [
            "name" => "Financeiro",
            "icon" => "bi bi-currency-dollar",
            "route" => "loja.dashboard.financeiro.index",
            "params" => function() { return ['loja' => session('loja_slug')]; }
        ],
        [
            "name" => "Cadastros",
            "icon" => "bi bi-grid",
            "submenu" => [
                // [
                //     "name" => "Lojas",
                //     "route" => "dashboard.lojas.index",
                //     "active_prefix" => "dashboard.lojas.*",
                //     "icon" => "bi bi-shop",
                // ],
                [
                    "name" => "Meus Produtos",
                    "route" => "loja.dashboard.produtos.index",
                    "params" => function() { return ['loja' => session('loja_slug')]; },
                    "active_prefix" => "loja.dashboard.produtos.*",
                    "icon" => "bi bi-backpack"
                ],
            ]
        ],
    ]
];
