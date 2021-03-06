<?php
class Radio
{
    private static $fileName = 'response.json';
    private $cache;
    public function getInfo(){
        $traffic = null;
        //If file is too old - create a new request
        if(file_exists(self::$fileName) && time() - filemtime(self::$fileName) > 60 * 1){
            echo("<p>NY TRAFIKINFORMATION HAR HÄMTATS.</p>");
            //fetch new traffic information
            $traffic = $this->fetchCurlPage();
            //if the fetched information is not empty/null
            if($traffic !== null){
                //write json response to cache.
                $this->cache = fopen('response.json', 'w');
                fwrite($this->cache, $traffic);
                fclose($this->cache);
            }
            else{
                //if trafficinformation is empty return time of latest json response
                $fileTime = date("j M Y H:i:s", filemtime(self::$fileName));
                return "Information från Sveriges Radio är för tillfället ej tillgängligt. Senaste version: {$fileTime}";
            }
        }
        else{
            echo "<p>CACHE ANVÄNDS</p>";
        }
        return false;
    }
    public function fetchCurlPage()
    {
        $ch = curl_init();
        $url = "http://api.sr.se/api/v2/traffic/messages?format=json&pagination=false";
        curl_setopt( $ch, CURLOPT_USERAGENT, 'cs222wa@student.lnu.se' );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $page = curl_exec($ch);
        curl_close($ch);
        return $page;
    }
}