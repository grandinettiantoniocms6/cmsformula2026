<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public).
    |
    */
    'dir' => [],

    /*
    |--------------------------------------------------------------------------
    | Filesystem disks (Flysytem)
    |--------------------------------------------------------------------------
    |
    | Define an array of Filesystem disks, which use Flysystem.
    | You can set extra options, example:
    |
    | 'my-disk' => [
    |        'URL' => url('to/disk'),
    |        'alias' => 'Local storage',
    |    ]
    */
    'disks' => [
        'uploads' => [
            'alias' => 'uploads',   // nome mostrato a sinistra
            'URL'   => '/uploads',  // URL esplicito (evita slash finali)
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */

    'route' => [
        'prefix'     => config('backpack.base.route_prefix', 'admin').'/elfinder',
        'middleware' => ['web', config('backpack.base.middleware_key', 'admin')], //Set to null to disable middleware filter
    ],

    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */

    'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',

    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */

    'roots' => null,

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */
    'options' => [
        'imgLib'  => 'gd',   // o 'imagick' se ce l’hai
        'tmbSize' => 140,    // opzionale: grandezza thumb
    ],

    'root_options' => [
        // salva le thumbs in /public/uploads/.tmb (cartella nascosta)
        'tmbPath' => '.tmb',
        // e dillo anche come URL pubblico (così può servirle via file)
        'tmbURL'  => '/uploads/.tmb',
        // nascondi la cartella .tmb dall’interfaccia
        'attributes' => [[
            'pattern' => '/^\.tmb$/',
            'read'    => false,
            'write'   => false,
            'hidden'  => true,
            'lock'    => true,
        ]],
    ],
];
