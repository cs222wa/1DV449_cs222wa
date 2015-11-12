<?php
//Compiler class test
namespace model;

class Compiler
{
    public function fetchPage(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://localhost:8080");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;

    }
}
