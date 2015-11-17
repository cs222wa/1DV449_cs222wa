<?php
//LayoutView class
namespace View;

use Model\Compiler;
use Model\Scraper;

class LayoutView
{

//calls function to render HTML layout
    public function setLayout()
    {
    $this->renderFormHTML();
    }

    private function renderFormHTML()
    {
       echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8">
              <link rel="stylesheet" type="text/css" href="css/style.css">
              <title>Movie/Dinner Planner</title>
            </head>
            <body>
              <div class="container">
                <div id="urlform">
                    ' . $this->renderForm() . '
                </div>
                <div id=results>
                        '. $this->renderResult() .'
                </div>
              </div>
             </body>
          </html>
        ';
    }

    public function renderForm()
    {
        return "
        <form id='start' method='post'accept-charset='UTF-8'>
            <fieldset >
                <!--<legend></legend>-->
                <input type='text' name='url' id='urlfield' maxlength='500' />
                <label for='urlfield' >Enter Url: </label>
                <input type='submit' name='Submit' value='Submit' />
            </fieldset>
        </form>
        ";
    }

    public function renderResult()
    {
        if(isset($_POST['url']))
        {
            $url= $_POST['url'];
            //initiates the scraping of the different pages
            $compiler = new Compiler($url);
            //returns the compiled results of the scraping
            $results = $compiler->fetchMovieResults();
            //concatinate values from result array into a list html element and return to view.
            $display = "<h2>Tillgängliga filmer: </h2>";
            $display .= "<ul class='movieList'>";
            if(count($results) == 0){
                $display .= "<p class='error'>Tyvärr, det fanns inga passande filmer :(</p>";
            }
            else{
                foreach($results as $key=>$value){
                    //make a HTML list item containing title and time of every movie available with a selection link
                    $display .= "<li class='movie'>" . $value['title'] . ", som går klockan: " . $value['time']. " på " . $value['day'].
                        "<a href=" . '?day='. $value['day'] . '&time='. $value['time'] . '&url='. $url . "> Välj film</a></li>";
                }
            }
            $display .= "</ul>";
            return $display;
        }
        if (isset($_GET['day']) && isset($_GET['time'])){
            return $this->pickMovieAndDisplayDinnerOptions();
        }
        //if no adress has been added - return false;
        return false;
    }

    //function used to "onclick" the movie-link
    public function pickMovieAndDisplayDinnerOptions(){
            $url = $_GET['url'];
            $compiler = new Compiler($url);
            //returns the compiled results of the scraping
            //fetch results of dinner scraping
            $dinnerResults = $compiler->fetchDinnerResults($_GET['day'], $_GET['time']);
            //concatinate values from result array into a list html element and return to view.
            $display = "<h2>Tillgängliga bokningar: </h2>";
            $display .= "<ul class='dinnerList'>";

            if(count($dinnerResults) == 0){
                $display .= "<p class='error'>Tyvärr, det fanns inga lediga bord att boka :(</p>";
            }
        else{
                foreach($dinnerResults as $dinnerTime) {
                    $display .= "<li class='dinner'>Mellan klockan " . implode(".00 - ", str_split($dinnerTime, 2)). ".00" ."</li>";
                }
            }
            $display .= "</ul>";

            return $display;
    }
}
