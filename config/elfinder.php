<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Non usare 'dir' se usi roots/disks
    |--------------------------------------------------------------------------
    */
    'dir' => [],

    /*
    |--------------------------------------------------------------------------
    | Non usiamo i dischi qui (configuriamo una root esplicita)
    |--------------------------------------------------------------------------
    */
    'disks' => [],

    /*
    |--------------------------------------------------------------------------
    | Route di elFinder
    |--------------------------------------------------------------------------
    */
    'route' => [
        'prefix'     => config('backpack.base.route_prefix', 'admin').'/elfinder',
        'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    ],

    /*
    |--------------------------------------------------------------------------
    | Access control
    |--------------------------------------------------------------------------
    */
    'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',

    /*
    |--------------------------------------------------------------------------
    | Root esplicita: /public/uploads
    |--------------------------------------------------------------------------
    | - URL senza slash finale => niente '//' nei link
    | - tmbPath relativo alla root => /public/uploads/tmb
    */
    'roots' => [[
        'driver'        => 'LocalFileSystem',
        'alias'         => 'uploads',
        'path'          => public_path('uploads'),
        'URL'           => '/uploads', // <-- niente slash finale
        'accessControl' => 'Barryvdh\Elfinder\Elfinder::checkAccess',

        // Thumbnails
        'tmbPath'       => 'tmb',

        // Nascondi la cartella tmb dall'interfaccia
        'attributes'    => [[
            'pattern' => '/^tmb$/',
            'read'    => false,
            'write'   => false,
            'hidden'  => true,
            'lock'    => true,
        ]],
    ]],

    /*
    |--------------------------------------------------------------------------
    | Opzioni globali del connector
    |--------------------------------------------------------------------------
    */
    'options' => [
        'imgLib'  => 'gd',   // o 'imagick' se installato
        'tmbSize' => 140,
    ],

    /*
    |--------------------------------------------------------------------------
    | Root options di default (applicate a ogni root)
    |--------------------------------------------------------------------------
    | Lasciamo vuoto per evitare di sovrascrivere tmbPath definito nella root.
    */
    'root_options' => [
        // aggiungi qui eventuali opzioni comuni a tutte le roots
    ],
];
