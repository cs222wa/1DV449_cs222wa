<?php
class HtmlView
{
    public function render(){
        echo '<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <link rel="stylesheet" type="text/css" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
                    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> <!--JQuery Library-->
                    <script type="text/javascript" src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js?2"></script> <!--Leaflet CSS-->
                    <title>Mashup Application</title>
                </head>
                <body>
                    <div>
                        <h1>Traffic Information</h1>
                    </div>
                    <div id="content">
                    <div id="map" style="height: 440px; border: 1px solid #AAA;"></div>

                    </div>
                    <script type="text/javascript" src="response.json"></script>
                    <script type="text/javascript" src="maps/leaf-demo.js"></script>
                </body>
            </html>
        ';
    }
}