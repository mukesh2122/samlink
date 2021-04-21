<div class="filter_bar clearfix">
    <div class="filter_bar_label">
        <?php echo $this->__('Order companies:'); ?>
    </div>
    <div class="filter_bar_options">
        <?php if ($tab == 1):
            if ($order == 'desc' or $order = ''):
                ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/alphabetically/asc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('Alphabetically'); ?></span></a>
            <?php else: ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/alphabetically/desc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('Alphabetically'); ?></span></a>
            <?php endif;
        else:
            ?>
            <a href="<?php echo MainHelper::site_url('companies/tab/alphabetically/asc'); ?>"><span><?php echo $this->__('Alphabetically'); ?></span></a>
        <?php
        endif;

        if ($tab == 2):
            if ($order == 'desc' or $order = ''):
                ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/by-popularity/asc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('By Popularity'); ?></span></a>
            <?php else: ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/by-popularity/desc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('By Popularity'); ?></span></a>
            <?php endif;
        else:
            ?>
            <a href="<?php echo MainHelper::site_url('companies/tab/by-popularity/desc'); ?>"><span><?php echo $this->__('By Popularity'); ?></span></a>
        <?php
        endif;

        if ($tab == 3):
            if ($order == 'desc' or $order = ''):
                ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/by-rating/asc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('By Rating'); ?></span></a>
            <?php else: ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/by-rating/desc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('By Rating'); ?></span></a>
            <?php endif;
        else:
            ?>
            <a href="<?php echo MainHelper::site_url('companies/tab/by-rating/desc'); ?>"><span><?php echo $this->__('By Rating'); ?></span></a>
                <?php
                endif;

                if ($tab == 4):
                    if ($order == 'desc' or $order = ''):
                        ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/by-date-added/asc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('By Date Added'); ?></span></a>
    <?php else: ?>
                <a href="<?php echo MainHelper::site_url('companies/tab/by-date-added/desc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('By Date Added'); ?></span></a>
    <?php endif;
else:
    ?>
            <a href="<?php echo MainHelper::site_url('companies/tab/by-date-added/desc'); ?>"><span><?php echo $this->__('By Date Added'); ?></span></a>
<?php endif; ?>
    </div>
</div>