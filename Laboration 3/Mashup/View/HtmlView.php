<?php
class HtmlView
{
    public function render(){
        echo '<!DOCTYPE html>
            <html>
                <head>
                     <meta charset="utf-8">
                    <link rel="stylesheet" type="text/css" href="css/style.css">
                    <title>Mashup Application</title>
                </head>
                <body>
                    <div>
                        <h1>Traffic Information</h1>
                    </div>
                    <div id="content">
                    <p> >Map here< </p>

                    </div>
                </body>
            </html>
        ';
    }
}