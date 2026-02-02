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
                    "active_prefix" => "dashboard.lojas.*",
                    "icon" => "bi bi-shop",
                ],
                [
                    "name" => "Categorias",
                    "route" => "login",
                    "active_prefix" => "login",
                    "icon" => "bi bi-tags"
                ],
            ]
        ],
    ]
];
