<?php if(isset($crumb)): ?>
		<div class="clearfix">
			<?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)); ?>
		</div>
<?php endif; ?>



<div class="mt10">
	<div class="catwrap"> 
        <div class="forumCategoryBar">
            <div class="forumCategoryNameLeft">
                <div class="forumCategoryName">
                    <?php echo $this->__('Banned Members'); ?>
                </div>
            </div>
            <div class="forumCategoryRight">
            </div>
        </div>
    </div>
	
	<div class="mt10">
		<?php
		echo $this->__('On this forum the following members is currently banned, or has been banned at some point.');
		?>
	</div>

	<div class="mt10">
		<h2>
		<?php echo $this->__('Current bans:'); ?>
		</h2>
	</div>
	<?php 
	if(empty($activeBans)){
		echo $this->__('At the moment, there are no current bans');
	}else{
	?>
		<table class="w600">
			<thead>
	            <tr class="linie_light_grey mb20">
	                <td><?php echo $this->__("Member") . ":"; ?></td>
	                <td><?php echo $this->__("Area") . ":"; ?></td>
	                <td><?php echo $this->__("Period") . ":"; ?></td>
	                <td></td>
	            </tr>
	   		</thead>

	   	<?php foreach ($activeBans as $ban) { 
	   		$player = User::getById($ban->ID_PLAYER); ?>
	   		<tr>
                <td><?php echo $player->DisplayName; ?></td>
                <td><?php 
                	if($ban->ID_BOARD == 0){
                		echo $this->__('Whole Forum');
                	}else{
                		$board = Forum::getBoardInfo($type, $id, $ban->ID_BOARD);
                		echo $ban->ID_BOARD." -</br> ".$board->BoardName ; 
                	} ?>
                </td>
                <td><?php 
	                if($ban->Unlimited == 1){
	                	echo $ban->StartDate." - " ; 
	                }else{
	                	echo $ban->StartDate." - ".$ban->EndDate;
	                } ?>
              	</td>
                <td>
                	<?php
	            	$today = date('Y-m-d');

	            	if($ban->Unlimited == 1){?>
	            		<form  method="post"  id="deactivateban_form"> 
	    					<input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
	        				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	        				<input type="hidden" name="url" id="url" value="<?php echo $url; ?>" />
	        				<input type="hidden" name="ID_SUSPEND" id="ID_SUSPEND" value="<?php echo $ban->ID_SUSPEND; ?>"/>
														
							<a href="javascript:void(0)" class="DeactivateBan roundedButton grey fr">
								<span class="lrc"></span>
								<span class="mrc"><?php echo $this->__('Deactivate ban'); ?></span>
								<span class="rrc"></span>
							</a>
							<input type="submit" class="dn hiddenSubmitButton" />
                   		</form>
	            	<?php
	            	}elseif($today > $ban->EndDate) { ?>
	            		<form  method="post"  id="movebantohistoty_form"> 
	    					<input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
	        				<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	        				<input type="hidden" name="url" id="url" value="<?php echo $url; ?>" />
	        				<input type="hidden" name="ID_SUSPEND" id="ID_SUSPEND" value="<?php echo $ban->ID_SUSPEND; ?>"/>

                   			<a href="javascript:void(0)" class="MoveToBanHistory roundedButton grey fr">
								<span class="lrc"></span>
								<span class="mrc"><?php echo $this->__('Move to history'); ?></span>
								<span class="rrc"></span>
								<input type="submit" class="dn hiddenSubmitButton" />
							</a>
                   		</form>


	            		
	            	<?php
	            	}else{
	            		echo $this->__('This ban is stil active.');
	            	}
	            	?>
	               
                </td>
            </tr>
	   	<?php
	   	}
	  	?>
	    </table>
	<?php
	}
	?>
	<div class="mt10">
		<h2>
		<?php echo $this->__('Ban history:'); ?>
		</h2>
	</div>
	<?php
	if(empty($banHistory)){
		echo $this->__('At the moment, the ban history is empty.');
	}else{
	?>
		<table class="w600">
			<thead>
	            <tr class="linie_light_grey mb20">
	                <td><?php echo $this->__("Member") . ":"; ?></td>
	                <td><?php echo $this->__("Area") . ":"; ?></td>
	                <td><?php echo $this->__("Period") . ":"; ?></td>
	                 <td></td>
	            </tr>
	   		</thead>

	   	<?php foreach ($banHistory as $ban) { 
	   		$player = User::getById($ban->ID_PLAYER); ?>
	   		<tr>
                <td><?php echo $player->DisplayName; ?></td>
                <td><?php 
                	if($ban->ID_BOARD == 0){
                		echo $this->__('Whole Forum');
                	}else{
                		$board = Forum::getBoardInfo($type, $id, $ban->ID_BOARD);
                		echo $ban->ID_BOARD." -</br> ".$board->BoardName ; 
                	} ?>
                </td>
                <td><?php 	                
	                	echo $ban->StartDate." - ".$ban->EndDate;
	                ?>
              	</td>
              	 <td></td>
            </tr>
	   	<?php
	   	}
	  	?>
	    </table>
	<?php
	}
	?>
</div>

	
