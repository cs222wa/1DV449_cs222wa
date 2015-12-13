<?php
class Controller
{
    private $webService;
    public function __construct(){
        $this->webService = new Radio();
    }
    public function getTraffic()
    {
        $this->webService->getInfo();
    }
}