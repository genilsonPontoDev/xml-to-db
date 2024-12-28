<?php

/* require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Core/bootstrap.php';

Router::post('/', ['App\UseCase\SaveNfe', 'register']); */


require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Core/bootstrap.php';

use Core\Env;
Env::load();

use App\UseCase\SaveNfe;

// Configurações do S3/MinIO
$config = [
    'version' => 'latest',
    'region' => 'us-east-1',
    'endpoint' => 'https://s3.g7.maximizebot.com.br/',
    'use_path_style_endpoint' => true,
    'credentials' => [
        'key' => 'GTdLiSEbPn8BSSFjdWtP',
        'secret' => 'FKkYYddrMV2OB4OMfFy17Gs26riBP6SBY1DCbrc2',
    ],
    'http' => [
        'debug' => false,
    ]
];

$saveNfe = new SaveNfe($config);
$saveNfe->register();