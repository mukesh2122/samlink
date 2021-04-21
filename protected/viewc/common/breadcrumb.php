<?php /* $user = User::getUser(); ?>
<?php include('forum/common/tabs.php'); */ ?>

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1>Forum</h1></div>
</div>

<?php if(!empty($crumb)):?>
    <div class="forumBreadcrumb">
        <?php foreach ($crumb as $c):?>
            <?php if(!$c->Url):?>
                <?php echo $c->Title;?>
            <?php else:?>
                <a href="<?php echo $c->Url;?>"><?php echo $c->Title;?></a> >  
            <?php endif;?>
        <?php endforeach;?>
    </div>
<?php endif; 
 
        /* echo $this->renderBlock('forum/common/search', array(
                'url' => ($type == 'company') ? MainHelper::site_url('forum/company/search') : MainHelper::site_url('forum/game/search'), 
                'searchText' => isset($searchText) ? $searchText : '',
                'searchTotal' => isset($searchTotal) ? $searchTotal : '',
                'label' => $label = $this->__('Search for forums...'),
                'type' => $type = $this->__('forums')
    ));	*/
?>
