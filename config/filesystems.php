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
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        
        'public_asset' => [
            'driver' => 'local',
            'root' => public_path('banner'),
            'visibility' => 'public',
        ],

        'public_asset_profil' => [
            'driver' => 'local',
            'root' => public_path('profil'),
            'visibility' => 'public',
        ],

        'public_asset_struktur' => [
            'driver' => 'local',
            'root' => public_path('struktur'),
            'visibility' => 'public',
        ],

        'public_asset_artikel' => [
            'driver' => 'local',
            'root' => public_path('artikel'),
            'visibility' => 'public',
        ],

        'public_asset_artikel_file' => [
            'driver' => 'local',
            'root' => public_path('artikel_files'),
            'visibility' => 'public',
        ],

        'public_asset_laporan' => [
            'driver' => 'local',
            'root' => public_path('laporan'),
            'visibility' => 'public',
        ],

        'public_asset_laporan_file' => [
            'driver' => 'local',
            'root' => public_path('laporan_files'),
            'visibility' => 'public',
        ],

        'public_asset_penilaian_file' => [
            'driver' => 'local',
            'root' => public_path('penilaian_files'),
            'visibility' => 'public',
        ],

        'public_asset_regulasi_file' => [
            'driver' => 'local',
            'root' => public_path('regulasi_files'),
            'visibility' => 'public',
        ],

        'public_asset_regulasi' => [
            'driver' => 'local',
            'root' => public_path('regulasi_image'),
            'visibility' => 'public',
        ],

        'public_asset_comprof' => [
            'driver' => 'local',
            'root' => public_path('comprof'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
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
