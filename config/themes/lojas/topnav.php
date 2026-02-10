<?php

// arquivo de configuração da topnav principal
return [
    [
        "name" => "Menu",
        "submenu" => [
            [
                "name" => "Ação 1",
                "route" => "login",
            ],
            [
                "name" => "Ação 2",
                "route" => "logout",
            ],
        ]
    ],
    [
        "name" => "Sobre nós",
        "route" => "dashboard.index",
    ],
];