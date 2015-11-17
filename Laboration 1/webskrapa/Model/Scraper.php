<?php
//Scraper class
namespace model;

class Scraper
{

    public function fetchCurlPage($url)
    {
        $ch = curl_init();
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
            if(strcasecmp($tableItem->nodeValue, "ok") == 0)
            {
                array_push($calendarData, true);
            }
            else
            {
                //if the node value of the table cell contains an "ok"
                array_push($calendarData, false);
            }
        }
        return $calendarData;
    }

    public function scrapeCinemaDays($cinemaUrl){
        //fetch page
        $page = $this->fetchCurlPage($cinemaUrl);
        //create xpath to cinema page
        $xpath = $this->createXPath($page);
        //get nodes from drop down menu
        $movieDays = $xpath->query('//select[@id="day"]//option[not(@disabled)]');
        return $movieDays;
    }

    public function scrapeCinemaSelections($cinemaUrl){
        //fetch page
        $page = $this->fetchCurlPage($cinemaUrl);
        //create xpath to cinema page
        $xpath = $this->createXPath($page);
       //get nodes from drop down menu
        $selections = $xpath->query('//select[@name="movie"]//option[not(@disabled)]');
        return $selections;
    }

    public function getMovies($cinemaUrl, $freeDays, $optionalDays, $movieOptions) {
        //create array
        $movieOccasions = array();
        //foreach day that the friends can choose from...
        foreach ($optionalDays as $day) {
            //...if a value in the array of optional days is the same as the node value of the day/days the friends are available...
            if (in_array($day->nodeValue, $freeDays)) {
                // then circle through all the different movie options for that day
                foreach ($movieOptions as $movie) {
                    // make a json request of the different values of days and movies
                    $jsonMovies = $this->fetchCurlPage($cinemaUrl . "/check?day=" . $day->getAttribute('value') .
                        "&movie=" . $movie->getAttribute('value'));
                    $decodedMovies = json_decode($jsonMovies, true);
                    foreach($decodedMovies as $decodedMovie){
                        if($decodedMovie['status'] == 1){
                            array_push($movieOccasions, array('time'=>$decodedMovie['time'], 'day'=>$day->nodeValue, 'title'=>$movie->nodeValue));
                        }
                    }
                }
            }
        }
        return $movieOccasions;
    }


    public function scrapeDinner($dinnerUrl, $day){
        //fetch dinner page
        $page = $this->fetchCurlPage($dinnerUrl);
        //create xpath to cinema page
        $xpath = $this->createXPath($page);
        //get nodes from radio button
        $selections = $xpath->query('//input[@name="group1"]');
        return $selections;
    }


}
