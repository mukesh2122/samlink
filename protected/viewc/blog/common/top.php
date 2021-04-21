<?php echo !isset($hideAdd) ? $this->renderBlock('common/header_ads', array()) : '';?>

<?php if(isset($infoBox)):?>
    <?php echo $infoBox;?>
<?php endif; ?>

<?php /*
<!-- header -->
<div class="header news_header clearfix">
    <a href="<?php echo MainHelper::site_url('news');?>" class="fl"><?php echo $this->__('News');?></a>
</div>
*/ ?>

<?php if(isset($BlogCategoriesType)):?>
<ul class="horizontal_tabs clearfix">
	<li class="<?php echo $BlogCategoriesType == NEWS_ALL ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url('blog/all-news');?>"><i class="recent_tab_icon"></i><?php echo $this->__('All');?></a>
	</li>
	<li class="<?php echo $BlogCategoriesType == NEWS_BLOGGERS ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url('blog/bloggers');?>"><i class="platform_tab_icon"></i><?php echo $this->__('Bloggers');?></a>
	</li>

	<!--	
	<li class="<?php echo $BlogCategoriesType == NEWS_LOCAL ? 'active':'';?>">
		<a href="<?php echo MainHelper::site_url('news/local');?>"><?php echo $this->__('Local');?></a>
	</li> 
	-->
</ul>
<?php endif;?>

<div id="news_category_container">
<?php if(isset($showNewsCategories) and $showNewsCategories == TRUE):?>
    <?php //echo $this->renderBlock('news/category/'.$BlogCategoriesType, array('newsCategories' => $newsCategories, 'NewsCategoriesType' => $BlogCategoriesType));?>
<?php endif; ?>

</div>
<!-- end header -->

<?php /* if(isset($crumb)):?>
    <div class="clearfix">
        <?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb));?>
        
        <?php 
            if(isset($searchText)) {
                echo $this->renderBlock('news/common/search_block', array('searchText' => $searchText));
            } else {
                echo $this->renderBlock('news/common/search_block', array());
            }
            
        ?>
    </div>
<div class="clear">&nbsp;</div>
<?php endif; */?>
