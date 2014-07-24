<?php

class Ranks {
    private $players = [];
    private $config;
    
    function __construct($players, $config) {
        $this->players = $this->init_players($players);
        $this->config = $config;
        $this->update_ranks();
    }
    
    public function get_top($top = 10) {
        $result = $this->players;
        usort($result, function ($player1, $player2) {
            $league1 = $this->league_to_int($player1['1x1ladder']['league']);
            $league2 = $this->league_to_int($player2['1x1ladder']['league']);
            if ($league1 != $league2) {
                return ($league1 > $league2) ? -1 : 1;
            } else {
                return ($player1['1x1ladder']['points'] > $player2['1x1ladder']['points']) ? -1 : 1;
            }
        });
        return array_slice($result, 0, $top);
    }
    
    public static function league_to_int($league_name) {
        switch ($league_name) {
            case 'BRONZE':      $league = 1; break;
            case 'SILVER':      $league = 2; break;
            case 'GOLD':        $league = 3; break;
            case 'PLATINUM':    $league = 4; break;
            case 'DIAMOND':     $league = 5; break;
            case 'MASTER':      $league = 6; break;
            case 'GRANDMASTER': $league = 7; break;
            default: $league = 0;        
        }
        return $league;
    }
    
    public function update_ranks() {
        $this->request_players_info();
        $this->request_ladders_info();
        //$this->log($this->players);
    }
    
    protected function request_players_info() {
        $urls = [];
        foreach($this->players as $id => $player) {
            $urls[$id] = $this->config['host'] .'/api/sc2/'. $player['link'] .'/ladders';
            //$this->log('requesting player ' . $urls[$id]);
        }
        
        $results = $this->multicurl($urls);
        
        foreach($results as $id => $result) {
            $json = json_decode($result, true);
            if (isset($json['currentSeason'])) {
                //$this->log('requested current season for player'. $this->players[$id]['link']);
                $this->players[$id]['1x1ladder'] = $this->get_solo_ladder($json['currentSeason']);
            } else {
                $this->error('Request failed for player "'. $this->players[$id]['link'].'"');
                unset($this->players[$id]);
            }
        }
    }
    
    
    protected function request_ladders_info() {
        $urls = [];        
        foreach($this->players as $id => $player) {
            if ($player['1x1ladder']['ladderId'] === null) {
                continue;
            }
            $urls[$id] = $this->config['host'] .'/api/sc2/ladder/' . $player['1x1ladder']['ladderId'];
            //$this->log('requesting ladder ' . $urls[$id] . ' for player ' . $player['link']);
        }
        
        $results = $this->multicurl($urls);
        
        foreach($results as $id => $result) {
            $json = json_decode($result, true);
            if (isset($json['ladderMembers'])) {
                //$this->log('requested ladder for player '. $this->players[$id]['link']);
                $ladderMembers = $json['ladderMembers'];
                $currentMember = $this->get_player_from_ladder($ladderMembers, $this->players[$id]);
                //$this->log($currentMember);
                $this->players[$id]['1x1ladder'] = array_merge($this->players[$id]['1x1ladder'], $currentMember);
            } else {
                $this->error('Request failed for ladder ' . $this->players[$id]['1x1ladder']['ladderId'] . ' for player ' . $this->players[$id]['link']);
                unset($this->players[$id]);
            }
        }
    }

    protected function get_solo_ladder ($currentSeason) {
        foreach ($currentSeason as $ladder_container) {
            foreach ($ladder_container['ladder'] as $ladder) {
                if ($ladder['matchMakingQueue'] === $this->config['matchMakingQueue'])
                    return $ladder;
            }
        }
        return [
            'ladderName' => null,
            'ladderId'   => null,
            'division'   => null,
            'rank'       => null,
            'league'     => null,
            'matchMakingQueue' => $this->config['matchMakingQueue'],
            'wins'           => null,
            'losses'         => null,
            'showcase'       => null,
            'joinTimestamp'  => null,
            'points'         => null,
            'highestRank'    => null,
            'previousRank'   => null,
            'favoriteRaceP1' => null,
        ];
    }
    
    protected function get_player_from_ladder ($ladderMembers, $player) {
        foreach($ladderMembers as &$member) {
            if ($member['character']['id'] == $player['id']
            && $member['character']['realm'] == $player['realm']) {
                unset($member['character']);
                return $member;
            }
        }
    }
    
    protected function init_players($players) {
        $return_array;
        foreach($players as $input_link) {
            //$this->log('processing '. $input_link);
            $link_array = [];
            preg_match("/.*(profile\/\d+\/\d+\/.*)\//", $input_link, $link_array);
            if (isset($link_array[1])) {                
                $player_array = [];
                preg_match("/profile\/(\d+)\/(\d+)\/(.*)/", $link_array[1], $player_array);
                
                $return_array[] = [
                    'link'  => $player_array[0],
                    'id'    => $player_array[1],
                    'realm' => $player_array[2],
                    'nickname' => urldecode($player_array[3]),
                    ];
                
                
            } else {
                $this->error('Wrong player link "'.$input_link.'"');
                continue;
            }
            //$this->log('initialized player'. $player_link);
        }
        return $return_array;
    }
    
    protected function multicurl ($urls) {
        $mh = curl_multi_init();
        $curly = [];
        $results = [];
        
        foreach($urls as $id => $url) {
            $curly[$id] = curl_init();
            
            curl_setopt($curly[$id], CURLOPT_URL, $url);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, true);
            
            curl_multi_add_handle($mh, $curly[$id]);
        }
        
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running > 0);
        
        foreach($curly as $id => $ch) {
            $results[$id] = curl_multi_getcontent($ch);
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);
        return $results;
    }
    
    protected function log ($msg) {
        echo '<pre>';
        if (is_array($msg)) {
            print_r($msg);
        } else
            echo $msg . '<br>';
        echo '</pre>';
    }
    
    protected function error ($msg) {
        echo '<pre>';
        echo $msg . '<br>';
        echo '</pre>';
    }
}
