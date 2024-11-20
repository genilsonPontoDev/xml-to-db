<?php

// Inclua a classe Nfe corretamente
require_once __DIR__ . '/core/Nfe.php'; 

// Use o namespace correto da classe Nfe

try {
    
    $xmlContent = file_get_contents(__DIR__ . '../aprocessar/exemplo.xml');    
    
    $nfe = new Nfe($xmlContent);

    var_dump($nfe);
    
    /* var_dump($nfe->CNPJ->getContent());    

    var_dump($nfe->emit->getContent()); 

    var_dump($nfe->nro->getContent());

    var_dump($nfe->enderEmit->getContent());

    var_dump($nfe->infNFe->getContent());

    var_dump($nfe->infdsadsadadsNFae->getContent());

    var_dump($nfe->NFe->getContent()); */

    //var_dump($nfe->emit->CNPJ);
    

} catch (Exception $e) {
    // Captura e exibe o erro
    echo "Erro: " . $e->getMessage();
}

if ($nfe->emit->CNPJ == '12345678000195') {
    echo 'CNPJ OK';
} else {
    echo 'CNPJ ERROR';
}