<?php

class Ranks {
    private $players = array();
    private $config;
    private $debug = false;
    
    function __construct($players, $config, $debug = true) {
        $this->players = $this->init_players($players);
        $this->config = $config;
        $this->debug = $debug;
        $this->update_ranks();
        //$this->log($this->players);
    }
    
    public function get_top($top = null) {
        $result = $this->players;
        usort($result, array($this, 'get_top_sort')); // cuz of php 5.2 =\
        if ($top !== null) {
            $result = array_slice($result, 0, $top);
        }
        $result = array_filter($result, array($this, 'get_top_filter')); // cuz of php 5.2 =\
        return $result;
    }
    
    protected function get_top_sort ($player1, $player2) {
        $league1 = $this->league_to_int($player1['1x1ladder']['league']);
        $league2 = $this->league_to_int($player2['1x1ladder']['league']);
        if ($league1 != $league2) {
            return ($league1 > $league2) ? -1 : 1;
        } else {
            return ($player1['1x1ladder']['points'] > $player2['1x1ladder']['points']) ? -1 : 1;
        }
    }
    
    protected function get_top_filter ($player) {
        $league = $this->league_to_int($player['1x1ladder']['league']);
        if ($league < $this->league_to_int($this->config['output']['league']))
            return false;
        
        if (!$this->config['output']['allow0pts'] && $player['1x1ladder']['points'] == 0) {
            return false;
        }
        
        return true;
    }
    
   
    public static function league_to_int($league_name) {
        switch (strtolower($league_name)) {
            case 'bronze':      $league = 1; break;
            case 'silver':      $league = 2; break;
            case 'gold':        $league = 3; break;
            case 'platinum':    $league = 4; break;
            case 'diamond':     $league = 5; break;
            case 'master':      $league = 6; break;
            case 'grandmaster': $league = 7; break;
            default: $league = 0;        
        }
        return $league;
    }
    
    public function update_ranks() {
        $this->request_players_info();
        $this->request_ladders_info();
        $this->prepare_to_out();
    }
    
    protected function prepare_to_out() {
        foreach($this->players as &$player) {
            $player['out'] = array();
            $player['out']['nickname'] = $player['nickname'];
            $player['out']['flag'] = $player['flag'];
            $player['out']['metka'] = (($player['metka'] != '') ? '.'.$player['metka'] : '');
            
            $player['out']['pts']    = $player['1x1ladder']['points'];
            $player['out']['wins']   = $player['1x1ladder']['wins'];
            $player['out']['losses'] = $player['1x1ladder']['losses'];
            $wins = (int) $player['1x1ladder']['wins'];
            $losses = (int) $player['1x1ladder']['losses'];
            $player['out']['rate']   = number_format((($wins != 0) ? ($wins / ($wins+$losses)) * 100 : 0), 2);
            $player['out']['race']   = isset($player['1x1ladder']['favoriteRaceP1']) ? strtolower($player['1x1ladder']['favoriteRaceP1']) : '';
            $player['out']['league'] = strtolower($player['1x1ladder']['league']);
            $player['out']['race_image'] = $this->out_get_race_img_src($player['out']['race']);
            
            $player['out']['href'] = 'http://'.$this->config['host'] .'/sc2/en/'. $player['link'] .'/';
            $player['out']['display_name'] = '[7x]'. $player['name'];
            $player['out']['league_image'] = $this->out_get_league_img_src($player['out']['league'], $player['1x1ladder']['rank']);
        }
    }
    
    protected function out_get_race_img_src($race) {
        if ($race != null) {
            return $this->config['images']['races_images_url'].$this->config['images']['races'][$race];
        } else {
            return null;
        }
    }
    
    protected function out_get_league_img_src($league, $rank) {
        if ($league != null) {
            if (isset($this->config['images']['leagues'][$league])) {
                $img_src = null;
                if ($league == 'grandmaster') {
                    $img_src = $this->out_get_league_img_src_helper($league, $rank, 16, 50, 100);
                } else {
                    $img_src = $this->out_get_league_img_src_helper($league, $rank, 8, 25, 50);
                }
                return $this->config['images']['leagues_images_url'] . $img_src;
            }
        }
        return null;
    }
    
