<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => env('LOCAL') == 1 ? storage_path('app/public') : public_path('uploads'),
            'url' => env('LOCAL') == 1 ? env('APP_URL').'/storage' : env('APP_URL').'/uploads',
            'visibility' => 'public',
        ],
        'sqldumps' => [
            'driver' => 'local',
            'root' => database_path('sql'),
        ],
        'public_plugin_products' => [
            'driver' => 'local',
            'root' => public_path('plugins/pluginProducts'),
            'url' => '/plugins/pluginProducts',
        ],
        'public_plugin_caccia' => [
            'driver' => 'local',
            'root' => public_path('plugins/pluginCaccia'),
            'url' => '/plugins/pluginCaccia',
        ],

        'public_uploads' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'url' => env('APP_URL').'/uploads',
            'visibility' => 'public',
        ],

        'uploads' => [
            'driver'     => 'local',
            'root'       => public_path('uploads'),
            'url'        => '/uploads',   // niente slash finale, niente APP_URL
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

        // used for Backpack/BackupManager
        'backups' => [
            'driver' => 'local',
            'root'   => storage_path('backups'), // that's where your backups are stored by default: storage/backups
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
