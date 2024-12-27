<?php

class ReadXml {

    public $xml;
    public function __construct() {
        
    }

    static function parse($xml) {
        $xml = simplexml_load_string($xml);
        return $xml;
    }

}