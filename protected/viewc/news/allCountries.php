<?php include('common/top.php');?>
<?php
    $letters = 'ABCDEFGHIJKLMNOPRSTUVWYZ';
?>
<div class="alphabet mt20">
    <span>
        <span class="clearfix">
        <p class="fl">
            <?php for($i=0; $i < strlen($letters); $i++):?>
                <a href="<?php echo MainHelper::site_url('news/countries/all/'.$letters[$i]);?>" <?php echo $activeLetter == $letters[$i] ? 'class="active"' : '';?>><?php echo $letters[$i];?></a>
            <?php endfor;?>
        </p>
        </span>
    </span>
</div>
<div class="clear">&nbsp;</div>
<div class="letter_header mt5 clearfix">
    <span class="db fl"><?php echo $activeLetter;?></span>
</div>

<?php if(!empty($countries)):?>
    <div class="games_list_cont clearfix">
        <?php 
            $cnt = count($countries);
            $half = round($cnt / 2, 0);
            $subinc = 0;
            $equal = $cnt % 2 == 0;
        ?>
        <div class="grid_4 alpha omega">
            <?php foreach ($countries as $country):?>
                <?php if($subinc == $half):?>
                </div><div class="grid_4 alpha omega">
                <?php endif;?>
                <div class="<?php echo ($subinc+1 > $half) ? 'pl5' : 'pr5';?>">
                    <div class="<?php echo ($subinc + 1 == $half or ($equal and $subinc + 1 == $cnt)) ? '':'dot_bot';?>">
                        <a href="<?php echo $country->URL;?>" class="db gamelist">
                            <?php echo $country->Country;?>
                            <span class="fclg fr fft">(<?php echo $country->NewsCount;?>)</span>
                        </a>
                    </div>
                </div>
            <?php $subinc++; endforeach;?>
        </div>
    </div>
<?php endif;?>
