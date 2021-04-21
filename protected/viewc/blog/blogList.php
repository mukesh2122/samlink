<?php
    $user = (Auth::isUserLogged()) ? User::getUser() : FALSE;
    $featured = (isset($featuredBlog)) ? TRUE : FALSE;
?>
<!-- News list start -->
    <div class="list_header">
        <h1><?php echo $headerName; ?></h1>
        <?php if($user !== FALSE && $user->hasBlog == 1): ?>
            <a href="<?php echo MainHelper::site_url('blog/addblog'); ?>" class="list_header_button"><?php echo $this->__('Add Blog Post'); ?></a>
        <?php endif; ?>
    </div>
    <?php if(isset($blogList) and !empty($blogList)): ?>
        <div class="item_list">
            <?php foreach ($blogList as $key=>$item) {
                echo $this->renderBlock('blog/blogItemLine', array('item' => $item, 'featuredBlog' => $featured));
            }; ?>
        </div>
        <?php echo $this->renderBlock('common/pagination', array('pager'=>$pager));
    endif; ?>
<!-- News list end -->