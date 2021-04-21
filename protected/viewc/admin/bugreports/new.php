<script type="text/javascript">
function getCategories(type) {
	var tmpTxt = '';
	var tmpTxt2 = '';
	var divCatDisp = 'block';
	var divSubCatDisp = 'none';
	var divCat = document.getElementById('divCategory');
	var divSubCat = document.getElementById('divSubCategory');
	var repCat = document.getElementById('reportCategory');
    var repSubCat = document.getElementById('reportSubCategory');
	
	switch(type) {
	<?php
	$counter = 0;
	foreach ($categories as $key=>$value) {
		if (is_array($value)) {
			?>
			case '<?php echo $key; ?>':
			<?php
			foreach ($value as $key2=>$value2) {
				?>
				tmpTxt = tmpTxt + '<option value="<?php echo $key2; ?>"><?php echo $value2; ?></option>';
				<?php
			}
			?>	
				tmpTxt2 = '<option value=""><?php echo $categories['']; ?></option>';
				break;
			<?php
		} else {
			?>
			case '':
				tmpTxt = '<option value=""><?php echo $categories['']; ?></option>'
				tmpTxt2 = '<option value=""><?php echo $categories['']; ?></option>';
				divCatDisp = 'none';
				break;
			<?php
		}
		$counter++;
	}
	if ($counter == count($categories)) {
		?>
		default:
			tmpTxt = tmpTxt + '<option value=""><?php echo $categories['']; ?></option>';
			tmpTxt2 = '<option value=""><?php echo $categories['']; ?></option>';
		<?php
	}
	?>
	}
	emptyElement(repCat);
	repCat.insertAdjacentHTML("beforeend", tmpTxt);
	$(repCat).dropkick('refresh');
	$(repCat).dropkick('setValue', '');
	divCat.style.display = divCatDisp;
	
	emptyElement(repSubCat);
	repSubCat.insertAdjacentHTML("beforeend", tmpTxt2);
	$(repSubCat).dropkick('refresh');
	$(repSubCat).dropkick('setValue', '');
	divSubCat.style.display = divSubCatDisp;
}

function getSubCategories(category) {
	var tmpTxt = '';
	var divSubCatDisp = 'block';
	var divSubCat = document.getElementById('divSubCategory');
    var repSubCat = document.getElementById('reportSubCategory');	
	
	switch(category) {
	<?php
	$counter2 = 0;
	foreach ($subcategories as $key=>$value) {
		if (is_array($value)) {
			?>
			case '<?php echo $key; ?>':
			<?php
			foreach ($value as $key2=>$value2) {
				?>
				tmpTxt = tmpTxt + '<option value="<?php echo $key2; ?>"><?php echo $value2; ?></option>';
				<?php
			}
			?>			
				break;
			<?php
		} else {
			?>
			case '':
				tmpTxt = '<option value=""><?php echo $subcategories['']; ?></option>';
				divSubCatDisp = 'none';
				break;
			<?php 
		}
		$counter2++;
	}
	if ($counter2 == count($subcategories)) {
		?>
		default:
			tmpTxt = '<option value=""><?php echo $subcategories['']; ?></option>';
		<?php
	}
	?>
	}
	emptyElement(repSubCat);
	repSubCat.insertAdjacentHTML("beforeend", tmpTxt);
	$(repSubCat).dropkick('refresh');
	$(repSubCat).dropkick('setValue', '');
	divSubCat.style.display = divSubCatDisp;	
}

