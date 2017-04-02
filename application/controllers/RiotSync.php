<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RiotSync
 *
 * @author Mr Gabor Eszaki / North Web solutions LTD.
 */
class RiotSync extends CI_Controller {

    private $SW_show_not_aram_game       = false;
    private $SW_show_stored_aram_game    = false;
    private $SW_show_user_list           = true;
    private $SW_show_user_error          = true;
    private $SW_show_user_process        = false;
    private $SW_show_user_processed_list = false;
    private $SW_show_updated             = true;
    
    private $updated_rows             = array();
    private $updated_rows_c             = 0;
    


    public function __construct() {
        parent::__construct();
        if ( $this->session->nws_login != TRUE ) {
            redirect("Login/index");
        }
        $this->load->model('aram_model');
        $this->load->model('users_model');
    }

    public function index() {

        //new rutine:
        // new display:

        $data['title'] = "RiotSync App";
        $this->load->view('/templates/header',$data);
        $this->load->view('/templates/start_content',$data);
        $this->autosync();
        //$this->load->view('/sync/index',$data);
        $this->load->view('/templates/stop_content',$data);
        $this->load->view('/templates/footer',$data);
    }

    public function autosync() {
        if ( $this->session->nws_login != TRUE ) {
            redirect("Login/index");
        }

        $users_list             = $this->users_model->returnOnlyUsernames();
        //$data['debug'][] = "";
        $this->SF->prn("---------------------- Get users to check:".count($users_list)." ----------------------");
        
        $this->SF->prn("---------------------- Vaildate users and generate the correct api request list ----------------------");
        $filtered_list          = $this->filter_users_list($users_list);
        $this->SF->prn("---------------------- List for Api requests ready ----------------------");
        //$this->SF->prn($filtered_list);
        $this->SF->prn("---------------------- request all API data what is nessesery ----------------------");
        $api_request            = $this->RAH->getRecentBySummonerId($filtered_list);
        $this->SF->prn("---------------------- processing API data ----------------------");
        $final_filter_and_store = $this->filter_and_store($api_request);
        $this->SF->prn("---------------------- FINAL UPDATE TABLE ----------------------");
        $this->SF->prn($this->updated_rows_c);
        
    }

    private function filter_and_store($api_request) {

        

        if ( is_array($api_request) ) {
            
            
            $api_total = count($api_request);
            $counter = 0;
           
           
            foreach ($api_request as $value) {
                $counter++;
                $breakdown = $this->breakdown_to_sub_value($value);
                
                 $this->SF->prn("api request: $counter / $api_total ");
            }
            $this->SF->prn($breakdown);
            return $this->updated_rows;
        }
    }

    private function breakdown_to_sub_value($api_request_sub) {

        foreach ($api_request_sub as $value) {

            $summonerId                   = $value["summonerId"];
            $games                        = $value["games"];
            //$this->SF->prn($games);
            $returned_data = $this->breakdown_to_games($games,$summonerId);
        }
        return $returned_data;
    }

    private function breakdown_to_games($games,$summonerId) {

        $counter = 0;

        
        //$this->SF->prn($updated_rows);

        foreach ($games as $game_value) {
            $final_data = array();

            /// filter out all not ARAM games:   
            if ( $game_value["gameMode"] == "ARAM" &&
                      $game_value["gameType"] == "MATCHED_GAME" ) {
                
                //$this->SF->prn("this GAme is ARAM....");
                //$this->SF->prn($game_value);
                
                $game_is_stored = $this->aram_model->checkDatabasesForThisGameId($game_value["gameId"], $summonerId);
                //die($game_is_stored);
                //$this->SF->prn("is the game stored?");
                //$this->SF->prn($game_is_stored);
//                $game_is_stored = FALSE;
//
                if ( !$game_is_stored) {
                    $stats                       = $game_value['stats'];
                    $champNfo                    = $this->RAH->getChampNfoByID($game_value["championId"]);
                    $fellowPlayers               = $game_value['fellowPlayers'];
                    $final_data[]                = array(
                        'summonerID'         => $summonerId,
                        'summonersTeam'      => $game_value['teamId'],
                        'gameID'             => $game_value["gameId"],
                        'gameMode'           => $game_value["gameMode"],
                        'gameIsWin'          => $game_value['stats']["win"],
                        'ipEarned'           => $game_value['ipEarned'],
                        'totalDamage'        => $game_value['stats']['totalDamageDealtToChampions'],
                        'totalDamageTaken'   => $game_value['stats']['totalDamageTaken'],
                        'champion'           => $game_value['championId'],
                        'gameDate'           => $game_value['createDate'],
                        'statsArray'         => json_encode($stats),
                        'fellowPlayersArray' => json_encode($fellowPlayers),
                        'championArray'      => json_encode($champNfo)
                    );
                    $counter++;
                    $this->updated_rows_c++;
                    $final_data = $final_data[0];
                     
                     $this->aram_model->store_final_data_row($final_data);
                     
                     if( $this->SW_show_updated){$this->SF->prn("New game to store:" . $game_value["gameId"] . " / ");}
                     
                }else{ if($this->SW_show_stored_aram_game ) { $this->SF->prn("this game alreay stored:" . $game_value["gameId"] . " / ");}}
                    
//                    if ( $this->SW_show_updated ) {
//                        $this->SF->prn("Final_data / ROW");
//                        $this->SF->prn($final_data);
//                    }
//                    $data_cerrier["updated_rows"] = $data_cerrier["updated_rows"] ++;
//                    $this->aram_model->store_final_data_row($final_data[0]);
//                } elseif ( $this->SW_show_stored_aram_game ) { $this->SF->prn("this game alreay stored:" . $game_value["gameId"] . " / ");}
//            } elseif 
}else { if (  $this->SW_show_not_aram_game  ){ $this->SF->prn("this game is not ARAM:" . $game_value["gameId"] . " / ");  }}
            
        }
        
        return;
    }

    private function filter_users_list($users_list) {
        /// this fn gona do an array re order to get a list what i need
        
        $stat_total = count($users_list);
        $counter = 0;

        if ( $this->SW_show_user_process ) {
            $this->SF->prn("Processing_userlist:");
            $this->SF->prn($users_list);
        }
        $recentGameForUsers = array();
        foreach ($users_list as $row) {
            $summonerName   = $row->username;
            $summonerServer = $row->server;

            //$this->CI->AC->$defLocation = $summonerServer;
            
            

            $search = array(" ");
            $replace = array("");
            $summ_sm      = str_replace($search, $replace,strtolower($summonerName));
            //$this->SF->prn($summ_sm);
            $summonerData = $this->RAH->getSummonerIdBySummonerName($summ_sm,$row->server);
            $counter++;
            if ( $summonerData != FALSE && !isset($summonerData["status"]) ) {
                
                //$this->SF->prn($summonerData);
                if ( $this->SW_show_user_list ) {
                    $this->SF->prn("processing: $counter / $stat_total");
                }
                $key                                = $summonerData[$summ_sm]["id"];
                $recentGameForUsers[$key]["name"]   = "$summonerName";
                $recentGameForUsers[$key]["server"] = "$summonerServer";
            } elseif ( $this->SW_show_user_error ) {
                //$debug_data["not_pushed"] = $summonerName;
                $this->SF->prn("error with user: - $summonerName -");
            }
        }
        if ( $this->SW_show_user_processed_list ) {
            $this->SF->prn("userlist finished.");
        }
        return $recentGameForUsers;
    }



}
