<?php $user=User::getUser(); ?>
<ul class="horizontal_tabs clearfix">
	<li class="<?php echo $translate->transFilter == 'all' ?'active' : '';?>">
			<a href="<?php echo MainHelper::site_url('admin/translate'.(isset($translate->A2) ? ('/'.$translate->A2) : '')."/all".(isset($translate->sortType) ? ('/sort/'.$translate->sortType.'/'.$translate->sortDir) : '') );
			?>">All</a>
	</li>
	<li class="<?php echo $translate->transFilter == 'new' ?'active' : '';?>">
			<a href="<?php echo MainHelper::site_url('admin/translate'.(isset($translate->A2) ? ('/'.$translate->A2) : '')."/new".(isset($translate->sortType) ? ('/sort/'.$translate->sortType.'/'.$translate->sortDir) : '') );
			?>">New (<?php echo $totalNew;?>)</a>
	</li>
</ul>



<form class="c_column_search clearfix" name="searchform" method="post" action=
"<?php echo MainHelper::site_url('admin/translate'.(isset($translate->A2) ? ('/'.$translate->A2) : '').(isset($translate->transFilter) ? ('/'.$translate->transFilter) : '').(isset($translate->sortType) ? ('/sort/'.$translate->sortType.'/'.$translate->sortDir) : '') . (($translate->page!="") ? ('/page/'.$translate->page) : '') );
; ?>">
<input type="text" class="c_column_search_input withLabel"  name="search" id="search" value="<?php if (isset($translate->search)) echo $translate->search; ?>" />
<input type="submit" class="c_column_search_button green" value="Search" />
</form>



<form name="editform" method="post" action=
"<?php echo MainHelper::site_url('admin/translate'.(isset($translate->A2) ? ('/'.$translate->A2) : '').(isset($translate->transFilter) ? ('/'.$translate->transFilter) : '').(isset($translate->sortType) ? ('/sort/'.$translate->sortType.'/'.$translate->sortDir) : '') . (($translate->page!="") ? ('/page/'.$translate->page) : '') );
; ?>">


<?php if(isset($translateTexts) and !empty($translateTexts)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_25 centered">
					<a href="<?php echo MainHelper::site_url('admin/translate'.(isset($translate->A2) ? ('/'.$translate->A2) : '').(isset($translate->transFilter) ? ('/'.$translate->transFilter) : '').'/sort/TransKey/'.(isset($translate->sortType) && $translate->sortType == 'TransKey' && $translate->sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'TransKey'.($translate->sortType == 'TransKey' ? ($translate->sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_25 centered">
					<a href="<?php echo MainHelper::site_url('admin/translate'.(isset($translate->A2) ? ('/'.$translate->A2) : '').(isset($translate->transFilter) ? ('/'.$translate->transFilter) : '').'/sort/TransText/'.(isset($translate->sortType) && $translate->sortType == 'TransText' && $translate->sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'TransText'.($translate->sortType == 'TransText' ? ($translate->sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>

		<tbody>

		<!--<input type="hidden" id="editname" name="editname" value="" />-->
		<!--<input type="hidden" id="editid" name="editid" value="" />-->
			<?php foreach($translateTexts as $translateitem):?>
				<?php
					
					$allowEdit = $translateitem->allowEdit;

					$TransKey = $translateitem->TransKey;
					//Exception: if not english.. then show english TransText as TransKey
					if ($translate->A2!="EN")
					{
						$TransKey = $translateitem->TransTextEN;
					}
					else
					{
						//If english, then allow edit no matter what.
						$allowEdit = "1";
					}

				?>
				<tr>
					<td class="centered" style="width:45%;"><?php echo $TransKey;?></td>
					<td class="centered" style="width:45%;">
						<?php $t = $translateitem->TransText;$r = floor(strlen($t) / 28) + count(explode('\n',$t)); ?>
						
						<?php if ($allowEdit=="0"){ /*?>
						<textarea rows="<?php echo $r ?>" cols="28" tabindex="1" style="overflow:hidden;" 
							readonly="readonly"><?php echo $translateitem->TransText;?></textarea>
						<?php */}else{ ?>
						<textarea rows="<?php echo $r ?>" cols="28" tabindex="1" style="overflow:hidden;" 
							name = "edit<?php echo $translateitem->ID_TEXT;?>"
							onkeyup="t=this.value;this.rows = Math.floor(t.length / this.cols) + t.split('\n').length;"
							<?php if (1==2){?>onchange="
d1=document.getElementById('editname');d1.value='edit<?php echo $translateitem->ID_TEXT;?>';
d2=document.getElementById('editid');d2.value='<?php echo $translateitem->ID_TEXT;?>';
document.editform.submit();" <?php }?> ><?php echo $translateitem->TransText;?></textarea>
						<?php } ?>

					</td>
					<td class="centered">
						<?php if ($allowEdit=="1" && $user->canAccess('Super Admin Interface')){ ?>
						<a href="<?php echo MainHelper::site_url('admin/translate/edit/'.$translateitem->ID_TEXT."/".$translate->A2 . (isset($translate->transFilter) ? ('/'.$translate->transFilter) : '').(isset($translate->sortType) ? ('/sort/'.$translate->sortType.'/'.$translate->sortDir) : '') . (($translate->page!="") ? ('/page/'.$translate->page) : ''));?>"><?php echo 'Edit';?></a>
						<?php } ?>
					</td>
				</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="3">
					<input type="submit" class="button button_auto light_blue pull_right" value="Save" />
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	if(isset($pager)){
		echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	}
endif;
?>
</form>
