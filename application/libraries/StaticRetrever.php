<?php

//put your code here
class StaticRetrever {

    //put your code here
    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }
    
    
    
    
    public function saveChampIconsToLocal($list_of_Ids) {
        
        
        foreach ($list_of_Ids as $key => $value) {
            
            
            $local_path_base = "/asset/champions/";
            
            
            
            
        }
        
    }
    
    
    
    

    public function baseChampImg($param) {
        
                        $this->CI->SF->prh($param);
                die;
        
        if( is_array($param)){
            if($param["champArray"] != false){
                $champ_name = $param["name"];
                $champ_title = $param["title"];
                //$champ_id = $param["id"];
                
                

                $statSrcPart = "http://ddragon.leagueoflegends.com/cdn/5.2.1/img/champion/";
                
                $img_options = array("url" =>  $statSrcPart.$param['champArray']['image']['full'], "alt" => "$champ_name / $champ_title" );
                
        
        

        $result = $this->imgWrapper($img_options);
        return $result;
            }
        }
        
    }
    
        public function returnChampImgData($champID) {

            return FALSE;

        $params = array(
            'staticParam' => "champData=image",
            'url'         => "/api/lol/static-data/{region}/v1.2/champion/$champID",
            'base'        => "https://global.api.pvp.net/",
            'server'      => $this->CI->session->server
        );



        $url    = $this->CI->AC->buildCurl_extended($params);
        $result = $this->CI->AC->getCurl($url);
        
        
        $statSrcPart = "http://ddragon.leagueoflegends.com/cdn/5.2.1/img/champion/";
        ///req data: URL, Alt, Class, data-params
        $returnData["url"] = $statSrcPart.$result["image"]["full"]; 
        $returnData["alt"] = $result["name"];
        return "$returnData";
        
        
        ///geather data for imageWraper
        
        

        //$this->CI->SF->prh($url);
        //$this->CI->SF->prh($result);
//        $statSrcPart = "http://ddragon.leagueoflegends.com/cdn/5.2.1/img/champion/";
//        
//        $finalResult["url"] = $statSrcPart.$result["image"]["full"];
//        $img_options = array("url" => $statSrcPart.$result["image"]["full"], "alt" => $result["name"]);
//        if(isset($ImgPackingOptions) && $ImgPackingOptions != false){
//            $img_options[] = $ImgPackingOptions;
//        }
//        
//        $finalResult["img"] = $this->imgWraper($img_options);
//        
//
//        return $finalResult;
        
        
        
        
        
        
    }

//    public function imageContainer($data,$options) {
//
//
//        //static srcPart
//       
//        $img_data["url"]    = $statSrcPart . $champFullImgName;
//        $img_data["alt"]    = $
//        $img_drawer  = "<img src=\"$src_full\" class=\"img img-circle\" alt=\"$champFullImgName\">";
//        return $img_drawer;
//    }

    public function imgWrapper($data) {

        if ( !isset($data["url"]) ) {
            return false;
        } else {
            $url = $data["url"];
        }
        
        //////////THIS LINE IS REVERSE->
        if ( isset($data["alt"]) ) {
            $alt = $data["alt"];
        } else {
            $alt = "NorthWebSolutions - IMG wrapper no image alt";
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
