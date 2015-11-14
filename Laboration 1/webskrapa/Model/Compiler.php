<?php
//Compiler class
namespace model;

use model\Scraper;

class Compiler
{
    private $url;
    private $scraper;
    private $startLinks;
    private $freeDays;

    public function __construct($url){
        $this->url = $url;
        $this->scraper = new Scraper();
        $this->startLinks = $this->scraper->getNodes($url, '//a/@href');
        $this->freeDays = ""; //call function to scrape calendars
        //call function to scrape dinner
    }

    //compiles the results from the different arrays
    public function fetchResults(){
        return "";
    }
}
