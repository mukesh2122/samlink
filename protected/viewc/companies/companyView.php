<?php $isEnabledNews = MainHelper::IsModuleEnabledByTag('News'); ?>
<?php $isEnabledEvents = MainHelper::IsModuleEnabledByTag('Events'); ?>
<?php $isEnabledGames = MainHelper::IsModuleEnabledByTag('Games'); ?>
<?php $isEnabledContentchild = MainHelper::IsModuleEnabledByTag('contentchild'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('News')==1) $isEnabledNews = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('Events')==1) $isEnabledEvents = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('Games')==1) $isEnabledEvents = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('contentchild')==1) $isEnabledContentchild = 0; ?>

<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$contentparentFields = MainHelper::GetModuleFieldsByTag('contentparent'); 
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<?php
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
$isEnabledEvents = MainHelper::IsModuleEnabledByTag('events');
$isEnabledEvents = MainHelper::IsModuleEnabledByTag('events');
$isEnabledContentchild = MainHelper::IsModuleEnabledByTag('contentchild');
if(MainHelper::IsModuleNotAvailableByTag('news')==1) { $isEnabledNews = 0; };
if(MainHelper::IsModuleNotAvailableByTag('events')==1) { $isEnabledEvents = 0; };
if(MainHelper::IsModuleNotAvailableByTag('contentchild')==1) { $isEnabledContentchild = 0; };
include('common/top.php');
?>

<?php include('common/top.php'); ?>

<div class="global_info_page clearfix">

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1>Information</h1></div>
</div>
    
<div id="global_info_page_background">
    
	<div class="global_info_block">
                <h1><?php echo $company->CompanyName;?></h1>

		<?php $desc = ContentHelper::handleContentOutput($company->CompanyDesc); ?>
		<?php if($desc != ''): ?>
			<div class="pr20"><?php echo $desc;?></div>
		<?php else: ?>
			<div class="noItemsText"><?php echo $this->__('There is no description at the moment.'); ?></div>
		<?php endif; ?>

		<?php if(User::canAccess("Edit company")):?>
        <div class="mt10">
				<a class="fs11 sprite company_edit" rel="iframe" href="<?php echo $company->COMPANY_URL.'/admin/editcompanyinfo';?>"><?php echo $this->__('Edit company info');?></a>
        </div>
		<?php endif;?>
	</div>

<!--	<div class="global_info_meta">-->
<div class="infoBox">

		<div class="table_information">
			
                        <div class="title"><h2><?php echo $this->__('Information'); ?></h2></div>
                        <div class="hr">&nbsp;</div>
                        
                            <?php if ($isEnabledNews == 1): ?>
                        <div class="informationSubject">
				<div class="leftIcon"><i class="stat_news_icon"><img src="../global/img/iconNews.png"/></i></div>
				<div class="centerName"><p><?php echo ucfirst($this->__('News'));?></p></div>
				<div class="rightValue"><p><?php echo $company->NewsCount; ?></p></div>
				<div class="hr"></div>  
                        </div>
                            <?php endif;?>
				
                            <?php if ($isEnabledContentchild == 1 && $company->GameCount>0): ?>
                        <div class="informationSubject">
				<div class="leftIcon"><i class="stat_group_icon"><img src="../global/img/iconGames.png"/></i></div>
                                <div class="centerName"><p><?php echo ucfirst($this->__('Games'));?></p></div>
                                <div class="rightValue"><p><?php echo $company->GameCount; ?></p></div>
				<div class="hr"></div>
                        </div>
                            <?php endif;?>
				
                            <?php if ($isEnabledEvents == 1): ?>
                        <div class="informationSubject">
                                <div class="leftIcon"><i class="stat_event_icon"><img src="../global/img/iconEvents.png"/></i></div>
                                <div class="centerName"><p><?php echo ucfirst($this->__('Events'));?></p></div>
                                <div class="rightValue"><p><?php echo $company->EventCount; ?></p></div>
				<div class="hr"></div>
                        </div>
                            <?php endif;?>
                </div>

    
    <!-- Company info start -->    
    <div class="table_gameInfo">
        <span class="companyInfo">
                <span class="title"><h3><?php echo $this->__('Company Info');?>:</h3></span>
            </span>
            <div class="hr"></div>
            
        <?php if ($contentparentFields['Type']['isEnabled']==1 && !empty($company->CompanyType)): ?>
        <div class="user_informations">
            <span class="user_name"><?php echo $this->__('Type');?>:</span>
            <span class="user_value"><?php echo $company->CompanyType;?></span>
        </div>
            <div class="hr"></div>
				<?php endif; ?>
    
        <?php if ($contentparentFields['Address']['isEnabled']==1 && !empty($company->CompanyAddress)): ?>
        <div class="user_informations">
            <span class="user_name"><?php echo $this->__('Headquarters');?>:</span>
            <span class="user_value"><?php echo $company->CompanyAddress;?></span>
	</div>
        <div class="hr"></div>
            <?php endif; ?>
    
        <?php if ($contentparentFields['FoundedDate']['isEnabled']==1 && !empty($company->Founded)): ?>
        <div class="user_informations">
            <span class="user_name"><?php echo $this->__('Founded');?>:</span>
            <span class="user_value"><?php echo date("Y", strtotime($company->Founded));?></span>
