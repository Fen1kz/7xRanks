<?php
require 'Ranks.php';

$roster = array(
	  array('name'=>'Val',          'link'=>'http://eu.battle.net/sc2/en/profile/172689/1/Val/',            'flag'=>'Ukraine.gif', 'metka'=>'384'),
	  array('name'=>'Mengsk',       'link'=>'http://eu.battle.net/sc2/en/profile/661772/1/OutCast/',        'flag'=>'Germany.gif', 'metka'=>'953'),
	  array('name'=>'Focus',        'link'=>'http://eu.battle.net/sc2/ru/profile/472185/2/Focus/',          'flag'=>'Russia.gif',  'metka'=>'858'),
	  array('name'=>'Control',      'link'=>'http://eu.battle.net/sc2/en/profile/329792/2/control/',        'flag'=>'Russia.gif',  'metka'=>'341'),
	  array('name'=>'ZeratuL',      'link'=>'http://eu.battle.net/sc2/en/profile/1180505/2/SevenXSephi/',   'flag'=>'Russia.gif',  'metka'=>'955'),
	  array('name'=>'Kanzler',      'link'=>'http://eu.battle.net/sc2/ru/profile/1524207/1/Kanzler/',       'flag'=>'Russia.gif',  'metka'=>'870'),
	  array('name'=>'jonk',         'link'=>'http://eu.battle.net/sc2/ru/profile/667406/1/jonk/',           'flag'=>'Russia.gif',  'metka'=>'178'),
	//array('name'=>'Sephiroth',    'link'=>'http://eu.battle.net/sc2/ru/profile/758534/2/llllllllllll/',   'flag'=>'Korea.gif'),
	  array('name'=>'IGG',          'link'=>'http://eu.battle.net/sc2/en/profile/1662499/1/IGG/',           'flag'=>'Russia.gif',  'metka'=>'653'),
	  array('name'=>'Igon',         'link'=>'http://eu.battle.net/sc2/ru/profile/515000/1/SevenXIgon/',     'flag'=>'Russia.gif',  'metka'=>'103'),
	  array('name'=>'JediOne',      'link'=>'http://eu.battle.net/sc2/en/profile/1983813/1/JediOne/',       'flag'=>'Russia.gif',  'metka'=>'307'),
	//array('name'=>'T1Mmi',        'link'=>'http://eu.battle.net/sc2/en/profile/170051/1/TiMmi/',          'flag'=>'Russia.gif',  'metka'=>'736'),
	//array('name'=>'T1Mmi',        'link'=>'http://eu.battle.net/sc2/ru/profile/42332/2/StereoSolo/',      'flag'=>'Russia.gif',  'metka'=>'784'),
	  array('name'=>'Smith',        'link'=>'http://eu.battle.net/sc2/en/profile/1841462/1/smith/',         'flag'=>'Russia.gif',  'metka'=>'269'),
	  array('name'=>'inNirvana',    'link'=>'http://eu.battle.net/sc2/en/profile/235509/1/inNirvana/',      'flag'=>'Russia.gif',  'metka'=>'120'),
	  array('name'=>'High_T',       'link'=>'http://eu.battle.net/sc2/en/profile/1501543/1/NaslunD/',       'flag'=>'Russia.gif',  'metka'=>'252'),
	//array('name'=>'LuckyGnom',    'link'=>'http://eu.battle.net/sc2/en/profile/756857/1/LuckyGnom/',      'flag'=>'Russia.gif'),
	//array('name'=>'RZP',          'link'=>'http://eu.battle.net/sc2/en/profile/3553989/1/KDA/',           'flag'=>'Russia.gif',  'metka'=>'508'),
	  array('name'=>'SPPeis',       'link'=>'http://eu.battle.net/sc2/ru/profile/169253/1/Paul/',           'flag'=>'Russia.gif',  'metka'=>'1451'),
	  array('name'=>'Stigmat',      'link'=>'http://eu.battle.net/sc2/en/profile/1873099/1/IIIIIIIIIIII/',  'flag'=>'Russia.gif',  'metka'=>'999'),
	  array('name'=>'Raven_gg',     'link'=>'http://eu.battle.net/sc2/ru/profile/2189969/1/SevenXRaveng/',  'flag'=>'Russia.gif',  'metka'=>'828'),
	  array('name'=>'Focus',        'link'=>'http://eu.battle.net/sc2/ru/profile/472185/2/Focus/',          'flag'=>'Russia.gif',  'metka'=>'858'),
	  array('name'=>'SoSisKA',      'link'=>'http://eu.battle.net/sc2/en/profile/74284/2/DangerJunior/',    'flag'=>'Russia.gif',  'metka'=>'343'),
	  array('name'=>'CrazyRabbit',  'link'=>'http://eu.battle.net/sc2/en/profile/3000100/1/Abatur/',        'flag'=>'Ukraine.gif', 'metka'=>'577'),
	  array('name'=>'Deneb',        'link'=>'http://eu.battle.net/sc2/ru/profile/452240/2/Deneb/',          'flag'=>'Ukraine.gif', 'metka'=>'718'),
	  array('name'=>'Mike',         'link'=>'http://eu.battle.net/sc2/ru/profile/188911/2/Mike/',           'flag'=>'Russia.gif',  'metka'=>'2648'),
	  array('name'=>'OnGtonG',      'link'=>'http://eu.battle.net/sc2/en/profile/19718/2/Thorn/',           'flag'=>'Russia.gif',  'metka'=>'125'),
	//array('name'=>'Demolisher',   'link'=>'http://eu.battle.net/sc2/en/profile/1923477/1/Demolisher/',    'flag'=>'Russia.gif',  'metka'=>'665'),
	  array('name'=>'ma.tema',      'link'=>'http://eu.battle.net/sc2/en/profile/16106/2/matema/',          'flag'=>'Russia.gif',  'metka'=>'279'),
	  array('name'=>'Masamune',     'link'=>'http://eu.battle.net/sc2/en/profile/975063/2/Masamune/',       'flag'=>'China.gif',   'metka'=>'826'),
	  array('name'=>'ОпасныйПоцик', 'link'=>'http://eu.battle.net/sc2/en/profile/87169/2/ОпасныйПоцик/',    'flag'=>'Russia.gif',  'metka'=>'279'),
	  array('name'=>'Tsukuyomi',    'link'=>'http://eu.battle.net/sc2/en/profile/1849721/1/Tsukuyomi/',     'flag'=>'Russia.gif',  'metka'=>'946'),
	  array('name'=>'FKNL',         'link'=>'http://eu.battle.net/sc2/en/profile/1680170/1/IIIIIIIIIIIl/',  'flag'=>'Russia.gif',  'metka'=>'114'),
	  array('name'=>'KpeHgeJIb',    'link'=>'http://eu.battle.net/sc2/ru/profile/710701/2/KpeHgeJIb/',      'flag'=>'Russia.gif',),
	  array('name'=>'AvaTaR',       'link'=>'http://eu.battle.net/sc2/en/profile/1184256/2/AvaTaR/',        'flag'=>'Russia.gif',  'metka'=>'1537'),
	  array('name'=>'DarkSide',     'link'=>'http://eu.battle.net/sc2/ru/profile/798545/2/EnigmA/',         'flag'=>'Russia.gif',  'metka'=>'1306'),
	  array('name'=>'AvaTaR',       'link'=>'http://eu.battle.net/sc2/en/profile/894412/2/MrWar/',          'flag'=>'Russia.gif',  'metka'=>'1537'), //Старый акк Аватара - удалить как новый выйдет в МЛ
    );

