<?php
//DinnerView class
namespace view;

use model\Compiler;
use model\Scraper;

class DinnerView
{
    public function renderDinnerHTML($compiler, $day, $time){
        echo '<!DOCTYPE html>
          <html>
            <head>
              <meta charset="utf-8">
              <link rel="stylesheet" type="text/css" href="css/style.css">
              <title>Movie/Dinner Planner</title>
            </head>
            <body>
              <div class="container">
                <div id=results>
                        '. $this->renderDinnerResult($compiler, $day, $time) .'
                </div>
              </div>
             </body>
          </html>
        ';
    }

    private function renderDinnerResult($compiler, $day, $time){
        //hittar inte klassens metoder, varför???
        //metoden kopplar inte $compiler, $day eller $time till parametrarna i renderDinnerHTML.
       $results = $compiler->fetchDinnerResults($day, $time);
       return $results;
    }


}