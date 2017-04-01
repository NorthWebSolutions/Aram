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
    private $SW_show_stored_aram_game    = true;
    private $SW_show_user_list           = true;
    private $SW_show_user_error          = true;
    private $SW_show_user_process        = false;
    private $SW_show_user_processed_list = true;
    private $SW_show_updated             = true;

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
        $this->SF->prh("---------------------- Get users to check ----------------------");
        //$this->SF->prh($users_list);
        $this->SF->prh("---------------------- Vaildate users and generate the correct api request list ----------------------");
        $filtered_list          = $this->filter_users_list($users_list);
        $this->SF->prh("---------------------- List for Api requests ready ----------------------");
        //$this->SF->prh($filtered_list);
        $this->SF->prh("---------------------- request all API data what is nessesery ----------------------");
        $api_request            = $this->RAH->getRecentBySummonerId($filtered_list);
        $this->SF->prh("---------------------- processing API data ----------------------");
        $final_filter_and_store = $this->filter_and_store($api_request);
        $this->SF->prh("---------------------- FINAL UPDATE TABLE ----------------------");
        $this->SF->prh($final_filter_and_store);
    }

    private function filter_and_store($api_request) {

        

        if ( is_array($api_request) ) {
            
            
            $api_total = count($api_request);
            $counter = 0;
           
           
            foreach ($api_request as $value) {
                $counter++;
                $breakdown = $this->breakdown_to_sub_value($value);
                
                 $this->SF->prh("api request: $counter / $api_total ");
            }
            return $breakdown;
        }
    }

    private function breakdown_to_sub_value($api_request_sub) {

        foreach ($api_request_sub as $value) {

            $summonerId                   = $value["summonerId"];
            $games                        = $value["games"];
            //$this->SF->prh($games);
            $returned_data["$summonerId"] = $this->breakdown_to_games($games,$summonerId);
        }
        return $returned_data;
    }

    private function breakdown_to_games($games,$summonerId) {

        $data_cerrier                 = array();
        $data_cerrier["updated_rows"] = 0;

        foreach ($games as $game_value) {
            $final_data = array();

            /// filter out all not ARAM games:   
            if ( $game_value["gameMode"] == "ARAM" &&
                      $game_value["gameType"] == "MATCHED_GAME" ) {
                
                $game_is_stored = $this->aram_model->checkDatabasesForThisGameId($game_value["gameId"]);

                if ( $game_is_stored == FALSE) {

                    ///this is a possible match  [gameId] => 1545368932
                    $data_cerrier["vaild_games"] = $game_value["gameId"];
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
                    if ( $this->SW_show_updated ) {
                        $this->SF->prh("Final_data / ROW");
                        $this->SF->prh($final_data);
                    }
                    $data_cerrier["updated_rows"] = $data_cerrier["updated_rows"] ++;
                    $this->aram_model->store_final_data_row($final_data[0]);
                } elseif ( $this->SW_show_stored_aram_game ) { $this->SF->prh("this game alreay stored:" . $game_value["gameId"] . " / ");}
            } elseif ( $this->SW_show_not_aram_game ) { $this->SF->prh("this game is not ARAM:" . $game_value["gameId"] . " / ");  }

            return $data_cerrier;
        }
    }

    private function filter_users_list($users_list) {
        /// this fn gona do an array re order to get a list what i need
        
        $stat_total = count($users_list);
        $counter = 0;

        if ( $this->SW_show_user_process ) {
            $this->SF->prh("Processing_userlist:");
            $this->SF->prh($users_list);
        }
        $recentGameForUsers = array();
        foreach ($users_list as $row) {
            $summonerName   = $row->username;
            $summonerServer = $row->server;

            //$this->CI->AC->$defLocation = $summonerServer;
            
            

            $search = array(" ");
            $replace = array("");
            $summ_sm      = str_replace($search, $replace,strtolower($summonerName));
            //$this->SF->prh($summ_sm);
            $summonerData = $this->RAH->getSummonerIdBySummonerName($summ_sm,$row->server);
            $counter++;
            if ( $summonerData != FALSE && !isset($summonerData["status"]) ) {
                
                //$this->SF->prh($summonerData);
                if ( $this->SW_show_user_list ) {
                    $this->SF->prh("processing: $counter / $stat_total");
                }
                $key                                = $summonerData[$summ_sm]["id"];
                $recentGameForUsers[$key]["name"]   = "$summonerName";
                $recentGameForUsers[$key]["server"] = "$summonerServer";
            } elseif ( $this->SW_show_user_error ) {
                //$debug_data["not_pushed"] = $summonerName;
                $this->SF->prh("error with user: - $summonerName -");
            }
        }
        if ( $this->SW_show_user_processed_list ) {
            $this->SF->prh("userlist finished.");
        }
        return $recentGameForUsers;
    }



}
