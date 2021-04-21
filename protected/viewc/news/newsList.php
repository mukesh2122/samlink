<!-- News list start -->
<div class="list_container">
    <div class="list_header">
        <h1><?php echo $headerName; ?></h1>
    </div>
    <?php if(!isset($search) && isset($order) && ($order != 0) && isset($tab)) {
        echo $this->renderBlock('news/common/filter_bar', array(
            'tab' => $tab,
            'order' => $order
        ));
    };
    if(isset($newsList) && !empty($newsList)): ?>
        <div class="item_list">
            <?php foreach($newsList as $key => $item) {
                echo $this->renderBlock('news/newsItemLine', array('item' => $item));
            }; ?>
        </div>
        <?php echo $this->renderBlock('common/pagination', array('pager' => $pager));
    endif; ?>
</div>
<!-- News list end -->