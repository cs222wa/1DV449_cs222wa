<?php
//Scraper class
namespace model;

class Scraper
{
    public function fetchCurlPage($url)
    {
        $ch = curl_init();
        //"http://localhost:8080"
        //specify the page to be fetched
        curl_setopt($ch, CURLOPT_URL, $url);
        //do not print the fetched page.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //fetch page
        $page = curl_exec($ch);
        //close curl
        curl_close($ch);
        return $page;
    }

    public function scrapePage($page, $node){

        $xpath = $this->createXPath($page);
        $items = $xpath->query($node);
        //create array
        $nodeArray = [];
        foreach($items as $item)
        {
            //add node-values to array
            $nodeArray[] = $item->nodeValue;
        }
        return $nodeArray;
    }

    private function createXPath($page){
        $dom = new \DOMDocument();
        //if HTML load is successful
        if($dom->loadHTML($page))
        {
            $xpath = new \DOMXPath($dom);
            return $xpath;
        }
        else
        {
            die("Fel vid inläsning av HTML");
        }
    }

    //gets the links from assignment index page
    public function getLinks($url, $node){
        $page = $this->fetchCurlPage($url);
        return $this->scrapePage($page, $node);
    }

    public function scrapeCalendar($calendarUrl){
        //create an XPath for the calendar
        $xpath = $this->createXPath($calendarUrl);
        //scrape the nodes inside DOM table
        $tableItems = $xpath->query("//td");
        //create array
        $calendarData = array();
        foreach($tableItems as $tableItem)
        {
            //if the node value of the table cell does not contain an "ok"
            if(strcasecmp($tableItem->nodeValue, "ok") == 0){
                array_push($calendarData, true);
            }
            else{
                //if the node value of the table cell contains an "ok"
                array_push($calendarData, false);
            }
        }
        return $calendarData;
    }

    private function scrapeCinema(){

    }

    private function scrapeDinner(){

    }

}
