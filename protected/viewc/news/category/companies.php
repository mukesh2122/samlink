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
            <div class="grid_4 alpha omega">
                <?php foreach ($newsCategories as $company):?>
                    <?php if($subinc == $half):?>
                    </div><div class="grid_4 alpha omega">
                    <?php endif;?>
                    <div class="<?php echo ($subinc+1 > $half) ? 'pl5' : 'pr5';?>">
                        <div class="<?php echo ($subinc + 1 == $half or ($equal and $subinc + 1 == $cnt)) ? '':'dot_bot';?>">
                            <a href="<?php echo $company->NEWS_URL;?>" class="db gamelist">
                                <?php echo $company->CompanyName;?>
                                <span class="fclg fr fft">(<?php echo $company->NewsCount;?>)</span>
                            </a>
                        </div>
                    </div>
                <?php $subinc++; endforeach;?>
            </div>
        </div>
    </div>
    <div class="fr pt5"><a class="show_all" href="<?php echo MainHelper::site_url('news/companies/all');?>"><span><span><?php echo $this->__('Show all companies');?></span></span></a></div>
    <div class="clear">&nbsp;</div>
<?php endif;?>