$config = include 'config.php';
$ranks = new Ranks($roster, $config);
$data = $ranks->get_top();

$output = '';
?>
<!doctype HTML>
<meta charset="UTF-8"/>

<?php ob_start();?>
<table border="0" class="minitext">
    <?php foreach ($data as $player): if ($player['1x1ladder']['points'] !== null): ?>
    <tr>
        <td class="minitext" style="background:url(<?php echo $player['out']['league_image'];?>);background-repeat:no-repeat; background-position:center;"><?php echo $player['1x1ladder']['points']; ?></td>
		<td>
            <img src="<?php echo $player['out']['race_image'];?>" alt="<?php echo $player['out']['race'];?>" title="<?php echo $player['out']['race'];?>" width="9" height="14">
        </td>
		<td class="tip_trigger">
			<div class="minitext" style="width: 74px; overflow:hidden;">
                <a href="<?php echo $player['out']['href'];?>" target="_blank" rel="nofollow"><?php echo $player['out']['display_name'];?></a>
				<div class="tip">
		            <table>
                        <tr>			    
                            <td align="center" valign="middle">
            <img src="<?php echo $player['out']['race_image'];?>" alt="<?php echo $player['out']['race'];?>" title="<?php echo $player['out']['race'];?>" width="9" height="14">
                            </td>
                            <td class="minitext">
                                <img src="http://starcraft.7x.ru/replays/images/flags/<?php echo $player['flag'];?>" width="18" height="12">
                                <b><?php echo $player['nickname']; echo (($player['metka'] != '') ? '.'.$player['metka'] : ''); ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="middle">
                                <img src="<?php echo $player['out']['league_image'];?>" width="15" height="15">
                            </td>
                            <td class="minitext">
                                <strong><?php echo $player['out']['pts'];?> pts</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="minitext" align = "left">
                                <br /> 
                                <strong>Stat:</strong> <?php echo $player['out']['wins'];?>-<?php echo $player['out']['losses'];?><br />
                                <strong>Rate:</strong> <?php echo $player['out']['rate'];?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
	</tr>
    <?php endif; endforeach; ?>
</table>
<?php $output = ob_get_clean(); ?>

<?php 
    //echo $output;
    $fh = fopen($config['htmlOutput'], 'w');
    fwrite($fh, $output);
    fclose($fh);
?>
