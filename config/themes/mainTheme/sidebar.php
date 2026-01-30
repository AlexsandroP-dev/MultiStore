<?php

// arquivo de configuração da sidebar principal
return [
    "sideBarHeaderName" => "MultiStore",
    "sideBarHeaderRoute" => "dashboard",
    "sideBarItems" => [
        [
            "name" => "Dashboard",
            "icon" => "bi bi-app",
            "route" => "dashboard"
        ],
        [
            "name" => "Cadastros",
            "icon" => "bi bi-grid",
            "submenu" => [
                [
                    "name" => "Produtos",
                    "route" => "login",
                    "icon" => "bi bi-box",
                ],
                [
                    "name" => "Categorias",
                    "route" => "logout",
                    "icon" => "bi bi-tags"
                ],
            ]
        ],
    ]
];
