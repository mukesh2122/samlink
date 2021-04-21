<?php
if(isset($newsCategories) and !empty($newsCategories)):?>

    <div class="news_subbg_inside clearfix">
        <div class="news_cat_last clearfix">
            <?php 
                $cnt = count($newsCategories);
                $half = round($cnt / 2, 0);
                $subinc = 0;
                $equal = $cnt % 2 == 0;
            ?>
            <div class="grid_4 alpha omega left_side pr">
                <?php foreach ($newsCategories as $platform):?>
                    <?php if($subinc == $half):?>
                    </div><div class="grid_4 alpha omega right_side pr">
                    <?php endif;?>
                    <div class="<?php echo ($subinc+1 > $half) ? 'pl5' : 'pr5';?>">
                        <div class="platform_item <?php echo ($subinc + 1 == $half or ($equal and $subinc + 1 == $cnt)) ? '':'dot_bot';?>">
                            <a href="<?php echo $platform->URL;?>" rel="<?php echo $platform->ID_PLATFORM;?>" class="db gamelist">
                                <?php echo $platform->PlatformName;?>
                                <span class="fclg fr fft">(<?php echo $platform->NewsCount;?>)</span>
                            </a>
                            
                            <?php if(isset($platform->SnGames) and !empty($platform->SnGames)):?>
                                <div class="sub_<?php echo $platform->ID_PLATFORM;?> cat_sub_item pa clearfix">
                                    <div class="news_subtop">&nbsp;</div>
                                    <div class="news_subbg clearfix pb5">
                                        <div class="news_subbg_inside clearfix">
                                            <?php 
                                                $game_half = round(count($platform->SnGames) / 2, 0);
                                                $game_subinc = 0;
                                            ?>
                                            <div class="grid_4 alpha omega">
                                                <?php foreach ($platform->SnGames as $game):?>
                                                    <?php if($game_subinc == $game_half):?>
                                                    </div><div class="grid_4 alpha omega">
                                                    <?php endif;?>
                                                    <div class="pr15 pl15">
                                                        <div class="dot_bot">
                                                            <a href="<?php echo $game->getPURL($platform);?>" class="db">
                                                                <?php echo $game->GameName;?>
                                                                <span class="fclg fr fs11 fft"><?php echo $this->__('Posts');?> (<?php echo $game->NewsCount;?>)</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php $game_subinc++; endforeach;?>
                                            </div>
                                        </div>
                                        <div class="clear">&nbsp;</div>
                                        <div class="fr pr15"><a href="<?php echo $platform->URL;?>"><?php echo $this->__('Show all games');?></a></div>
                                    </div>
                                    <div class="news_subbot">&nbsp;</div>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                <?php $subinc++; endforeach;?>
            </div>
        </div>
    </div>
<?php endif;?>