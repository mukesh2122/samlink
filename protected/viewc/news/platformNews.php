<?php
include('common/top.php');
if(!empty($platforms)): ?>
    <div class="content_hidden<?php echo ($showClosed === TRUE) ? '' : ' dn'; ?>">
        <table class="table table_bordered table_striped table_options" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="size_70"><?php echo $this->__('All Platforms'); ?></th>
                    <th class="size_10 centered"><?php echo $this->__('Posts'); ?></th>
                    <th class="size_20 centered"><?php echo $this->__('Popularity'); ?></th>
                </tr>
            </thead>
        </table>
        <div class="show_content">
            <a href="javascript:void(0);" rel="<?php echo NEWS_PLATFORM; ?>"><?php echo $this->__('Show Platform List'); ?></a>
        </div>
    </div>

    <div class="content_shown<?php echo ($showClosed === TRUE) ? ' dn' : ''; ?>">
        <table class="table table_bordered table_striped gradient_thead table_options" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="size_70"><?php echo $this->__('All Platforms'); ?></th>
					<?php if(Auth::isUserLogged()): ?>
                        <th class="size_20 centered"></th>
                    <?php endif; ?>
                    <th class="size_10 centered"><?php echo $this->__('Posts'); ?></th>
                    <th class="size_20 centered"><?php echo $this->__('Popularity'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($platforms as $key => $platform): ?>
                    <tr <?php echo (isset($activePlatform) && $activePlatform->ID_PLATFORM == $platform->ID_PLATFORM) ? 'class="active"' : ''; ?>>
                        <td>
                            <a href="<?php echo $platform->NEWS_URL, "/close"; ?>"><?php echo $platform->PlatformName; ?></a>
                        </td>
                        <?php if(Auth::isUserLogged()): ?>
                        <td class="centered">
							<?php if(Players::isPlatformSubscribed($platform->ID_PLATFORM, 'platform')): ?>
                                <a data-opt='{"id":"<?php echo $platform->ID_PLATFORM; ?>", "type":"<?php echo SUBSCRIPTION_PLATFORM; ?>"}' class="icon_link unsubscribe unsubscribe_<?php echo $platform->ID_PLATFORM; ?>" href="javascript:void(0);">
                                    <i class="unsubscribe_icon"></i><?php echo $this->__('Unsubscribe'); ?>
                                </a>
                                <a data-opt='{"id":"<?php echo $platform->ID_PLATFORM; ?>", "type":"<?php echo SUBSCRIPTION_PLATFORM; ?>"}' class="icon_link dn subscribe subscribe_<?php echo $platform->ID_PLATFORM; ?>" href="javascript:void(0);">
                                    <i class="subscribe_icon"></i><?php echo $this->__('Subscribe'); ?>
                                </a>
                            <?php else: ?>
                                <a data-opt='{"id":"<?php echo $platform->ID_PLATFORM; ?>", "type":"<?php echo SUBSCRIPTION_PLATFORM; ?>"}' class="icon_link subscribe subscribe_<?php echo $platform->ID_PLATFORM; ?>" href="javascript:void(0);">
                                    <i class="subscribe_icon"></i><?php echo $this->__('Subscribe'); ?>
                                </a>
                                <a data-opt='{"id":"<?php echo $platform->ID_PLATFORM; ?>", "type":"<?php echo SUBSCRIPTION_PLATFORM; ?>"}' class="icon_link dn unsubscribe unsubscribe_<?php echo $platform->ID_PLATFORM; ?>" href="javascript:void(0);">
                                    <i class="unsubscribe_icon"></i><?php echo $this->__('Unsubscribe'); ?>
                                </a>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                        <td class="centered">
                            <?php echo $platform->NewsCount; ?>
                        </td>
                        <td class="centered">
                            <?php echo str_repeat("<i class='green_star_icon'></i>&nbsp;", $platform->RatingCur); ?><?php echo str_repeat("<i class='grey_star_icon'></i>&nbsp;", (5 - $platform->RatingCur)); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="hide_content">
            <a href="javascript:void(0);" rel="<?php echo NEWS_PLATFORM; ?>"><?php echo $this->__('Hide Platform List'); ?></a>
        </div>
    </div>
<?php endif;

if(isset($recentNews)) {
    echo $this->renderBlock('news/newsList', array('newsList' => $recentNews, 'order' => '0', 'tab' => 0, 'pager' => $pager, 'pagerObj' => $pagerObj, 'rating' => (isset($activePlatform)) ? $activePlatform->RatingCur : null, 'headerName' => (isset($activePlatform)) ? $activePlatform->PlatformName : $this->__('Recent News')));
}; ?>