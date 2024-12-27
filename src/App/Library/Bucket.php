<?php
namespace App\Dto;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use SimpleXMLElement;

class Bucket
{
    private $s3;

    public function __construct($config)
    {
        $this->s3 = new S3Client([
            'version' => $config['version'],
            'region' => $config['region'],
            'endpoint' => $config['endpoint'],
            'use_path_style_endpoint' => $config['use_path_style_endpoint'],
            'credentials' => [
                'key' => $config['credentials']['key'],
                'secret' => $config['credentials']['secret'],
            ],
            'http' => [
                'debug' => $config['http']['debug'],
            ]
        ]);
    }

    public function processBuckets()
    {
        try {
            $buckets = $this->s3->listBuckets();
            foreach ($buckets['Buckets'] as $bucket) {
                $this->processBucket($bucket['Name']);
            }
        } catch (AwsException $e) {
            $this->handleError($e);
        }
    }

    private function processBucket($bucketName)
    {
        try {
            $objects = $this->s3->listObjects(['Bucket' => $bucketName]);
                           
            if (isset($objects['Contents']) && count($objects['Contents']) > 0) {
                foreach ($objects['Contents'] as $object) {  
                    $this->processFile($bucketName, $object['Key']);
                }
            } else {
                echo "Nenhum arquivo encontrado no bucket: {$bucketName}<br>";
            }
        } catch (AwsException $e) {
            $this->handleError($e);
        }
    }

    private function processFile($bucketName, $key)
    {
        try {
            $result = $this->s3->getObject(['Bucket' => $bucketName, 'Key' => $key]);
            $xmlContent = (string) $result['Body'];              
            return $xmlContent;
        } catch (AwsException $e) {
            echo "Erro ao processar o arquivo {$key} no bucket {$bucketName}: " . $e->getMessage() . "<br>";
        }
    }

    private function handleError(AwsException $e)
    {
        echo "Erro AWS: " . $e->getMessage() . "<br>";
        if ($e->getResponse()) {
            echo "Resposta de erro HTTP: " . $e->getResponse()->getBody() . "<br>";
        }
    }
}
