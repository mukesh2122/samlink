<div class="clearfix <?php echo !isset($hideAdd) ? 'mt10' : ''; ?> header news clearfix">
    <a href="<?php echo MainHelper::site_url('news'); ?>" class="fl"><?php echo $this->__('News'); ?></a>
</div>
<?php if(isset($crumb)): ?>
    <div class="clearfix">
        <?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb));
        if(isset($searchText)) { echo $this->renderBlock('news/common/search_block', array('searchText' => $searchText)); }
        else { echo $this->renderBlock('news/common/search_block', array()); }; ?>
    </div>
    <div class="clear">&nbsp;</div>
<?php endif; ?>

<form action="<?php echo MainHelper::site_url('news/update/' . $article->ID_NEWS); ?>" method="post" enctype="multipart/form-data" id="editnew_form">
    <input type="hidden" name="news_id" id="news_id" value="<?php echo $article->ID_NEWS; ?>">
    <input type="hidden" name="save_close" id="save_close" value="0">
    <div class="clearfix mt10">
        <div class="fs14 fl"><?php echo $this->__('News Type'), ": ", $article->OwnerType; ?></div>
        <div class="grid_3 mt3 clearfix">
            <div><input type="radio" name="action" value="1" class="news_action" id="news_edit" checked="checked"><label class="cp" for="news_edit"><?php echo $this->__("Edit"); ?></label></div>
            <div class="mt3"><input type="radio" name="action" class="news_action" value="2" id="news_preview"><label class="cp" for="news_preview"><?php echo $this->__("Preview"); ?></label></div>
        </div>
    </div>
    <div class="news_edit_container">
        <?php echo $this->renderBlock('news/admin/edit', array('article' => $article, 'gameCompanyName' => $gameCompanyName, 'platforms' => $platforms)); ?>
    </div>
    <div class="news_preview_container dn">
        <?php echo $this->renderBlock('news/admin/preview', array('article' => $article)); ?>
    </div>
</form>
<script type="text/javascript">loadCheckboxes();</script>