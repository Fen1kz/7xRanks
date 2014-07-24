<?php
require 'Ranks.php';

$data = [
    'kain' => 'http://eu.battle.net/sc2/en/profile/795736/2/SCBlKain/',
    'http://eu.battle.net/sc2/en/profile/795736/2/SCBlKain/',
    'http://eu.battle.net/sc2/en/profile/795736/2/SCBlKain/',
    'shit' => 'http://eu.battle.net/sc2/en/profile/3093999/1/nowhere/',
    'fen1kz' => 'http://eu.battle.net/sc2/en/profile/579306/1/Fenlkz/',
    'finw' => 'http://eu.battle.net/sc2/en/profile/3093999/1/Finw%C3%AB/',
    'nowahrwa' => 'http://eu.battle.net/sc2/en/profile/3093999/1/nowhere/',
    'http://eu.battle.net/sc2/en/profile/2216267/1/Purce/',
    'http://eu.battle.net/sc2/en/profile/1667344/1/Vivien/',
    'http://eu.battle.net/sc2/en/profile/3375049/1/ninoBaby/',
    'http://eu.battle.net/sc2/en/profile/451862/1/MaksL/',
    'http://eu.battle.net/sc2/en/profile/3093999/1/Finw%C3%AB/',
    'http://eu.battle.net/sc2/en/profile/1384191/1/NoEmotion/',
    ];

$config = include 'config.php';
$ranks = new Ranks($data, $config);
$data = $ranks->get_top(4);
foreach ($data as $player) {
    echo $player['nickname'] . ': ' . $player['1x1ladder']['points'] . '<br>';
}
?>