<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RiotSync
 *
 * @author mrgab
 */
class RiotSync extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if ( $this->session->nws_login != TRUE ) {
            redirect("Login/index");
        }
        $this->load->model('aram_model');
        $this->load->model('users_model');
    }

    public function index() {

        $data['title'] = "sadas";

        $tmp_Data = $this->getUsersList();
        //$this->SF->prh($tmp_Data);
        
        
                    $data['title']                 = "RiotSync App";

            $this->load->view('/templates/header',$data);

            $this->load->view('/templates/start_content',$data);
            $this->load->view('/templates/normal_navbar',$data);

            ///CONTENT
            $this->load->view('/sync/index',$data);

            $this->load->view('/templates/stop_content',$data);
            $this->load->view('/templates/footer',$data);
        
        
    }

    private function getUsersList() {                                            //generate an array list with all the database users
        $final_data                             = array();
        $debug_data                             = array();
        $debug_data["afflicetd_rows_to_insert"] = 0;

        // 1. get registred users

        $users_list = $this->users_model->returnOnlyUsernames();

        //$this->SF->prh($users_list);

        /// re order array
        $recentGameForUsers = array();
        foreach ($users_list as $row) {
            $summonerName   = $row->username;
            $summonerServer = $row->server;

            //$this->CI->AC->$defLocation = $summonerServer;

            $summ_sm      = strtolower($summonerName);
            $summonerData = $this->RAH->getSummonerIdBySummonerName($row->username,$row->server);

            if ( !isset($summonerData["status"]) ) {

                $key = $summonerData[$summ_sm]["id"];

                $recentGameForUsers[$key] = $summonerServer;
            }
        }



        // 2. from the registrated and valid users -> get all recent game
        $api_request = $this->RAH->getRecentBySummonerId($recentGameForUsers);
        
            foreach ($api_request as $api_tkey => $api_row) {
                
                //$this->SF->prh($api_tkey);
                 //$this->SF->prh($api_row);
                 
                 if ( !isset($api_row["status"]["status_code"]) ) {



                $thisSummonerId = $api_row["summonerId"];

                $games = $api_row["games"];
                //$tmp = $games[3];
                foreach ($games as $key => $value) {
                    if ( $value["gameMode"] == "ARAM" && $value["gameType"] == "MATCHED_GAME" && $this->aram_model->checkDatabasesForThisGameId($value["gameId"]) == FALSE ) {

                        $debug_data["afflicetd_rows_to_insert"] ++;

                        $stats         = $value['stats'];
                        $champNfo      = $this->RAH->getChampNfoByID($value["championId"]);
                        $fellowPlayers = $value['fellowPlayers'];

                        $final_data[] = array(
                            'summonerID'         => $thisSummonerId,
                            'summonersTeam'      => $value['teamId'],
                            'gameID'             => $value["gameId"],
                            'gameMode'           => $value["gameMode"],
                            'gameIsWin'          => $value['stats']["win"],
                            'ipEarned'           => $value['ipEarned'],
                            'totalDamage'        => $value['stats']['totalDamageDealtToChampions'],
                            'totalDamageTaken'   => $value['stats']['totalDamageTaken'],
                            'champion'           => $value['championId'],
                            'gameDate'           => $value['createDate'],
                            'statsArray'         => json_encode($stats),
                            'fellowPlayersArray' => json_encode($fellowPlayers),
                            'championArray'      => json_encode($champNfo)
                        );
                    }
                }
                
                 }
            }
   


        // 3 insert to database all missing inforamtion
        $this->aram_model->syncDatabaseWithRecentByList($final_data);
        /// Loop back->return
        $data = array( "tmp" => $final_data );
        //$this->SF->prh($final_data);
        return $data;
    }

    public function updateDatabaseForAllUsers() {
        
    }

}
