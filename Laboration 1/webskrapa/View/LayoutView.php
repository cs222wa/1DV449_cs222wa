<?php
//LayoutView class
namespace view;

class LayoutView
{

//calls function to render HTML layout
    public function setLayout($compile, $compView, $formView){
    $this->render($compile, $compView, $formView);
}

    private function render($compile, $compView, $formView)
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
                ' . $formView->renderForm() . '
            </div>
                '. $compView->renderResult($compile) .'
          </div>
         </body>
      </html>
    ';

    }

/*
    public function setLayout($compile, $compView, $formView){
        if($compile){
            return $compView->response();
        }
        return $formView->renderForm();
    }

*/


}