    protected function out_get_league_img_src_helper($league, $rank, $rank1, $rank2, $rank3) {
        if ($rank != 0 && $rank < $rank1 && isset($this->config['images']['leagues'][$league]['top'.$rank1])) {
            $img_src = $this->config['images']['leagues'][$league]['top'.$rank1];
        } else if ($rank != 0 && $rank < $rank2 && isset($this->config['images']['leagues'][$league]['top'.$rank2])) {
            $img_src = $this->config['images']['leagues'][$league]['top'.$rank2];
        } else if ($rank != 0 && $rank < $rank3 && isset($this->config['images']['leagues'][$league]['top'.$rank3])) {
            $img_src = $this->config['images']['leagues'][$league]['top'.$rank3];
        } else {
            $img_src = $this->config['images']['leagues'][$league]['default'];
        }
        return $img_src;
    }


    protected function request_players_info() {
        $urls = array();
        foreach($this->players as $id => $player) {
            $urls[$id] = $this->config['host'] .'/sc2/'. $player['link'] .'/ladders';
            $urls[$id] .= '?apikey=' . $this->config['api-key'];
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
        $urls = array();        
        foreach($this->players as $id => $player) {
            if ($player['1x1ladder']['ladderId'] === null) {
                continue;
            }
            $urls[$id] = $this->config['host'] .'/sc2/ladder/' . $player['1x1ladder']['ladderId'];
            $urls[$id] .= '?apikey=' . $this->config['api-key'];
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
        return array(
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
        );
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
        foreach($players as $player) {
            if (!isset($player['link'])) {
                $this->error('Player doesn\'t have link field', $player);
                continue;
            }
            $input_link = $player['link'];
            //$this->log('processing '. $input_link);
            $link_array = array();
            preg_match("/.*(profile\/\d+\/\d+\/.*)\//", $input_link, $link_array);
            if (isset($link_array[1])) {                
                $player_array = array();
                preg_match("/profile\/(\d+)\/(\d+)\/(.*)/", $link_array[1], $player_array);
                
                $return_array[] = array(
                    'name'  => (isset($player['name'])) ? $player['name'] : urldecode($player_array[3]),
                    'metka' => (isset($player['metka'])) ? $player['metka'] : '',
                    'flag'  => (isset($player['flag'])) ? $player['flag'] : '!None.gif',
                    'nickname' => urldecode($player_array[3]),
                    'link'  => $player_array[0],
                    'id'    => $player_array[1],
                    'realm' => $player_array[2],
                    );
                
                
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
        $curly = array();
        $results = array();
        
        foreach($urls as $id => $url) {
            $curly[$id] = curl_init();
            
            curl_setopt($curly[$id], CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curly[$id], CURLOPT_URL, $url);
            curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, true);
            
            curl_multi_add_handle($mh, $curly[$id]);
        }
        
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while($running > 0);
        
        foreach($curly as $id => $ch) {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                       
            $results[$id] = curl_multi_getcontent($ch);
            
            if (!$this->debug) {
                if ($httpCode != 200) {
                    $this->error("Error while getting url [$urls[$id]], response Code [$httpCode]");
                }
            } else {
                $this->log("Request for [$urls[$id]], response Code [$httpCode], \n body: [$results[$id]]");
            }
            
        
            curl_multi_remove_handle($mh, $ch);
        }
        
        curl_multi_close($mh);
        return $results;
    }
    
    protected function log () {
        $output = array();
        $args = func_get_args();
        echo '<pre>';
        foreach ($args as $arg) {
            if (is_array($arg)) {
                $output[] .= print_r($arg, true);
            } else {
                $output[] .= $arg;
            }
        }
        echo implode(', ', $output);
        echo '</pre>';
    }
    
    protected function error () {
        $output = array();
        $args = func_get_args();
        echo '<pre>';
        foreach ($args as $arg) {
            if (is_array($arg)) {
                $output[] .= print_r($arg, true);
            } else {
                $output[] .= $arg;
            }
        }
        echo implode(', ', $output);
        echo '</pre>';
    }
}
