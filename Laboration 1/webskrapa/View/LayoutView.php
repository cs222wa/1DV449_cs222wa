<?php
//LayoutView class
namespace view;

use model\Compiler;
use model\Scraper;

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
            $display = "<h2>Enligt era kalendrar har ni möjlighet att se följande filmer: </h2>";
            $display .= "<ul class='movieList'>";
            foreach($results as $key=>$value){
                //make a HTML list item containing title and time of every movie available
                $display .= "<li class='movie'>" . $value['title'] . ", som går klockan: " . $value['time']. " på " . $value['day']. "</li>";
            }
            $display .= "</ul>";
            return $display;
        }
        //if no adress has been added - return false;
        return false;
    }
}
