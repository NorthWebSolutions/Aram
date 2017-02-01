<?php

/**
 * Description of ApiConnector
 *
 * @author mrgab
 */
class ApiConnector {
    //put your code here
    

    
    
    
    protected $myAPIkey = "RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6";
    private $defLocation = "eune";
    private $locations = array("br, eune, euw, jp, kr, lan, las, na, oce, ru, tr");
    

    
    
    public function buildCURL($URL_String, $summonerID = FALSE, $base = false) {
        
        
        $find = array("{region}");
       
        if (!$base) {
            $base = "https://eune.api.pvp.net";
        }
        
        if($summonerID != FALSE){$find[] = "{summonerId}";}
        
       
        //$string = "/api/lol/{region}/v2.2/matchlist/by-summoner/{summonerId}";

        
        $replace = array($this->defLocation, $summonerID);

        $formated_string = str_replace($find, $replace, $URL_String);

        ///api/lol/eune/v2.2/matchlist/by-summoner/24214623 
        
        $return_str = $base . $formated_string . "?api_key=" . $this->myAPIkey;
        return $return_str;

    }

    public function getCurl($URL_String) {

        if (!is_string($URL_String) && $URL_String != '') {
            return "0";
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $URL_String);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        $res_array = json_decode($result, true);
        return $res_array;
    }
    
}