<?php

/**
 * Description of RiotApiHandler
 *
 * @author mrgab
 */
class RiotApiHandler {

    //put your code here
    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function getSummonerIdBySummonerName($summonerName) {





        $URL_String = "/api/lol/{region}/v1.4/summoner/by-name/$summonerName";

        $URL = $this->CI->AC->buildCURL($URL_String);

        $result = $this->CI->AC->getCurl($URL);

        //$this->CI->SF->prh($result);
        //     [viperace] => Array
//        (
//            [id] => 24214623
//            [name] => Viperace
//            [profileIconId] => 1391
//            [summonerLevel] => 30
//            [revisionDate] => 1479666950000
//        )
        return $result;
    }

    public function getRecentBySummonerId($summonerID) {
        $string = "/api/lol/{region}/v1.3/game/by-summoner/{summonerId}/recent";
        
        // if it is an array-> make the loop-> filter-data -> fill up summonerIDs
        if(is_array($summonerID)){
            
            $counter = 0;
            foreach ($summonerID as $key => $value) {
                
                $url = $this->CI->AC->buildCURL($string, $key);
                $result[$key] = $this->CI->AC->getCurl($url);
            }
            
        ///////////// NORMAL type of variable:    
        }else {
            
        


//            https://eune.api.pvp.net/api/lol/24214623/v1.3/game/by-summoner/eune/recent?api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6
//            https://eune.api.pvp.net/api/lol/eune/v2.2/matchlist/by-summoner/24214623?api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6
//                
//            /api/lol/{region}/v2.2/matchlist/by-summoner/{summonerId}

        
        $url = $this->CI->AC->buildCURL($string, $summonerID);
        $result = $this->CI->AC->getCurl($url);
        }
        
        return $result;
    }
    public function getChampNfoByID($champID) {
        //   /api/lol/static-data/{region}/v1.2/champion/{id} 
        //   api/lol/static-data/eune/v1.2/champion/245?api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6
                
        $string = "/api/lol/static-data/{region}/v1.2/champion/$champID";
        $url = $this->CI->AC->buildCURL($string,false, "https://global.api.pvp.net/");
        $result = $this->CI->AC->getCurl($url);
        return $result;
        
    }


    public function getChampionNfo($param) {
        //print_r($param);


        $string = "/api/lol/static-data/{region}/v1.2/champion/$param";


        ///// REQUEST STATIC DATA FROM GLOBAL
        // buildCURL( string, *BASE )                                       #optional https://global.api.pvp.net   whitout last "/"
        $url = $this->CI->AC->buildCURL($string,false, "https://global.api.pvp.net/");
        $result = $this->CI->AC->getCurl($url);

        return $result;
    }

}
