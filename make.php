<?php
require 'Ranks.php';

$roster = require 'roster.php';

$config = require 'config.php';
$ranks = new Ranks($roster, $config);
$data = $ranks->get_top(null, 'grandmaster');

$output = '';
?>

<?php ob_start();?>
<table border="0" class="minitext">
    <?php foreach ($data as $player_data): if ($player_data['1x1ladder']['points'] !== null): ?>
        <?php 
            $player = $player_data['out'];
            include 'template.php';
        ?>
    <?php endif; endforeach; ?>
</table>
<?php $output = ob_get_clean(); ?>

<?php 
    //echo $output;
    $fh = fopen($config['output']['file'], 'w');
    fwrite($fh, $output);
    fclose($fh);
?>
