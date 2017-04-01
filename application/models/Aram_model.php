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

        $query = $this->db->get_where('aram_data_table', array('summonerID' => $summonerID));

        $final_result = array();
        foreach ($query->result() as $key => $game) {

            //echo $game->summonerID;
            $final_result["$key"]["id"] = $game->id;
            $final_result["$key"]["summonerID"] = $game->summonerID;
            $final_result["$key"]["teamID"] = $game->summonersTeam;
            $final_result["$key"]["gameID"] = $game->gameID;
            $final_result["$key"]["gameMode"] = $game->gameMode;
            $final_result["$key"]["gameIsWin"] = $game->gameIsWin;
            $final_result["$key"]["ipEarned"] = $game->ipEarned;
            $final_result["$key"]["totalDamage"] = $game->totalDamage;
            $final_result["$key"]["totalDamageTaken"] = $game->totalDamageTaken;
            $final_result["$key"]["champion"] = $game->champion;
            $final_result["$key"]["championArray"] = json_decode($game->championArray);
            $final_result["$key"]["statsArray"] = json_decode($game->statsArray);
            $final_result["$key"]["fellowPlayers"] = json_decode($game->fellowPlayersArray);
            $final_result["$key"]["gameDate"] = $game->gameDate;
        }
        return $final_result;
    }

    public function get_Champ_wins_at_aram($summonerID) {

        $query = $this->db->select('gameIsWin, champion, championArray')
                  ->where('summonerID', $summonerID)

                  ->get('aram_data_table');

        $result = $query->result();
        return $result;
    }

    public function syncDatabaseWithRecentByList($array) {
        
        if($array != FALSE){


        

        $this->db->insert_batch('aram_data_table', $array);
        
        }
    }

    public function checkDatabasesForThisGameId($gameId) {


        $query = $this->db->get_where('aram_data_table', array('gameID' => $gameId));

        $result = $query->row();

        if (!$result) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
public function store_final_data_row($final_data_row) {
    
     $this->db->insert('aram_data_table', $final_data_row);
    
}
    public function checkAndStore($param) {



        foreach ($param as $key => $value) {




            $gameID = $value["gameId"];
            $gameType = $value["gameMode"];
            $summonerArray = $value['summoner'];
            reset($summonerArray);
            $summonerID = key($summonerArray);

            /// check for false 
            //     if this mach is stored it will return data 
            //     IF NOT... return false

            $query_stored_data = $this->db->get_where('aram_data_table', array('summonerID' => $summonerID, 'gameID' => $gameID, 'gameMode' => $gameType));

            $result = $query_stored_data->result_array();



            if (!$result) {                                                       //// SO THE DATA not yet in the database, lets store it...
                $stats = $value['stats'];
                $champNfo = $value['championNfo'];
                $fellowPlayers = $value['fellowPlayers'];


                $insert_Data = array(
                    'summonerID' => $summonerID,
                    'summonersTeam' => $value['teamId'],
                    'gameID' => $gameID,
                    'gameMode' => $gameType,
                    'gameIsWin' => $value['stats']["win"],
                    'ipEarned' => $value['ipEarned'],
                    'totalDamage' => $value['stats']['totalDamageDealtToChampions'],
                    'totalDamageTaken' => $value['stats']['totalDamageTaken'],
                    'champion' => $value['championId'],
                    'gameDate' => $value['createDate'],
                    'statsArray' => json_encode($stats),
                    'fellowPlayersArray' => json_encode($fellowPlayers),
                    'championArray' => json_encode($champNfo)
                );

                $this->db->insert('aram_data_table', $insert_Data);




                //} else {                                                              //// Yea this row is STORED in our Database... #DOSOMETHING 
            }
        }
    }
}

/*
            [summoner] => Array
                (
                    [24214623] => Viperace
                )

            [gameId] => 1566160207
            [gameMode] => ARAM
            [mapId] => 12
            [teamId] => 200
            [championId] => 111
            [championNfo] => Array
                (
                    [id] => 111
                    [key] => Nautilus
                    [name] => Nautilus
                    [title] => the Titan of the Depths
                )

            [ipEarned] => 220
            [createDate] => 1479413265094
            [stats] => Array
                (
                    [level] => 18
                    [goldEarned] => 14481
                    [numDeaths] => 11
                    [turretsKilled] => 1
                    [minionsKilled] => 59
                    [championsKilled] => 13
                    [goldSpent] => 14005
                    [totalDamageDealt] => 73816
                    [totalDamageTaken] => 34875
                    [doubleKills] => 3
                    [killingSprees] => 4
                    [largestKillingSpree] => 4
                    [team] => 200
                    [win] => 1
                    [largestMultiKill] => 2
                    [physicalDamageDealtPlayer] => 14624
                    [magicDamageDealtPlayer] => 59192
                    [physicalDamageTaken] => 19522
                    [magicDamageTaken] => 14492
                    [timePlayed] => 1446
                    [totalHeal] => 3578
                    [totalUnitsHealed] => 1
                    [assists] => 30
                    [item0] => 3068
                    [item1] => 3143
                    [item2] => 3742
                    [item3] => 3047
                    [item4] => 3102
                    [item5] => 1057
                    [item6] => 2052
                    [magicDamageDealtToChampions] => 23229
                    [physicalDamageDealtToChampions] => 7072
                    [totalDamageDealtToChampions] => 30301
                    [trueDamageTaken] => 860
                    [totalTimeCrowdControlDealt] => 744
                    [totalDamageDealtToBuildings] => 3584
                )

        )
 *  */