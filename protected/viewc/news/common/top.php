<?php
$isEnabledContentparent = MainHelper::IsModuleEnabledByTag('contentparent');
$isEnabledContentchild = MainHelper::IsModuleEnabledByTag('contentchild');
if(MainHelper::IsModuleNotAvailableByTag('contentparent') == 1) { $isEnabledContentparent = 0; };
if(MainHelper::IsModuleNotAvailableByTag('contentchild') == 1) { $isEnabledContentchild = 0; };

echo !isset($hideAdd) ? $this->renderBlock('common/header_ads', array()) : '';

if(isset($infoBox)) { echo $infoBox; };

/*
  <!-- header -->
  <div class="header news_header clearfix">
  <a href="<?php echo MainHelper::site_url('news');?>" class="fl"><?php echo $this->__('News');?></a>
  </div>
 */

if(isset($NewsCategoriesType)): ?>
    <ul class="horizontal_tabs clearfix">
        <li class="<?php echo $NewsCategoriesType == NEWS_RECENT ? 'active' : ''; ?>">
            <a class="icon_link" href="<?php echo MainHelper::site_url('news'); ?>"><i class="recent_tab_icon"></i><?php echo $this->__('Recent'); ?></a>
        </li>
        <?php /*
        <li class="<?php echo $NewsCategoriesType == NEWS_POPULAR ? 'active' : ''; ?>">
            <a class="icon_link" href="<?php echo MainHelper::site_url('news/popular'); ?>"><i class="popular_tab_icon"></i><?php echo $this->__('Popular'); ?></a>
        </li>
        */ ?> 
        <li class="<?php echo $NewsCategoriesType == NEWS_PLATFORM ? 'active' : ''; ?>">
            <a class="icon_link" href="<?php echo MainHelper::site_url('news/platforms'); ?>"><i class="platform_tab_icon"></i><?php echo $this->__('Platforms'); ?></a>
        </li>
        <?php if ($isEnabledContentchild == 1): ?>
            <li class="<?php echo $NewsCategoriesType == NEWS_GAMES ? 'active' : ''; ?>">
                <a class="icon_link" href="<?php echo MainHelper::site_url('news/games'); ?>"><i class="games_tab_icon"></i><?php echo $this->__('Games'); ?></a>
            </li>
        <?php endif; ?>
        <?php /*
          <?php if ($isEnabledContentparent==1): ?>
          <li class="<?php echo $NewsCategoriesType == NEWS_COMPANIES ? 'active':'';?>">
          <a class="icon_link" href="<?php echo MainHelper::site_url('news/companies');?>"><i class="company_tab_icon"></i><?php echo $this->__('Companies');?></a>
          </li>
          <?php endif; ?>
         */ ?>

        <!--	
        <li class="<?php echo $NewsCategoriesType == NEWS_LOCAL ? 'active' : ''; ?>">
                <a href="<?php echo MainHelper::site_url('news/local'); ?>"><?php echo $this->__('Local'); ?></a>
        </li> 
        -->
    </ul>
<?php endif; ?>
<div id="news_category_container">
    <?php if(isset($showNewsCategories) && $showNewsCategories == TRUE): ?>
        <?php //echo $this->renderBlock('news/category/'.$NewsCategoriesType, array('newsCategories' => $newsCategories, 'NewsCategoriesType' => $NewsCategoriesType));?>
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
  <?php endif; */ ?>
