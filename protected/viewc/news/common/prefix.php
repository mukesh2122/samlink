<?php
$prefix = Prefix::getPrefixById($item->ID_PREFIX);
if(!empty($prefix) && $prefix->ID_PREFIX != '1'): ?>
    <div class="list_item_prefix" style="color:<?php echo $prefix->PrefixColor; ?>;">
        <?php echo "[", $this->__($prefix->PrefixName), "]"; ?>
    </div>
<?php endif; ?>