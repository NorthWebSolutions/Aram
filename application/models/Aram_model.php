<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aram_model
 *
 * @author mrgab
 */
class Aram_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getAllAramStatForUser($summonerID) {

        $query = $this->db->get_where('aram_data_table',array( 'summonerID' => $summonerID ));

        $final_result = array();
        foreach ($query->result() as $key => $game) {

            //echo $game->summonerID;
            $final_result["$key"]["id"]               = $game->id;
            $final_result["$key"]["summonerID"]       = $game->summonerID;
            $final_result["$key"]["teamID"]           = $game->summonersTeam;
            $final_result["$key"]["gameID"]           = $game->gameID;
            $final_result["$key"]["gameMode"]         = $game->gameMode;
            $final_result["$key"]["gameIsWin"]        = $game->gameIsWin;
            $final_result["$key"]["ipEarned"]         = $game->ipEarned;
            $final_result["$key"]["totalDamage"]      = $game->totalDamage;
            $final_result["$key"]["totalDamageTaken"] = $game->totalDamageTaken;
            $final_result["$key"]["champion"]         = $game->champion;
            $final_result["$key"]["championArray"]    = json_decode($game->championArray);
            $final_result["$key"]["statsArray"]       = json_decode($game->statsArray);
            $final_result["$key"]["fellowPlayers"]    = json_decode($game->fellowPlayersArray);
            $final_result["$key"]["gameDate"]         = $game->gameDate;
        }
        return $final_result;
    }

    public function get_Champ_wins_at_aram($summonerID) {

        $query = $this->db->select('gameIsWin, champion, championArray')
                  ->where('summonerID',$summonerID)
                  ->get('aram_data_table');

        $result = $query->result();
        return $result;
    }

    public function syncDatabaseWithRecentByList($array) {

        if ( $array != FALSE ) {




            $this->db->insert_batch('aram_data_table',$array);
        }
    }

    public function checkDatabasesForThisGameId($gameId, $summonerId) {
        

        
        //$this->SF->prh($gameId);

        $query = $this->db->get_where('aram_data_table',array('summonerID' => "$summonerId", 'gameID' => "$gameId" ));
        
        //$this->SF->prh($query);
        
        $result = $query->row();
        
        //$this->SF->prh($result);


        if ( !$result ) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function store_final_data_row($final_data_row) {

        $this->db->insert('aram_data_table',$final_data_row);
    }


}
