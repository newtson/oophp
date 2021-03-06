<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Kmom01",
                        "url" => "redovisning/kmom01",
                        "title" => "Redovisning för kmom01.",
                    ],
                    [
                        "text" => "Kmom02",
                        "url" => "redovisning/kmom02",
                        "title" => "Redovisning för kmom02.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Styleväljare",
            "url" => "style",
            "title" => "Välj stylesheet.",
        ],
        [
            "text" => "Docs",
            "url" => "dokumentation",
            "title" => "Dokumentation av ramverk och liknande.",
        ],
        [
            "text" => "Test &amp; Lek",
            "url" => "lek",
            "title" => "Testa och lek med test- och exempelprogram",
        ],
        [
            "text" => "Anax dev",
            "url" => "dev",
            "title" => "Anax development utilities",
        ],
        [
            "text" => "Guess game",
            "url" => "guessgame",
            "title" => "Spela gissa nummer lek",
        ],
        [
            "text" => "Tärningsspel 100",
            "url" => "dice",
            "title" => "Spela tärningsspel 100",
        ],
        [
            "text" => "Movie",
            "url" => "movie",
            "title" => "Film databas",
        ],
        [
            "text" => "TextFilter",
            "url" => "mytextfilter",
            "title" => "Text filter",
        ],
        [
            "text" => "Administratör",
            "url" => "admin",
            "title" => "admin",
        ],
        [
            "text" => "Page och Post",
            "url" => "pagepost",
            "title" => "page och post",
        ],
    ],
];
