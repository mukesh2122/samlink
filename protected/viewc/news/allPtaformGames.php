<?php 
include('common/top.php');
$letters = 'ABCDEFGHIJKLMNOPRSTUVWXYZ';
?>

<div class="alphabet mt20">
    <span class="clearfix">
        <p class="fl">
            <?php for($i = 0, $iEnd = strlen($letters); $i < $iEnd; ++$i): ?>
                <a href="<?php echo $platform->URL, '/', $letters[$i]; ?>" <?php echo $activeLetter == $letters[$i] ? 'class="active"' : ''; ?>><?php echo $letters[$i]; ?></a>
            <?php endfor; ?>
        </p>
        <p class="fr">
            <?php for($i = 0; $i < 10; ++$i): ?>
                <a href="<?php echo $platform->URL, '/', $i; ?>" <?php echo $activeLetter == "$i" ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        </p>
    </span>
</div>
<div class="clear">&nbsp;</div>
<div class="letter_header mt5 clearfix">
    <span class="db fl"><?php echo $activeLetter; ?></span>
</div>

<?php if(!empty($games)): ?>
    <div class="games_list_cont clearfix">
        <?php 
            $half = round(count($games) / 2, 0);
            $subinc = 0;
            $equal = count($games) % 2 == 0;
            $gamecount = count($games);
        ?>
        <div class="grid_4 alpha omega">
            <?php foreach($games as $game):
                if($subinc == $half): ?>
                    </div><div class="grid_4 alpha omega">
                <?php endif; ?>
                <div class="<?php echo (($subinc + 1) > $half) ? 'pl5' : 'pr5'; ?>">
                    <div class="<?php echo ((($subinc + 1) == $half) || (($equal == $gamecount) && ($subinc + 1 == $gamecount))) ? '':'dot_bot'; ?>">
                        <a href="<?php echo $game->getPURL($platform); ?>" class="db gamelist">
                            <?php echo $game->GameName; ?>
                            <span class="fclg fr fft">(<?php echo $game->NewsCount; ?>)</span>
                        </a>
                    </div>
                </div>
            <?php $subinc++;
            endforeach; ?>
        </div>
    </div>
<?php endif; ?>