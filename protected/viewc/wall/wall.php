<?php
    include ('common/typeTop.php');
    $messArr = (object)unserialize($item->Message);
    $content = $messArr->content;
    $viewer = User::getUser();
    $suspendLevel = ($viewer) ? $viewer->getSuspendLevel() : 0;
    $nocommenting = ($suspendLevel==1 || $suspendLevel==2) && $viewer->ID_PLAYER==$item->ID_OWNER;
?>
<!-- Wall text item start -->
<!--<div class="wallThinkingBox">
	<form method="post">
    	<input type="text" name="wall_thinkingBox" placeholder="What are you thinking of?"/>
    </form>
</div>-->

<div class="wall_item clearfix itemPost post_wall_<?php echo $item->ID_WALLITEM; ?>">
	<a class="wall_item_img" title="<?php echo $nick; ?>" href="<?php echo $url; ?>"><?php echo $img; ?></a>
	<div class="wall_item_meta">
		<div class="wall_item_text">
			<a href="<?php echo $url;?>"><?php echo $nick; ?></a>
			<?php echo ContentHelper::handleContentOutput($content); ?>
		</div>
		<?php include('common/comment_block.php');?>
		<?php if(($item->isOwner() or $item->isWallOwner()) && !$nocommenting): ?>
			<div class="wall_item_dropdown item_dropdown">
				<a href="javascript:void(0)" class="wall_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options');?></a>
				<ul class="wall_item_dropdown_options item_dropdown_options">
					<li>
						<a class="delete_post" rel="<?php echo $item->ID_WALLITEM; ?>" href="javascript:void(0)"><?php echo $this->__('Delete');?></a>
					</li>
				</ul>
			</div>
		<?php endif;?>
	</div>
</div>
<!--<div class="wall_linePost">&nbsp;</div>-->
<!-- Wall text item end -->
<?php /*
<?php include ('common/typeTop.php');?>
<div class="clearfix mt10 pt10 dot_top itemPost pr post_wall_<?php echo $item->ID_WALLITEM; ?>">
    <div class="grid_1 alpha"><a class="img" title="<?php echo $nick;?>" href="<?php echo $url;?>"><?php echo $img?></a></div>
	 <div class="grid_5 alpha omega">
        <span class="mt0"><a href="<?php echo $url;?>"><?php echo $nick;?></a></span>
		<?php
            $messArr = (object)unserialize($item->Message);
            $content = $messArr->content;
            echo ContentHelper::handleContentOutput($content);
        ?>
    </div>
	<div>
		<?php include('common/comment_block.php');?>
	</div>
	<?php if($item->isOwner()): ?>
		<a href="javascript:void(0)" class="itemMoreActions iconr_moreActions t0 r0 zi2 pa mt5 dn"></a>
		<div class="itemMoreActionsBlock pa dn">
			<a class="db delete_post" rel="<?php echo $item->ID_WALLITEM; ?>" href="javascript:void(0)"><?php echo $this->__('Delete');?></a>
		</div>
	<?php endif;?>
</div>
 */?>