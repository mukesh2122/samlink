<?php
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
$isEnabledContentchild = MainHelper::IsModuleEnabledByTag('contentchild');
if (MainHelper::IsModuleNotAvailableByTag('news') == 1) {
    $isEnabledNews = 0;
};
if (MainHelper::IsModuleNotAvailableByTag('contentchild') == 1) {
    $isEnabledContentchild = 0;
};
$companyUrl = $item->COMPANY_URL;
$description = $this->__($item->CompanyDesc);
$descLimit = 170;
$showAdminFunc = false;
if (Auth::isUserLogged() === TRUE) {
    $userPlayer = User::getUser();
    $suspendLevel = $userPlayer->getSuspendLevel();
    $noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
    if (!$noProfileFunctionality) {
        $showAdminFunc = true;
        if ($userPlayer->isDeveloper() || $userPlayer->isSuperUser || $userPlayer->isTranslator()) {
            $funcList[] = '<a href="javascript:void(0);" class="action_translate" data-selec="company" rel="' . $item->ID_COMPANY . '">' . $this->__('Translate') . '</a>';
        };
    };
};
?>

<div class="list_item clearfix itemPost">
    <a class="list_item_img" href="<?php echo $companyUrl; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_80x80, false, array('no_img' => 'noimage/no_company_80x80.png')); ?></a>
    <div class="list_item_meta">
        <h2><a class="list_item_header" href="<?php echo $companyUrl; ?>"><?php echo $this->__($item->CompanyName); ?></a></h2>
        <p class="list_item_description short_desc_<?php echo $item->ID_COMPANY; ?>">
            <?php
            if ($description) {
                echo strip_tags(DooTextHelper::limitChar($description, $descLimit));
            } else {
                echo $this->__('There is no description for this company at the moment.');
            };
            ?>
        </p>
        <p class="list_item_description long_form dn long_desc_<?php echo $item->ID_COMPANY; ?>">
            <?php echo ContentHelper::handleContentOutput($description); ?>
        </p>
        <ul class="list_item_footer">
            <?php if (strlen($description) > $descLimit): ?>
                <li>
                    <a class="icon_link revealmore" data-open="<?php echo $this->__('Read more'); ?>" data-close="<?php echo $this->__('Hide description'); ?>" data-id="<?php echo $item->ID_COMPANY; ?>" href="javascript:void(0);"><i class="readmore_icon"></i><?php echo $this->__('Read more'); ?></a>
                </li>
            <?php endif; ?>
            <?php if ($isEnabledNews == 1): ?>
                <li>
                    <a class="icon_link" href="<?php echo $companyUrl . '/news'; ?>"><i class="news_icon"></i><?php echo $item->NewsCount; ?> <?php echo $this->__('News'); ?></a>
                </li>
            <?php endif; ?>
            <?php if ($isEnabledContentchild == 1 && $item->GameCount > 0): ?>
                <li>
                    <a class="icon_link" href="<?php echo $companyUrl . '/games'; ?>"><i class="games_icon"></i><?php echo $item->GameCount; ?> <?php echo ($item->GameCount != 1) ? $this->__('Games') : $this->__('Game'); ?></a>
                </li>
            <?php endif; ?>
        </ul>

        <?php if ($showAdminFunc === true): ?>
            <?php
            if (isset($funcList)) {
                ?>
                <div class = "list_item_dropdown item_dropdown">
                    <a href = "javascript:void(0);" class = "list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options');
                ?></a>
                    <ul class="list_item_dropdown_options item_dropdown_options">
                        <li><?php echo implode("</li><li>", $funcList); ?></li>
                    </ul>
                </div>
                <?php
            }
            ?>
        <?php endif; ?>
    </div>
</div>

<?php /*
  <div class="clearfix mt5 pr itemPost">
  <div class="w100px pr5 fl">
  <?php if(isset($topStars) and $topStars > 0):?>
  <span class="top_stars"><span class="star_<?php echo $topStars;?>">&nbsp</span></span>
  <?php endif;?>
  <a class="company_img clearfix db" href="<?php echo $companyUrl; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_company_100x100.png')); ?></a>
  <div class="game100 clearfix">

  <?php echo str_repeat("<span class='star_blue'></span>", round($item->SocialRating, 0));?><?php echo str_repeat("<span class='star_grey'></span>", (5 - round($item->SocialRating, 0)));?><span class="fr fft db fs11 fcblue"><?php echo number_format($item->SocialRating, 1);?></span>
  </div>
  </div>
  <div class="fl w490 pl5 pt3 dot_top">
  <h2 class="company_list_header fft mt0 fs16 pb3 fl">
  <a class="fs18 fclg2 db" href="<?php echo $companyUrl; ?>"><?php echo $item->CompanyName; ?></a>
  </h2>
  <?php if($item->HistoryPop > 0 or $item->HistoryTop > 0):?>
  <div class="fr clearfix">
  <?php if($item->HistoryPop > 0):?>
  <span class="fr db star_pop star_top_blue"><?php echo $item->HistoryPop;?></span>
  <?php endif; ?>
  <?php if($item->HistoryTop > 0):?>
  <span class="fr db star_top star_top_yellow"><?php echo $item->HistoryTop;?></span>
  <?php endif; ?>

  </div>
  <?php endif; ?>
  <div class="clear"></div>
  <div class="mt3 fclg fs11 ffv oh h45 short_desc_<?php echo $item->ID_COMPANY; ?>">
  <strong><?php echo $this->__('Description'); ?>:</strong>
  <?php echo ContentHelper::groupShortDescription($description); ?>
  </div>
  <div class="mt3 fclg fs11 ffv pb30 dn long_desc_<?php echo $item->ID_COMPANY; ?>">
  <strong><?php echo $this->__('Description'); ?>:</strong>
  <?php echo ContentHelper::handleContentOutput($description); ?>
  </div>
  </div>

  <div class="groupStatistics mt10 pa b0 r0 w490 mb5">
  <?php if (strlen(ContentHelper::downloadShortDescription($description)) != strlen($description)): ?>
  <a class="fl db fs12 fft readmore mr10" name="<?php echo $this->__('Read more'); ?>" rev="<?php echo $this->__('Hide description'); ?>" rel="<?php echo $item->ID_COMPANY; ?>" href="javascript:void(0)"><?php echo $this->__('Read more'); ?></a>
  <?php endif; ?>


  <div class="groupStatisticsItem fl mr10">
  <span class="iconr_newsGroup fl"></span>
  <a href="<?php echo $companyUrl . '/news'; ?>" class="fl db ml5 fs12 fclg3"><?php echo $this->__('News'); ?> (<?php echo $item->NewsCount; ?>)</a>
  </div>
  <div class="groupStatisticsItem fl mr10">
  <span class="iconr_gameUsage fl"></span>
  <a href="<?php echo $companyUrl . '/games'; ?>" class="fl db ml5 fs12 fclg3"><?php echo $this->__('Games'); ?> (<?php echo $item->GameCount; ?>)</a>
  </div>
  </div>
  </div>
 */ ?>