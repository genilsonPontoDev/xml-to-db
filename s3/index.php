<?php

require __DIR__ . '/lib/aws-sdk/aws-autoloader.php';

use Aws\S3\S3Client;

try {

    $s3Client = new S3Client([
        'region' => 'us-east-1', // Região do bucket S3
        'version' => 'latest',  // Versão da API
        'credentials' => [
            'key'    => 'sua-chave-de-acesso',
            'secret' => 'sua-chave-secreta',
        ],
        'suppress_php_deprecation_warning' => true, // Ignora o aviso de depreciação
    ]);

    // Listar buckets S3
    $result = $s3Client->listBuckets();

    echo "Lista de buckets:\n";
    foreach ($result['Buckets'] as $bucket) {
        echo "- " . $bucket['Name'] . "\n";
    }
} catch (Exception $e) {
    // Trata erros da AWS SDK
    echo "Erro: " . $e->getMessage() . "\n";
}
