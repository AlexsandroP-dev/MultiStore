<?php

// arquivo de configuração da sidebar principal
return [
    "sideBarHeaderName" => "MultiStore",
    "sideBarHeaderRoute" => "dashboard.index",
    "sideBarItems" => [
        [
            "name" => "Dashboard",
            "icon" => "bi bi-app",
            "route" => "dashboard.index"
        ],
        [
            "name" => "Cadastros",
            "icon" => "bi bi-grid",
            "submenu" => [
                [
                    "name" => "Lojas",
                    "route" => "dashboard.lojas.index",
                    "icon" => "bi bi-shop",
                ],
                [
                    "name" => "Categorias",
                    "route" => "login",
                    "icon" => "bi bi-tags"
                ],
            ]
        ],
    ]
];
