<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
		<!-- E-Sports menu start -->
		<?php echo $this->renderBlock('esport/common/es_top_menu',array('esMenuSelected'=>$esMenuSelected)); ?>
		<!-- E-Sports menu end -->

		<!-- E-Sports content start -->
		<div class="esports_content">
			<?php echo $this->renderBlock('esport/common/leftcolumn', array('profile'=>$profile,'choosegameEnabled'=>false,'bettingladderEnabled'=>false)); ?>		
			<?php echo $this->renderBlock('admin/esport/editachievement/rightcolumn', array('profile'=>$profile,'ID_TEAM'=>$ID_TEAM,'acData'=>$acData)); ?>			
		</div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->
