<?php
namespace App;

class Aplication {
    public function __construct() {

    }

    public function start ()  {         
        $this->load();        
    }

    public function load () {        
        $path = __DIR__ . "/Http/";        
        foreach (glob($path . "*.php") as $filename) {            
            include $filename;
        }
    }

    public function index () {
        echo json_encode([
            'next' => true,
            'message' => 'Bem vindo a API',
            'payload' => []
        ]);
    }
}