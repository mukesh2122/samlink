<?php 
// This page is also visible when url is typed in, should only be visible for our admins.
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
$forumBanned = MainHelper:: ifBannedForum($type, $model->UNID);
if(isset($infoBox)) { echo $infoBox; };

include('common/tabs.php'); // includes the forum submenu

if($model->isForumAdmin() OR $model->isForumMod() && !$forumBanned && !$noProfileFunctionality): ?>
    <!-- the create new cat button-->
    <a class="button button_large light_grey fr" rel="iframe" href="<?php echo MainHelper::site_url('adminforum/'.$type.'/'.$url.'/create/category'); ?>">
        <?php echo $this->__('Create New Category') . " +"; ?>
    </a>
<?php endif;
    if(isset($crumb)): ?>
        <!--the crumb missing the last part=   > admin forum    or something like that -->
    	<div class="clearfix">
    		<?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)); ?>
    	</div>
    <?php endif; ?>
<div class="mt10">
    <div class="catwrap"> 
        <div class="forumCategoryBar">
            <div class="forumCategoryNameLeft">
                <div class="forumCategoryName">
                    <?php echo $this->__('Admin panel'); ?>
                </div>
            </div>
            <div class="forumCategoryRight">
            </div>
        </div>
    </div>
           
    <!--get a overview of the cats.-->
    <input type="hidden" id="type" value="<?php echo $type; ?>">
    <input type="hidden" id="id" value="<?php echo $model->UNID; ?>">

    <?php if(!isset($categories) && empty($categories)): 
        echo '<div class="mt10">'.$this->__('In this forum, there are at the moment no categories') . ".</div>";
    else: ?>
    	<div class="hdots mt10 mb20"><?php echo $this->__("In this forum, the following categories are available") . ":"; ?></div>
        <table class="w600">
            <thead>
                <tr>
                    <td><?php echo $this->__("Category Order") . ":"; ?></td>
                    <td><?php echo $this->__("Category name") . ":"; ?></td>
                </tr>
            </thead>
            <?php foreach($categories as $c): ?>
                <tr class="linie_light_grey mb20">
                    <td><?php echo $this->__($c->CatOrder); ?></td>
                    <td><?php echo $this->__($c->CategoryName); ?></td>
                    <a href="javascript:void(0);" class="itemMoreActions iconr_moreActions pa r0 mr30 zi2 dn" rel="<?php echo $c->ID_CAT; ?>"></a>
                    <td>
                        <a class="db" rel="iframe" href="<?php echo MainHelper::site_url('adminforum/'.$c->OwnerType.'/'.$url.'/editorder/'.$c->ID_CAT); ?>">
                            <?php echo $this->__('Update Category Order'); ?>
                        </a>
                    </td>
                    <td>
                        <a class="db" rel="iframe" href="<?php echo MainHelper::site_url('adminforum/'.$c->OwnerType.'/'.$url.'/edit/category/'.$c->ID_CAT); ?>">
                            <?php echo $this->__('Edit'); ?>
                        </a>
                    </td>
                    <td>
                        <a class="db" rel="iframe" href="<?php echo MainHelper::site_url('adminforum/'.$c->OwnerType.'/'.$url.'/create/board/'.$c->ID_CAT); ?>">
                            <?php echo $this->__('Add new board'); ?>
                        </a>
                    </td>
                    <td>
                        <?php if(empty($c->boards)): ?>
                            <a class="deleteCategory db" rel="<?php echo $c->ID_CAT; ?>" href="javascript:void(0);">
                                <?php echo $this->__('Delete'); ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <?php if(!empty($c->boards)): // board overview
                        $n=0; ?>
                        <thead class="mt10">
                            <tr>
                                <td><?php echo $this->__('Board order') . ":"; ?></td>
                                <td><?php echo $this->__('Board name'). ":"; ?></td>
                            </tr>
                        </thead>
                        <?php foreach($c->boards as $b): ?>
                            <tr>
                                <td><?php echo $this->__($b->BoardOrder); ?></td>
                                <td><?php echo $this->__($b->BoardName); ?></td>
                                <a href="javascript:void(0);" class="itemMoreActions iconr_moreActions pa r0 mr30 zi2 dn" rel="<?php echo $c->ID_CAT; ?>"></a>							
                                <td>
                                    <a class="db" rel="iframe" href="<?php echo MainHelper::site_url('adminforum/'.$c->OwnerType.'/'.$url.'/editboardorder/'.$c->ID_CAT.'/'.$b->ID_BOARD); ?>">
                                        <?php echo $this->__('Update Order');  ?>
                                    </a>
                                </td>
                                <td>
                                    <a class="db mr20" rel="iframe" href="<?php echo MainHelper::site_url('adminforum/'.$c->OwnerType.'/'.$url.'/edit/board/'.$c->ID_CAT.'/'.$b->ID_BOARD); ?>">
                                        <?php echo $this->__('Edit'); ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if(empty($b->TopicCount)): ?>
                                        <a class="db" rel="iframe" href="<?php echo  MainHelper::site_url('adminforum/'.$c->OwnerType.'/'.$url.'/deleteboard/'.$c->ID_CAT.'/'.$b->ID_BOARD); ?>">
                                            <?php echo $this->__('Delete'); ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr><!--ends board rows-->
                        <?php $n++;
                        endforeach;
                    endif; ?>
                </tr>
            <?php endforeach; ?>
        </table> <!--end the cat rows and tabel-->
    <?php endif; ?>
</div>