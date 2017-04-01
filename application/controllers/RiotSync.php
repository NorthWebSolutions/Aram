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

    private $SW_show_not_aram_game    = true;
    private $SW_show_stored_aram_game = true;
    private $SW_show_prh              = false;

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
        $sync          = $this->autosync();
        //$this->load->view('/sync/index',$data);
        $this->load->view('/templates/stop_content',$data);
        $this->load->view('/templates/footer',$data);
    }

    public function autosync() {


        $users_list             = $this->users_model->returnOnlyUsernames();
        //$data['debug'][] = "";
        $this->SF->prh("wait, returning users list...");
        //$this->SF->prh($users_list);
        $this->SF->prh("filtering list...");
        $filtered_list          = $this->filter_users_list($users_list);
        $this->SF->prh("List filtered:");
        $this->SF->prh($filtered_list);
        $this->SF->prh("-----------  Api request --------------");
        $api_request            = $this->RAH->getRecentBySummonerId($filtered_list);
        $this->SF->prh("processing API data...");
        $final_filter_and_store = $this->filter_and_store($api_request);
        //$this->SF->prh($api_request);
        //return $data;
    }

    private function filter_and_store($api_request) {

        $data_container = array();

        if ( is_array($api_request) ) {
            foreach ($api_request as $value) {

                $breakdown = $this->breakdown_to_sub_value($value);

                //$this->SF->prh("---------------FINAL UPDATER TABLE-------------");
                //$this->SF->prh($value);
            }
        }
    }

    private function breakdown_to_sub_value($api_request_sub) {

        foreach ($api_request_sub as $value) {

            $summonerId              = $value["summonerId"];
            $games                   = $value["games"];
            //$this->SF->prh($games);
            $aram_games[$summonerId] = $this->breakdown_to_games($games,$summonerId);
            //$this->SF->prh($aram_games);
        }


        //// summonerID bases games to update:
    }

    private function breakdown_to_games($games,$summonerId) {

        $data_cerrier = array();

        foreach ($games as $game_value) {
            $final_data = array();

            /// filter out all not ARAM games:   
            if ( $game_value["gameMode"] == "ARAM" &&
                      $game_value["gameType"] == "MATCHED_GAME" ) {

                if ( $this->aram_model->checkDatabasesForThisGameId($game_value["gameId"]) == FALSE ) {

                    ///this is a possible match  [gameId] => 1545368932
                    $data_cerrier["vaild_games"] = $game_value["gameId"];


                    //$this->SF->prh($game_value);

                    $stats         = $game_value['stats'];
                    $champNfo      = $this->RAH->getChampNfoByID($game_value["championId"]);
                    $fellowPlayers = $game_value['fellowPlayers'];

                    $final_data[] = array(
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

                    $this->SF->prh("Final_data / ROW");
                    $this->SF->prh($final_data);
                    $this->aram_model->store_final_data_row($final_data[0]);
                } elseif( $this->SW_show_stored_aram_game) {
                    $this->SF->prh("this game alreay stored:" . $game_value["gameId"] . " / ");
                }
            } elseif ( $this->SW_show_not_aram_game) {



                $this->SF->prh("this game is not ARAM:" . $game_value["gameId"] . " / ");
            }

            return $data_cerrier;
        }
    }

    private function filter_users_list($users_list) {
        /// this fn gona do an array re order to get a list what i need
        //$this->SF->prh($users_list);
        $recentGameForUsers = array();
        foreach ($users_list as $row) {
            $summonerName   = $row->username;
            $summonerServer = $row->server;

            //$this->CI->AC->$defLocation = $summonerServer;

            $summ_sm      = strtolower($summonerName);
            $summonerData = $this->RAH->getSummonerIdBySummonerName($summ_sm,$row->server);
            $this->SF->prh($summonerData);
            if ( $summonerData != FALSE && !isset($summonerData["status"]) ) {
                //$this->SF->prh($summonerData);
                $key                                = $summonerData[$summ_sm]["id"];
                $recentGameForUsers[$key]["name"]   = "$summonerName";
                $recentGameForUsers[$key]["server"] = "$summonerServer";
            } else {
                //$debug_data["not_pushed"] = $summonerName;
                //$this->SF->prh($debug_data);
            }
        }
        return $recentGameForUsers;
    }

    private function getUsersList() {                                            //generate an array list with all the database users
//        $final_data                             = array();
//        $debug_data                             = array();
//        $debug_data["afflicetd_rows_to_insert"] = 0;
//
//        // 1. get registred users
//
//        $users_list = $this->users_model->returnOnlyUsernames();
//
//        //$this->SF->prh($users_list);
//        /// re order array
//        $recentGameForUsers = array();
//            if ( isset($summonerData["status"])  ) {
//
//                $key = $summonerData[$summ_sm]["id"];
//
//                $recentGameForUsers[$key] = $summonerServer;
//            }
//$this->SF->prh("-dfdsfsd- ");
//$this->SF->prh($recentGameForUsers);
//            // 2. from the registrated and valid users -> get all recent game
//            $api_request = $this->RAH->getRecentBySummonerId($recentGameForUsers);
//            //$this->SF->prh($api_request);
//
//            foreach ($api_request as $api_tkey => $api_row) {
//
//                //$this->SF->prh($api_row);
//
//
//                if ( !isset($api_row["status"]) ) {
//                    //$this->SF->prh("status MSG not exist");
//
//                    $thisSummonerId = $api_row["summonerId"];
//                    $games = $api_row["games"];
//                     //$this->SF->prh( $api_row["games"]);
//                  
//
//                    foreach ($games as $key => $value) {
//                        
//                       
//
//                        if ( $value["gameMode"] == "ARAM" && $value["gameType"] == "MATCHED_GAME" && $this->aram_model->checkDatabasesForThisGameId($value["gameId"]) == FALSE ) {
//
//                            $debug_data["afflicetd_rows_to_insert"] ++;
//                            $this->SF->prh("sinc_push");
//
//                            $stats         = $value['stats'];
//                            $champNfo      = $this->RAH->getChampNfoByID($value["championId"]);
//                            $fellowPlayers = $value['fellowPlayers'];
//
//                            $final_data[] = array(
//                                'summonerID'         => $thisSummonerId,
//                                'summonersTeam'      => $value['teamId'],
//                                'gameID'             => $value["gameId"],
//                                'gameMode'           => $value["gameMode"],
//                                'gameIsWin'          => $value['stats']["win"],
//                                'ipEarned'           => $value['ipEarned'],
//                                'totalDamage'        => $value['stats']['totalDamageDealtToChampions'],
//                                'totalDamageTaken'   => $value['stats']['totalDamageTaken'],
//                                'champion'           => $value['championId'],
//                                'gameDate'           => $value['createDate'],
//                                'statsArray'         => json_encode($stats),
//                                'fellowPlayersArray' => json_encode($fellowPlayers),
//                                'championArray'      => json_encode($champNfo)
//                            );
//                           //$this->SF->prh($final_data);
//                        } 
//                        else {
//                            $debug = array(
//                                "database:" => $this->aram_model->checkDatabasesForThisGameId($value["gameId"]),
//                                "mode:"     => $value["gameMode"],
//                                "type:"     => $value["gameType"]
//                            );
//                            //$this->SF->prh($debug);
//                        }
//                    }
//                }
//            }
        //}
        //$this->SF->prh($final_data);
        // 3 insert to database all missing inforamtion
        //$this->aram_model->syncDatabaseWithRecentByList($final_data);
        /// Loop back->return
        $data = array( "tmp" => $final_data );
        //$this->SF->prh($final_data);
        return $data;
    }

}
