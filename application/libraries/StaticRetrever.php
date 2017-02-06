<?php

//put your code here
class StaticRetrever {

    //put your code here
    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function returnChampImg($champID) {
/// https://global.api.pvp.net/api/lol/static-data/eune/v1.2/champion/143?champData=image&api_key=RGAPI-c3556f5c-4cf3-40c8-981d-2815626365f6


        $params = array(
            'staticParam' => "champData=image",
            'url'         => "/api/lol/static-data/{region}/v1.2/champion/$champID",
            'base'        => "https://global.api.pvp.net/",
            'server'      => $this->CI->session->server
        );



        $url    = $this->CI->AC->buildCurl_extended($params);
        $result = $this->CI->AC->getCurl($url);

        //$this->CI->SF->prh($url);
        //$this->CI->SF->prh($result);
        $statSrcPart = "http://ddragon.leagueoflegends.com/cdn/5.2.1/img/champion/";
        
        $finalResult["url"] = $statSrcPart.$result["image"]["full"];
        $img_options = array("url" => $statSrcPart.$result["image"]["full"], "alt" => $statSrcPart.$result["name"]);
        $finalResult["img"] = $this->imgWraper($img_options);
        

        return $finalResult;
    }

    public function imageContainer($data,$options) {


        //static srcPart
       
        $img_data["url"]    = $statSrcPart . $champFullImgName;
        $img_data["alt"]    = $
        $img_drawer  = "<img src=\"$src_full\" class=\"img img-circle\" alt=\"$champFullImgName\">";
        return $img_drawer;
    }

    public function imgWraper($data) {

        if ( !isset($data["url"]) ) {
            return false;
        } else {
            $url = $data["url"];
        }
        if ( isset($data["alt"]) ) {
            $alt = $data["alt"];
        } else {
            $alt = $data["alt"];
        }

        if ( !isset($data["class"]) ) {
            $class = "champ-iconA img img-responsive img-circle";
        } else {
            $class = $data["class"];
        }
        if ( !isset($data["data-params"]) ) {
            $dataParams = "";
        } else {
            $dataParams = $data["data-params"];
        }

        $final_str = "<img src=\"$url\" class=\"$class\" $dataParams alt=\"$alt\">";
        return $final_str;
    }

}
