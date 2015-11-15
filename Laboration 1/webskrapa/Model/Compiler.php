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
        $this->startLinks = $this->scraper->getNodes($this->url, '//a/@href');  //get startlinks as array
        $this->freeDays = $this->getFreeDays(); //get free days for all friends as array
        //call function to scrape dinner
    }

    //compiles the results from the different arrays
    public function fetchResults(){
        return "";
    }

    private function getFreeDays(){

        //add foreach loop to find which post in the array contains the link leading to calendars.

        //concatinate original url with the link to the calendars
        $calendarUrl = $this->url . $this->startLinks[0] ."/";
        //scrape the new page to get links to the friends calendars.
        $calendarLinks = $this->scraper->getNodes($calendarUrl, '//a/@href');
        var_dump($calendarLinks[0]);

        $calendars = array();

        //get all calendars and push result from scraping into $calendars



        return "";
    }


}
