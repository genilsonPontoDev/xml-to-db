<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;

// Configuração de exemplo
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'credentials' => [
        'key'    => 'sua-chave-de-acesso',
        'secret' => 'sua-chave-secreta',
    ],
]);

echo "AWS SDK instalado com sucesso!";
