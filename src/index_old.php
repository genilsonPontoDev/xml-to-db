<?php

// Inclua a classe Nfe corretamente
require_once __DIR__ . '/class/Nfe.php'; 

// Use o namespace correto da classe Nfe
use Nfe\Nfe;

try {
    
    $xmlContent = file_get_contents(__DIR__ . '../aprocessar/31241125686353000118550030001655651118036595.xml');    
    
    $nfe = new Nfe($xmlContent);
    
    var_dump($nfe->CNPJ->getContent());    

    var_dump($nfe->emit->getContent()); 

    var_dump($nfe->nro->getContent());

    var_dump($nfe->enderEmit->getContent());

    var_dump($nfe->infNFe->getContent());

    var_dump($nfe->infdsadsadadsNFae->getContent());

    var_dump($nfe->NFe->getContent());
    

} catch (Exception $e) {
    // Captura e exibe o erro
    echo "Erro: " . $e->getMessage();
}
