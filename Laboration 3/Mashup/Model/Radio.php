<?php
class Radio
{
    private static $fileName = 'response.json';
    private $cache;
    public function getInfo(){
        $traffic = null;
        //If file is older than 15 min - create a new request
        if(file_exists(self::$fileName) && time() - filemtime(self::$fileName) > 60 * 1){
            echo("New traffic information has been fetched.");
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
                return "Trafffic information from Sveriges Radio is currently unavailable. Latest version: {$fileTime}";
            }
        }
        else{
            echo "cache is used";
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