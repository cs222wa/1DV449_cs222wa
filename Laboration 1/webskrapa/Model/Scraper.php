<?php
//Scraper class
namespace model;

class Scraper
{
    //gets the links from index page
    public function getNodes($url, $node){
       return $this->fetchCurlPage($url, $node);
    }

    public function fetchCurlPage($url, $node)
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
        $scrapedNodes = $this->scrapePage($page, $node);
        return $scrapedNodes;
    }

    public function scrapePage($page, $nodeToScrape){
        $dom = new \DOMDocument();
        //if HTML load is successful
        if($dom->loadHTML($page))
        {
            $xpath = new \DOMXPath($dom);
            $items = $xpath->query($nodeToScrape);
            //create array
            $nodeArray = [];
            foreach($items as $item)
            {
                // add node-values to array
                $nodeArray[] = $item->nodeValue;
            }
            return $nodeArray;
        }
        else
        {
            die("Fel vid inläsning av HTML");

        }
    }


    private function scrapeCalendar(){

    }

    private function compareCalendars(){
        //compare 3 calendars to find common days?
    }

    private function scrapeCinema(){

    }

    private function scrapeDinner(){

    }

}
