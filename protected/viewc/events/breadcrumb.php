<?php if(isset($crumb)):?>
    <div class="breadcrumb clearfix mt2 fl">
        <?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb));?>
    </div>
<?php endif; ?>  