$(document).ready(function() {
	$("#reportType").change(function() {
		var type = document.getElementById('reportType').value;
		getCategories(type);
	});
	$("#reportCategory").change(function() {
		var category = document.getElementById('reportCategory').value;
		getSubCategories(category);
	});
	$("#reportIsBug").click(function() {
		if (document.getElementById('reportIsBug').checked) {
			document.getElementById('divModule').style.display = 'block';
			document.getElementById('divStatus').style.display = 'block';
			document.getElementById('divTicketOwner').style.display = 'none';
			document.getElementById('divEscalation').style.display = 'none';
			document.getElementById('divDeveloper').style.display = 'block';
			document.getElementById('divApprover').style.display = 'block';
		} else {
			document.getElementById('divModule').style.display = 'none';
			document.getElementById('divStatus').style.display = 'none';
			document.getElementById('divTicketOwner').style.display = 'block';
			document.getElementById('divEscalation').style.display = 'block';
			document.getElementById('divDeveloper').style.display = 'none';
			document.getElementById('divApprover').style.display = 'none';
		}
	});
});
</script>

<?php
$empty_option = array(
	'value'     => '',
	'text'      => 'None/Unknown',
	'selected'	=> ''
);
$TypeOptions = array();
foreach ($types as $key=>$label) {
	$TypeOptions[] = array(
		'value'     => $key,
		'text'      => $label,
		'selected'  => ''
	);
}

$ModuleOptions = array();
foreach ($modules as $key=>$label) {
	$ModuleOptions[] = array(
		'value'     => $key,
		'text'      => $label,
		'selected'  => ''
	);
}

$CategoryOptions = array();
$CategoryOptions[''] = $empty_option;

$SubCategoryOptions = array();
$SubCategoryOptions[''] = $empty_option;

$isBugChecked = '';
$ModuleDisplay = "display: none;";
$StatusDisplay = 'display: none;';
$TicketOwnerDisplay = 'display: block;';
$EscalationDisplay = 'display: block;';
$DeveloperDisplay = 'display: none;';
$ApproverDisplay = 'display: none;';    
$CategoryDisplay = "display: none;";
$SubCategoryDisplay = "display: none;";

$ErrorStatusOptions = array();
foreach ($errorstatuses as $key=>$label) {
	$ErrorStatusOptions[] = array(
		'value'     => $key,
		'text'      => $label,
		'selected'  => ''
	);
}

$StatusOptions = array();
foreach ($statuses as $key=>$label) {
	$StatusOptions[] = array(
		'value'     => $key,
		'text'      => $label,
		'selected'  => ''
	);
}

$PriorityOptions = array();
foreach ($priorities as $key=>$label) {
	$PriorityOptions[] = array(
		'value'     => $key,
		'text'      => $label,
		'selected'  => ''
	);
}

$SupporterOptions = array();
$SupporterOptions[''] = $empty_option;
$SupporterOptions2 = array();
$SupporterOptions2[''] = $empty_option;
foreach ($supporters as $supporter) {
	$SupporterOptions[] = array(
		'value'     => $supporter->ID_PLAYER,
		'text'      => $supporter->DisplayName,
		'selected'  => ''
	);
	$SupporterOptions2[] = array(
		'value'     => $supporter->ID_PLAYER,
		'text'      => $supporter->DisplayName,
		'selected'  => ''
	);
}

$DeveloperOptions = array();
$DeveloperOptions[''] = $empty_option;
foreach ($developers as $developer) {
	$DeveloperOptions[] = array(
		'value'     => $developer->ID_PLAYER,
		'text'      => $developer->DisplayName,
		'selected'  => ''
	);
}

$ApproverOptions = array();
$ApproverOptions[''] = $empty_option;
foreach ($testers as $tester) {
	$ApproverOptions[] = array(
		'value'     => $tester->ID_PLAYER,
		'text'      => $tester->DisplayName,
		'selected'  => ''
	);
}
	
