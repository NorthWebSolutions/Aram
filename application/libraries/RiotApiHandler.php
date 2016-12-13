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

    public function getSummonerBySummonerName($summonerName) {





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


//            https://eune.api.pvp.net/api/lol/24214623/v1.3/game/by-summoner/eune/recent?api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6
//            https://eune.api.pvp.net/api/lol/eune/v2.2/matchlist/by-summoner/24214623?api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6
//                
//            /api/lol/{region}/v2.2/matchlist/by-summoner/{summonerId}

        $string = "/api/lol/{region}/v1.3/game/by-summoner/{summonerId}/recent";
        $url = $this->CI->AC->buildCURL($string, $summonerID);
        $result = $this->CI->AC->getCurl($url);
        return $result;
    }

    public function getMacthHistory() {

//            https://eune.api.pvp.net/api/lol/eune/v2.2/matchlist/by-summoner/24214623?api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6
//                
//            /api/lol/{region}/v2.2/matchlist/by-summoner/{summonerId}

        $string = "/api/lol/{region}/v2.2/matchlist/by-summoner/{summonerId}";
        $url = $this->buildCURL($string);
        $result = $url; //$this->getCurl($url);
        return $result;
    }
}
