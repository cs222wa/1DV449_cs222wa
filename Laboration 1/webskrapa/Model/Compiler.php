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
    private $cinemaTitles;

    public function __construct($url){
        $this->url = $url;
        $this->scraper = new Scraper();
        $this->startLinks = $this->scraper->getLinks($this->url, '//a/@href');  //get startlinks as array
        $this->freeDays = $this->getFreeDays(); //get free days for all friends as array  (freeDays[0];
        $this->cinemaDays = $this->cinemaDays(); //get the days cinema is displayed
        $this->cinemaTitles = $this->cinemaTitles(); //get the titles of the movies available.

        //run json script to access availablilty and time for different titles.

        //call function to scrape dinner
    }

    //compiles the results from the different arrays
    public function fetchResults(){
        return "";
    }

    private function getFreeDays(){
        //TODO: add foreach loop to find which post in the startLinks array contains the link leading to calendars?

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

        //create new curl using the /cinema link.
        //perhaps more than once?
        //figure out how to follow scripts using curl to collect data and move forward.
        return $movieDays;
    }

    private function cinemaTitles(){
        $movieUrl = $this->url . $this->startLinks[1];
        $movieTitles = $this->scraper->scrapeCinemaTitles($movieUrl);

        return $movieTitles;

    }
}