</div>
            <div class="hr"></div>
        <?php endif; ?>

        <?php if ($contentparentFields['Employees']['isEnabled']==1 && !empty($company->Employees)): ?>
        <div class="user_informations">
            <span class="user_name"><?php echo $this->__('Employees');?>:</span>
            <span class="user_value"><?php echo $company->Employees;?></span>
        </div>
            <div class="hr"></div>
        <?php endif; ?>
    
        <?php if (!empty($company->CreatedTime)): ?>
        <div class="user_informations">
            <span class="user_name"><?php echo $this->__('Joined');?>:</span>
            <span class="user_value"><?php echo date(DATE_SHORT, $company->CreatedTime);?></span>
        </div>
            <div class="hr"></div>
        <?php endif; ?>
    
        <?php if ($contentparentFields['URL']['isEnabled']==1 && !empty($company->URL)): ?>
        <div class="user_informations">
            <span class="user_name"><?php echo $this->__('Website');?>:</span>
            <span class="user_value">
                <a target="_blank" href="<?php echo $company->URL;?>"><?php echo $company->URL;?></a>
            </span>
        </div>
        <?php endif; ?>
    </div>
	
	<?php
	$extrafields = MainHelper::GetExtraFieldsByOwnertype('company',$company->ID_COMPANY);
	foreach ($extrafields as $extrafield)
	{?>
		<?php $v = $extrafield['ValueText']; ?>
		<?php if (!empty($v)): ?>
			<div class="user_info_item_long clearfix">
				<span class="user_info_vr_long"><?php echo $extrafield['FieldName'];?>:</span>
				<span class="user_info_vl_long"><?php echo $v;?></span>
			</div>
		<?php endif; ?>
		<?php
	}?>

        <?php /*
	<div class="profile_buttons">
		<?php if(Auth::isUserLogged() && $isApproved==1 && !$noProfileFunctionality):?>

			<?php if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1):?>
				<?php if($company->isSubscribed()):?>

					<a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn subscribe subscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

					<a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix unsubscribe unsubscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

				<?php else: ?>

					<a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix subscribe subscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

					<a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn unsubscribe unsubscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

				<?php endif; ?>
			<?php endif; ?>

			<?php if(!$company->isLiked()):?>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix company_like like like_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>">
					<span class="text mt2"><?php echo $this->__('Like'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix dn company_unlike unlike_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>">
					<span class="text mt2"><?php echo $this->__('Unlike'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

			<?php else:?>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix dn company_like like like_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>">
					<span class="text mt2"><?php echo $this->__('Like'); ?></span>
					<span class="icon iconr_like">&nbsp;</span>
				</a>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix company_unlike unlike_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>">
					<span class="text mt2"><?php echo $this->__('Unlike'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

			<?php endif;?>

		<?php endif; ?>
	</div>  */ ?>
</div>	
<!-- Company info end -->

</div>
</div>
<?php /*
<div class="clearfix mt15 pb10 ">
	<h1><?php echo $company->CompanyName;?></h1>
	<div class="mt15 show_block pb15 clearfix">
		<div class="fl w400 oh description company_desc">
			<div class="pr20"><?php echo ContentHelper::handleContentOutput($company->CompanyDesc);?></div>
		</div>
		<div class="fr w200 db">
			<div class="company_information_block">
				<div class="fs14 fft fcb head"><span class="icon icon_info_company"><?php echo $this->__('Information');?></span></div>
				<div class="dot_bot clearfix"><span class="icon icon_news_company fl db"><?php echo $this->__('News');?></span> <span class="fr w50"><?php echo $company->NewsCount; ?></span></div>
				<div class="dot_bot clearfix"><span class="icon icon_forums_company fl db"><?php echo $this->__('Forum Posts');?></span> <span class="fr w50"><?php echo 0; ?></span></div>
				<div class="dot_bot clearfix"><span class="icon icon_members_group fl db"><?php echo $this->__('Games');?></span> <span class="fr w50"><?php echo $company->GameCount; ?></span></div>
				<div class="clearfix"><span class="icon icon_events_company fl db"><?php echo $this->__('Events');?></span> <span class="fr w50"><?php echo $company->EventCount; ?></span></div>
			</div>
		</div>
		<div class="clear"></div>
		<?php if($company->isAdmin()):?>
			<div class="clear mt10">&nbsp;</div>
			<a class="fft fs11 sprite company_edit" rel="iframe" href="<?php echo $company->COMPANY_URL.'/admin/editcompanyinfo';?>"><?php echo $this->__('Edit company info');?></a>
		<?php endif; ?>
		<div class="show_more_desc">
			<a class="fft fs11 show_oh" rel="company" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Show more');?></a>
			<a class="fft fs11 hide_oh dn" rel="company" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Hide');?></a>
		</div>
	</div>
</div>
*/ ?>