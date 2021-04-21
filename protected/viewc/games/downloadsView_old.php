<?php 
$isAdmin = FALSE;
if($game->isAdmin()){
    $isAdmin = true;
    if(!empty($tabs)) {
        $additional_header = '<a class="add_download fft fs12 db fr mt5 sprite" rel="iframe" href="'.$game->GAME_URL.'/admin/adddownload">'.$this->__('Add Download').'</a>';
    }
}
include('common/top.php');
?>

<?php if(!empty($tabs) or $isAdmin === TRUE):?>
    <ul class="tab_navigation clearfix mt15">
    <?php $num = 0;?>
    <?php foreach ($tabs as $tab):?>
        <li class="pr">
            <a <?php echo ($tab->ID_FILETYPE == $activeTab) ? 'class="active"' : '';?> href="<?php echo $game->GAME_URL.'/downloads/'.$tab->ID_FILETYPE;?>">
                <span><span <?php echo $isAdmin === TRUE ? 'class="pr25"' : '';?>>
                    <?php echo $tab->FiletypeName;?>
                </span></span>
            </a>
            <?php if($isAdmin === TRUE):?>
                <a href="javascript:void(0)" rel="<?php echo $tab->ID_FILETYPE;?>" class="pa cal icon_close_game_tab mr5 mt5">&nbsp;</a>
            <?php endif;?>
        </li>
    <?php $num++; endforeach;?>
    <?php if($isAdmin === TRUE):?>
        <li><a class="add" rel="iframe" href="<?php echo $game->GAME_URL.'/admin/adddownloadtab';?>">&nbsp;</a></li>
        
        <?php if(!empty($tabs)):?>
            <li><a class="edit" rel="iframe" href="<?php echo $game->GAME_URL.'/admin/editdownloadtab';?>">&nbsp;</a></li>
        <?php endif;?>
    <?php endif;?>
    </ul>
<?php endif;?>

<?php if(!empty($downloads)):?>
    <?php $num = 0;?>
    <?php foreach ($downloads as $download):?>
        <div class="download_cont <?php echo !$num ? 'dot_top mt20' : '';?>">
            <div class="pt10 pb10 clearfix dot_bot pr">
                <div class="grid_1 alpha"><?php echo MainHelper::showImage($download, THUMB_LIST_60x60);?> </div>
                <div class="clearfix grid_5 alpha omega">
                    <div><a class="fs13 count_download" rel="<?php echo $download->ID_DOWNLOAD;?>" target="_blank" href="<?php echo $download->URL;?>"><?php echo $download->DownloadName;?></a></div>
                    
                    <div class="fs11 fft mt5 short_desc_<?php echo $download->ID_DOWNLOAD;?>"><strong><?php echo $this->__('Description');?></strong>: <?php echo ContentHelper::downloadShortDescription($download->DownloadDesc);?></div>
                    <div class="fs11 fft mt5 dn long_desc_<?php echo $download->ID_DOWNLOAD;?>"><strong><?php echo $this->__('Description');?></strong>: <?php echo $download->DownloadDesc;?></div>
                    <div class="clear">&nbsp;</div>
                    <?php if(strlen(ContentHelper::downloadShortDescription($download->DownloadDesc)) != strlen($download->DownloadDesc)):?>
                        <a class="fr fs11 fft readmore" name="<?php echo $this->__('Read more');?>" rev="<?php echo $this->__('Hide description');?>" rel="<?php echo $download->ID_DOWNLOAD;?>" href="javascript:void(0)"><?php echo $this->__('Read more');?></a>
                    <?php endif;?>
                </div> 
                <div class="clearfix grid_2 alpha omega fr">
                    <div class="pl30">
                        <span class="db fclg fft fs11"><strong><?php echo $this->__('Size');?></strong>: <?php echo $download->FileSize != '' ? $download->FileSize : '-';?> MB</span>
                        <span class="db fclg fft fs11"><strong><?php echo $this->__('Date');?></strong>: <?php echo Date("d/m-Y", $download->CreationTime);?></span>
                        <span class="db fclg fft fs11"><strong><?php echo $this->__('Downloads');?></strong>: <?php echo $download->DownloadCount != '' ? $download->DownloadCount : '0';?></span>
                    </div>
                    <div class="pl30 mt5">
                        <a target="_blank" href="<?php echo $download->URL;?>" class="link_download fl db count_download" rel="<?php echo $download->ID_DOWNLOAD;?>"><span><?php echo $this->__('Download');?></span></a>
                    </div>
                </div>
                <div class="clear"></div>
                <?php if($isAdmin === TRUE):?>
                    <div class="grid_1 alpha">&nbsp;</div>
                    <div class="clearfix grid_5 alpha omega">
                        <a rel="iframe" href="<?php echo $game->GAME_URL.'/admin/editdownload/'.$download->ID_DOWNLOAD;?>" class="link_icon icon_edit"><?php echo $this->__('Edit');?></a>
                        <a href="javascript:void(0)" class="link_icon icon_deletemessage delete_game_download" rel="<?php echo $download->ID_DOWNLOAD;?>"><?php echo $this->__('Delete');?></a>
                    </div>
                <?php endif;?>
            </div>
        </div>
    <?php $num++; endforeach;?>
<?php endif;?>