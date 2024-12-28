<?php
namespace App\Library;

class ReadXml {    
    static function parse($xml) {
        $xml = simplexml_load_string($xml);
        return $xml;
    }

}