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
    private $cinemaDays;
    private $movies;

    public function __construct($url){
        $this->url = $url;
        $this->scraper = new Scraper();
        $this->startLinks = $this->scraper->getLinks($this->url, '//a/@href');  //get startlinks as array
        $this->freeDays = $this->getFreeDays(); //get free days for all friends as array  (freeDays[0];
        $this->cinemaDays = $this->cinemaDays(); //get the days cinema is displayed
        $this->cinemaSelections = $this->cinemaSelections(); //get the titles of the movies available.
        $this->movies = $this->getMovies();
    }

    //compiles the results from the different arrays
    public function fetchMovieResults(){
        return $this->movies;
    }

    public function fetchDinnerResults($day, $time){
        $dinnerSelections = $this->scraper->scrapeDinner($this->url . $this->startLinks[2] ."/", $day);

        //TODO:
        //get $this->freeDays (01, 02, 03)
        //assign 01 = fre, 02 = lor 03 = son
        //if attribute in freeDay corresponds with attribute in $dinnerselections string (starts with 'lor' ex: 'lor1820')
        //save object in seperate array
        //then compare values of time with the $time received as parameter.
        //return array with times corresponding.



        //compare values of day, time with nodeValues in scraped information from $dinner
        //in order to return array of corresponding dinner options.
        foreach($dinnerSelections as $selection){
            var_dump($selection->getAttribute('value'));
        }

        return "";
    }

    private function getFreeDays(){
        //concatinate original url with the link to the calendars
        $calendarUrl = $this->url . $this->startLinks[0] ."/";
        //scrape the new page to get links to the friends calendars.
        $calendarLinks = $this->scraper->getLinks($calendarUrl, '//a/@href');
        //create multidimensional array to store data from all calendars
        $calendars = array();
        //get all calendars and push result from scraping into $calendars
        foreach($calendarLinks as $link){
            //scrape each individual calendar
            $calendar = $this->scraper->scrapeCalendar($this->scraper->fetchCurlPage($calendarUrl . "/" . $link));
            //push arrays of calendar information from all individual calendars into $calendars
            array_push($calendars, $calendar);
        }
        //create array to store values for each day of the weekend
        $weekend = array(0,0,0);
        //foreach individual calendar...
        foreach($calendars as $indCalendar){
            //as long as the indivual calendar holds a value...
            for($i = 0; $i < count($indCalendar); $i = $i + 1){
                //add the value from the individual calendar into the $weekend array on choresponding index
                $weekend[$i] += $indCalendar[$i];
            }
        }
        //create array to hold the days that all friends are free on
        $freeWeekendDays = array();
        //if the weekday in the weekend array holds the same amount of values as there are individual calendars...
        if($weekend[0] == count($calendars)){
            //add the weekday all friends are free on to the freeWeekendDay array
            array_push($freeWeekendDays, "Fredag");
        }
        if($weekend[1] == count($calendars)){
            array_push($freeWeekendDays, "Lördag");
        }
        if($weekend[2] == count($calendars)){
            array_push($freeWeekendDays, "Söndag");
        }
        //return array containing the weekdays all three friends are free.
        return $freeWeekendDays;
    }

    private function cinemaDays(){
        $movieUrl = $this->url . $this->startLinks[1];
        $movieDays = $this->scraper->scrapeCinemaDays($movieUrl);
        return $movieDays;
    }

    private function cinemaSelections(){
        $movieUrl = $this->url . $this->startLinks[1];
        $movieselections = $this->scraper->scrapeCinemaSelections($movieUrl);
        return $movieselections;
    }

    public function getMovies(){
        $movieUrl = $this->url . $this->startLinks[1];
        $movies = $this->scraper->getMovies($movieUrl, $this->freeDays,  $this->cinemaDays, $this->cinemaSelections);
        return $movies;
    }
}
