<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../Core/bootstrap.php';
require_once __DIR__ . '/../../../src/App/UseCase/SaveNfe.php';

use Core\Request;
use Core\Response;
use App\help\FactorRouterAll;

global $router;
global $model;

use App\UseCase\SaveNfe;

global $router;

// Configurações do S3/MinIO para o ENV
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


$router->get("/nfe/save", function() use ($config) {        
    $getxml = new SaveNfe($config);    
    $getxml->register();
});
