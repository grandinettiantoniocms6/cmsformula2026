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
    'dir' => [],  // <— NON usare 'dir' se usi i dischi

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

    'roots' => [[
        'driver'        => 'LocalFileSystem',
        'alias'         => 'uploads',
        'path'          => public_path('uploads'),
        'URL'           => '/uploads',     // niente slash finale -> niente “//”
        'accessControl' => 'Barryvdh\Elfinder\Elfinder::checkAccess',
        'tmbPath'       => 'tmb',          // relative alla root => public/uploads/tmb
        // opzionale: nascondi la cartella tmb nell’interfaccia
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
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */
    'options' => [
        'imgLib'  => 'gd',   // o 'imagick'
        'tmbSize' => 140,
    ],

    'root_options' => [
        'tmbPath' => storage_path('app/elfinder-tmb'),
        'attributes' => [[
            'pattern' => '/^tmb$/',
            'read'    => false,
            'write'   => false,
            'hidden'  => true,
            'lock'    => true,
        ]],
    ],
];
