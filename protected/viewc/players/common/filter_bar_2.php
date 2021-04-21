<?php
	$catPath = ($selectedCategory!=0) ? "category/" . $selectedCategory . "/" : "";
    $url = MainHelper::site_url('players/top-list/' . $catPath);
    $transVisits = $this->__('Visits');
    $transRating = $this->__('Rating');
 ?>

<div class="filter_bar clearfix">
	<div class="filter_bar_label"><?php echo $this->__('Sort by') ?>:</div>
	<div class="filter_bar_options">
		<?php if($tab === 1):
			if($order === 'DESC'): ?>
				<a href="<?php echo $url . 'tab/visits/asc'; ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $transVisits; ?></span></a>
			<?php else: ?>
				<a href="<?php echo $url . 'tab/visits/desc'; ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $transVisits; ?></span></a>
			<?php endif;
		elseif(($tab !== 1) && (($tab === 3) || ($tab === 4))): ?>
            <a href="<?php echo $url . 'tab/visits/desc'; ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $transVisits; ?></span></a>
        <?php else: ?>
			<a href="<?php echo $url . 'tab/visits/desc'; ?>"><span><?php echo $transVisits; ?></span></a>
		<?php endif;
				
		//if(MainHelper::IsModuleEnabledByTag('contentchild') === 1 && MainHelper::IsModuleNotAvailableByTag('contentchild') === 0): ?>
            <?php if($tab === 2):
                if($order === 'DESC'): ?>
                    <a href="<?php echo $url . 'tab/rating/asc'; ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $transRating; ?></span></a>
                <?php else: ?>
                    <a href="<?php echo $url . 'tab/rating/desc'; ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $transRating; ?></span></a>
                <?php endif;
            else: ?>
                <a href="<?php echo $url . 'tab/rating/desc'; ?>"><span><?php echo $transRating; ?></span></a>
            <?php endif;
     //   endif;

                // if (($tab == 1) || ($tab == 3) || ($tab == 4)):
       // if(MainHelper::IsModuleEnabledByTag('groups') === 1 && MainHelper::IsModuleNotAvailableByTag('groups') === 0): ?>
            <?php if($tab === 3):
                if($order === 'DESC'): ?>
                    <a href="<?php echo $url . 'tab/this-week/asc'; ?>"><input type="radio" checked><span><?php echo $this->__('&nbsp; This Week'); ?></span></a>
                <?php endif;
            elseif(($tab === 2) && ($tab !== 3)): ?>
                <span><?php echo $this->__('&nbsp; This Weeks &nbsp;'); ?></span>
            <?php else: ?>
                <a href="<?php echo $url . 'tab/this-week/desc'; ?>"><span><?php echo $this->__('This Week'); ?></span></a>
            <?php endif;
       
    //    endif;

        if(($tab === 4) || ($tab === 1)):
            if($order === 'DESC' || $order === 'ASC'): ?>
                <a href="<?php echo $url . 'tab/all-time/asc'; ?>"><input type="radio" checked><span><?php echo $this->__('&nbsp; All Time'); ?></span></a>
            <?php endif;
        elseif(($tab === 2) && ($tab !== 4)): ?>
            <span color=""><?php echo $this->__('&nbsp; All TIme &nbsp;'); ?></span>
        <?php else: ?>
            <a href="<?php echo $url . 'tab/all-time/desc'; ?>"><span><?php echo $this->__('All Time'); ?></span></a>
        <?php endif; ?>
 
	</div>
</div>