<?php
//LayoutView class test
namespace view;

class LayoutView
{

//calls function to render HTML layout
    public function setLayout(){
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
                '. $this->renderResult() .'
          </div>
         </body>
      </html>
    ';

    }


    public function renderForm()
    {
        return "
        <form id='start' action='Controller/Controller.php' method='post'accept-charset='UTF-8'>
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
        //is set Post-url - från formulär

        //skapa klass gör jämförelsedata


        //från den klassen - skapa skrap-klass där all data hämtas ut och returneras till jämförelsedatata

        //jämförelseklassen returnerar resultatet av all beräkning.

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
