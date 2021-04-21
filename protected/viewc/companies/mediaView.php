<?php
$isAdmin = FALSE;
if(User::canAccess("Edit company")){
    $isAdmin = true;
    $additional_header = '<a class="add_download fft fs12 db fr mt5 sprite" rel="iframe" href="'.$company->COMPANY_URL.'/admin/addmedia">'.$this->__('Add Media').'</a>';
}
include('common/top.php');
?>

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1>Media</h1></div>
</div>

<?php if(!empty($tabs)):?>
    <ul class="mediaTab">
    <?php $num = 0;?>
    <?php foreach ($tabs as $url=>$tab):?>
        <li><a <?php echo ($url == $activeTab) ? 'class="active"' : '';?> href="<?php echo $company->COMPANY_URL.'/media/'.$url;?>">
            <span><?php echo $tab;?></span></a></li>
    <?php $num++; endforeach;?>
    </ul>
<?php else: ?>

<div class="noItemsText"><?php echo $this->__('There are no media here. Yet!'); ?></div>
<?php endif;?>

<div class="mediaBody">
    <div class="mediaContent"><?php echo isset($media) ? $media : '';?></div>        
</div>
<script type="text/javascript">loadFancybox();</script>