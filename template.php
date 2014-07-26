<tr>
    <td class="minitext" style="background:url(<?php echo $player['league_image'];?>);background-repeat:no-repeat; background-position:center;"><?php echo $player['pts']; ?></td>
	<td>
        <img src="<?php echo $player['race_image'];?>" alt="<?php echo $player['race'];?>" title="<?php echo $player['race'];?>" width="9" height="14">
    </td>
	<td class="tip_trigger">
		<div class="minitext" style="width: 74px; overflow:hidden;">
            <a href="<?php echo $player['href'];?>" target="_blank" rel="nofollow"><?php echo $player['display_name'];?></a>
			<div class="tip">
	            <table>
                    <tr>			    
                        <td align="center" valign="middle">
        <img src="<?php echo $player['race_image'];?>" alt="<?php echo $player['race'];?>" title="<?php echo $player['race'];?>" width="9" height="14">
                        </td>
                        <td class="minitext">
                            <img src="http://starcraft.7x.ru/replays/images/flags/<?php echo $player['flag'];?>" width="18" height="12">
                            <b><?php echo $player['nickname']; echo $player['metka']; ?></b>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle">
                            <img src="<?php echo $player['league_image'];?>" width="15" height="15">
                        </td>
                        <td class="minitext">
                            <strong><?php echo $player['pts'];?> pts</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="minitext" align = "left">
                            <br /> 
                            <strong>Stat:</strong> <?php echo $player['wins'];?>-<?php echo $player['losses'];?><br />
                            <strong>Rate:</strong> <?php echo $player['rate'];?></td>
                    </tr>
                </table>
            </div>
        </div>
    </td>
</tr>