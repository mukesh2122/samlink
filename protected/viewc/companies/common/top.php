<?php
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
$isEnabledForum = MainHelper::IsModuleEnabledByTag('forum');
$isEnabledEvents = MainHelper::IsModuleEnabledByTag('events');
$isEnabledContentchild = MainHelper::IsModuleEnabledByTag('contentchild');
if(MainHelper::IsModuleNotAvailableByTag('news') == 1) { $isEnabledNews = 0; };
if(MainHelper::IsModuleNotAvailableByTag('forum') == 1) { $isEnabledForum = 0; };
if(MainHelper::IsModuleNotAvailableByTag('events') == 1) { $isEnabledEvents = 0; };
if(MainHelper::IsModuleNotAvailableByTag('contentchild') == 1) { $isEnabledContentchild = 0; };
$hideAdd = FALSE;

if(isset($company)): ?>
    <input id="company_id" value="<?php echo $company->ID_COMPANY; ?>" type="hidden">
<?php endif;

echo (!isset($hideAdd)) ? $this->renderBlock('common/header_ads', array()) : '';
echo (isset($infoBox)) ? $infoBox : '';
if(isset($company) && ($company->GameCount == 0)) { $isEnabledContentchild = 0; };
$any = $isEnabledNews + $isEnabledForum + $isEnabledContentchild + $isEnabledEvents; 

    // if(isset($CategoryType) and isset($company) and $any>0):
		// $anyMedia = MainHelper::countCompanyMedias($company);
	?>
<!--Nav menu box-->
<!--    <ul class="horizontal_tabs clearfix">
            <li class="<?php // echo $CategoryType == COMPANY_INFO ? 'active':'';?>">
                <a class="icon_link" href="<?php // echo $company->COMPANY_URL;?>"><i class="info_tab_icon"></i>
                    <?php // echo $this->__('Info');?>
                </a>
            </li>
		<?php // if ($isEnabledNews == 1): ?>
            <li class="<?php // echo $CategoryType == COMPANY_NEWS ? 'active':'';?>">
                <a class="icon_link" href="<?php // echo $company->COMPANY_URL.'/news';?>"><i class="news_tab_icon"></i>
                    <?php //echo $this->__('News');?></a>
            </li>
		<?php // endif; ?>
		<?php //if ($isEnabledForum == 1): ?>
            <li class="<?php // echo $CategoryType == COMPANY_FORUM ? 'active':'';?>">
                <a class="icon_link" href="<?php // echo $company->FORUM_URL;?>"><i class="forum_tab_icon"></i>
                    <?php // echo $this->__('Forum');?></a>
            </li>
		<?php //endif; ?>
		<?php // if ($isEnabledContentchild == 1): ?>
            <li class="<?php // echo $CategoryType == COMPANY_GAMES ? 'active':'';?>">
                <a class="icon_link" href="<?php // echo $company->COMPANY_URL.'/games';?>"><i class="games_tab_icon"></i>
                    <?php // echo $this->__('Games');?></a>
            </li>
		<?php // endif; ?>
		<?php // if ($isEnabledEvents == 1): ?>
            <li class="<?php // echo $CategoryType == COMPANY_EVENTS ? 'active':'';?>">
                <a class="icon_link" href="<?php // echo $company->EVENTS_URL;?>"><i class="event_tab_icon"></i>
                    <?php // echo $this->__('Events');?></a>
            </li>
		<?php // endif; ?>
        <?php // if ($anyMedia != 0): ?>
            <li class="<?php // echo $CategoryType == COMPANY_MEDIA ? 'active':'';?>">
                <a class="icon_link" href="<?php // echo $company->COMPANY_URL.'/media';?>"><i class="media_tab_icon"></i><?php echo $this->__('Media');?></a>
            </li>
		<?php // endif; ?>
    </ul> -->
<?php // endif;?>