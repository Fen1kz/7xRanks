<?php

return array(
    'host'             => 'eu.battle.net',
    'matchMakingQueue' => 'HOTS_SOLO',
    'output' => array(
        'file'   => '7x_roster.html',
        'top'    => null,
        'league' => 'master',
        'allow0pts' => false,
        ),
    'images' => array(
        'races_images_url' => 'http://starcraft.7x.ru/img/',
        'races' => array(
            'zerg'    => 'zerg9x14.png',
            'protoss' => 'protoss9x14.png',
            'terran'  => 'terran9x14.png',
            'random'  => 'random.png',
        ),
        'leagues_images_url' => 'http://starcraft.7x.ru/img/',
        'leagues' => array(
            'grandmaster' => array(
                'top16' => 'grandmaster-top8-15x15-t.png',
                'default' => 'grandmaster-15x15-t.png',
            ),
            'master' => array(
                'top8' => 'master-top8-15x15-t.png',
                'default' => 'master-15x15-t.png',
            ),
        ),
    )
);