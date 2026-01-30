<?php

// arquivo de configuração da sidebar principal
return [
    "sideBarHeaderName" => "MultiStore",
    "sideBarHeaderRoute" => "dashboard",
    "sideBarItems" => [
        [
            "name" => "Dashboard",
            "icon" => "bi bi-speedometer2",
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
                    "route" => "dashboard",
                    "icon" => "bi bi-tags"
                ],
            ]
        ],
    ]
];
