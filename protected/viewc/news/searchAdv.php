<!--?php include('common/top.php'); ?-->
<div id="news_center_column" class="column content_middle">
    <?php
    if (isset($topNews)) {
        echo $this->renderBlock('news/topNewsList', array('topNews' => $topNews, 'blockType' => NEWS_TOP, 'head' => $this->__('Top News'), 'hideText' => $this->__('Top News')));
    };
    ?>

    <!-- News advanced search start -->
    <?php if (isset($url)): ?>
        <div id="searchField">
            <form method="GET" id="searchAdv_Form" class="searchForm" tester="etellerandet" action="<?php echo MainHelper::site_url('news/searchAdvResult'); ?>">
                <?php echo $this->__('Headline'); ?> <input name="searchAdv_headline" id="searchAdv_headline" type="text" class="searchAdv_inputField">
                <?php echo $this->__('Description'); ?> <input name="searchAdv_description" id="searchAdv_description" type="text" class="searchAdv_inputField">
                <?php echo $this->__('Author'); ?> <select id="searchAdv_author" name='searchAdv_author'>
                    <option value="">-</option>
                    <?php foreach ($authors as $option) : ?>
                        <option value="'<?php echo $option['id']; ?>'"><?php echo $option['name']; ?></option>

                    <?php endforeach; ?>

                </select>



                <div id="searchAdv_button"><input type="submit" class="searchAdv_buttonIcon"></div>

        </div>
    <?php endif; ?>
    <!-- News advanced search end -->





</div> 