$EditorData = array(
	'ID'            => isset($bugreport->ID_ERROR)?$bugreport->ID_ERROR:null,
	'class'         => 'standard_form',
	'Post'          => MainHelper::site_url('admin/bugreports/new'),//$_SERVER['PHP_SELF'],
	'MainOBJ'       => isset($bugreport) ? $bugreport : (isset($translated) ? $translated : array()),
	'Title'         => 'Support ticket',
	'ID_PRE'         => 'bugreport',
	'Elements'      => array(
		array(
			'type'  => 'title',
			'text'  => $this->__('Support System').' - '.$this->__('Create New Ticket')
		),
		array(
			'type'  => 'text',
			'title' => $this->__('Subject'),
			'value' => '',
			'id'    => 'reportName',
			'name'  => 'report_name'
		),
		array(
			'type'  => 'checkbox',
			'title' => 'Is Bug?',
			'label' => 'Check box if it is',
			'id'    => 'reportIsBug',
			'name'  => 'report_isbug',
			'checked' =>  $isBugChecked
		),
		array(
			'type'  => 'select',
			'title' => 'Module',
			'id'    => 'reportModule',
			'divstyle'  => $ModuleDisplay,
			'divid'     => 'divModule',
			'name'  => 'report_module',
			'options'   => $ModuleOptions
		),
		array(
			'type'  => 'select',
			'title' => 'Bug status',
			'id'    => 'reportStatus',
			'divstyle'  => $StatusDisplay,
			'divid'     => 'divStatus',
			'name'  => 'report_status',
			'options'   => $StatusOptions
		),
		array(
			'type'  => 'select',
			'title' => 'Developer',
			'id'    => 'reportDeveloper',
			'name'  => 'report_developer',
			'divstyle'  => $DeveloperDisplay,
			'divid'     => 'divDeveloper',
			'options'   => $DeveloperOptions
		),
		array(
			'type'  => 'list',
			'title' => 'Testers',
			'id'    => 'reportApprover',
			'name'  => 'report_approver[]',
			'divstyle'  => $ApproverDisplay,
			'divid'     => 'divApprover',
			'options'   => $ApproverOptions
		),
		array(
			'type'  => 'select',
			'title' => $this->__('Type'),
			'id'    => 'reportType',
			'name'  => 'report_type',
			'options'   => $TypeOptions
		),
		array(
			'type'  => 'select',
			'title' => $this->__('Category'),
			'id'    => 'reportCategory',
			'divstyle'  => $CategoryDisplay,
			'divid'     => 'divCategory',
			'name'  => 'report_category',
			'options'   => $CategoryOptions
		),
		array(
			'type'  => 'select',
			'title' => $this->__('Sub-category'),
			'id'    => 'reportSubCategory',
			'divstyle'  => $SubCategoryDisplay,
			'divid'     => 'divSubCategory',
			'name'  => 'report_subcategory',
			'options'   => $SubCategoryOptions
		),
		array(
			'type'  => 'select',
			'title' => 'Status',
			'id'    => 'reportErrorStatus',
			'name'  => 'report_errorstatus',
			'options'   => $ErrorStatusOptions
		),
		array(
			'type'  => 'select',
			'title' => $this->__('Priority'),
			'id'    => 'reportPriority',
			'name'  => 'report_priority',
			'options'   => $PriorityOptions
		),
		array(
			'type'  => 'select',
			'title' => 'Ticket Owner',
			'id'    => 'reportTicketOwner',
			'name'  => 'report_ticketowner',
			'divstyle'  => $TicketOwnerDisplay,
			'divid'     => 'divTicketOwner',
			'options'   => $SupporterOptions
		),
		array(
			'type'  => 'select',
			'title' => 'Reassignment',
			'id'    => 'reportEscalation',
			'name'  => 'report_escalation',
			'divstyle'  => $EscalationDisplay,
			'divid'     => 'divEscalation',
			'options'   => $SupporterOptions2
		),
		array(
			'type'      => 'textfield',
			'id'        => 'report_errorlog',
            'name'		=> 'report_errorlog',
			'text'      => $this->__('Description'),
			'value'     => '',
			'maxlen'   => '2000',
			'toolbar'   => 'light'
		)
	)
);

ContentHelper::ParseEditorData($EditorData);