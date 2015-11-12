<?php
//FormView class
namespace view;

class FormView
{
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

}
