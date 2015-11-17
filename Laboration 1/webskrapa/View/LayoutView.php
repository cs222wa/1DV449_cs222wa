<?php
//LayoutView class
namespace view;

use model\Compiler;
use model\Scraper;
use view\DinnerView;

class LayoutView
{
    private $compiler;
    private $dinnerView;

    public function __construct(){
        $this->dinnerView = new DinnerView();
        $this->compiler = null;
    }

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
            $this->compiler = new Compiler($url);
            //returns the compiled results of the scraping
            $results = $this->compiler->fetchMovieResults();
            //concatinate values from result array into a list html element and return to view.
            $display = "<h2>Enligt era kalendrar har ni möjlighet att se följande filmer: </h2>";
            $display .= "<ul class='movieList'>";
            foreach($results as $key=>$value){
                //make a HTML list item containing title and time of every movie available

                //TODO: ADD A LINK WITH ACTION $THIS->PICKMOVIE(//PARAMETERS DAY AND TIME);
                $display .= "<li class='movie'>" . $value['title'] . ", som går klockan: " . $value['time']. " på " . $value['day']. "</li>";
            }
            $display .= "</ul>";
            return $display;
        }
        //if no adress has been added - return false;
        return false;
    }

    private function pickMovie($day, $time){
        //function used to "onclick" the movie-link
        //Send $compiler object into the
        $this->dinnerView->renderDinnerHTML($this->compiler, $day, $time);
        //along with the chosen day and time.
    }
}
