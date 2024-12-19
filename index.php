<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Core/bootstrap.php';


use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use App\Dto\Nfe;
use SimpleXMLElement;

// Configuração do cliente S3 com o endpoint do MinIO
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',  // Pode ser qualquer valor, pois o MinIO não requer uma região específica
    'endpoint' => 'https://s3.g7.maximizebot.com.br/', // Substitua pelo endpoint do seu servidor MinIO
    'use_path_style_endpoint' => true, // Necessário para o MinIO
    'credentials' => [
        'key'    => 'GTdLiSEbPn8BSSFjdWtP',  // Substitua pela chave de acesso do MinIO
        'secret' => 'FKkYYddrMV2OB4OMfFy17Gs26riBP6SBY1DCbrc2',    // Substitua pela chave secreta do MinIO
    ],
    'http' => [
        'debug' => false, // Ativa o log HTTP para depuração
    ]
]);

try {
    // Tentando listar os buckets para verificar a conexão com o MinIO
    $result = $s3->listBuckets();   
    
    // Verificando se a conexão foi bem-sucedida
    //echo "Conexão bem-sucedida com o MinIO! Buckets disponíveis:\n";
    foreach ($result['Buckets'] as $bucket) {
        //echo "Bucket encontrado: " . $bucket['Name'] . "\n";
        
        // Listar os objetos dentro do bucket
        $objects = $s3->listObjects([
            'Bucket' => $bucket['Name']
        ]);
        
        // Verificar se há objetos dentro do bucket
        if (isset($objects['Contents']) && count($objects['Contents']) > 0) {
            foreach ($objects['Contents'] as $object) {
                $key = $object['Key'];  // Nome do arquivo (chave do objeto)
                
                //echo "Processando arquivo: " . $key . "\n";
                
                // Baixar o arquivo XML do S3
                $result = $s3->getObject([
                    'Bucket' => $bucket['Name'],
                    'Key'    => $key
                ]);
                
                // Obter o conteúdo do arquivo XML
                $xmlContent = (string) $result['Body'];  // Conteúdo do arquivo XML como string                
                
                //echo "<pre>";
                echo($xmlContent);

                $myNfe = new Nfe($xmlContent);
                
                echo "<br><br><br>";
                var_dump($myNfe->ide-getContent()); die('<<<');
                
                // Carregar o conteúdo XML como um objeto SimpleXMLElement
                try {
                    $xml = new SimpleXMLElement($xmlContent);
                    $myXml = file_get_contents($xml);
                    echo "XML carregado com sucesso para o arquivo: " . $key . "\n";            

                    // Aqui você pode processar o XML como necessário
                    // Exemplo de acesso a dados dentro do XML
                    // echo $xml->asXML();  // Imprime o XML carregado

                    // Exemplo de iteração sobre os dados do XML
                    // Vamos supor que o XML tenha uma estrutura com um nó chamado "nfe"
                    if (isset($xml->nfe)) {
                        echo "Processando NFE: " . $xml->nfe->codigo . "\n";
                    }
                    
                } catch (Exception $e) {
                    echo "Erro ao processar o XML do arquivo " . $key . ": " . $e->getMessage() . "\n";
                }
            }
        } else {
            echo "Nenhum arquivo encontrado no bucket: " . $bucket['Name'] . "\n";
        }
    }
} catch (AwsException $e) {
    // Captura de exceção em caso de erro e exibe a mensagem de erro
    echo "Erro ao tentar conectar ou listar os buckets do MinIO:\n";
    
    // Exibindo o erro detalhado para debug
    echo "Mensagem do erro: " . $e->getMessage() . "\n";
    echo "Código do erro: " . $e->getCode() . "\n";
    echo "Erro completo:\n" . $e->getTraceAsString() . "\n";

    // Debug adicional: conteúdo da resposta HTTP de erro
    if ($e->getResponse()) {
        echo "Resposta de erro HTTP: " . $e->getResponse()->getBody() . "\n";
    }
}
?>
