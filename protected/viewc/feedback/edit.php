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
});
</script>

<?php
$TypeOptions = array();
foreach ($types as $key=>$label) {
	$TypeOptions[] = array(
		'value'     => $key,
		'text'      => $label,
		'selected'  => ((isset($feedbackreport->ReportType) && $key == $feedbackreport->ReportType))
	);
}

if (isset($categories[$feedbackreport->ReportType]) && $feedbackreport->ReportType != '') {
	$CategoryOptions = array();
	foreach ($categories[$feedbackreport->ReportType] as $key=>$label) {
		$CategoryOptions[] = array(
			'value'     => $key,
			'text'      => $label,
			'selected'  =>((isset($feedbackreport->Category) && $key == $feedbackreport->Category))
		);
	}
} else {
	$CategoryOptions = array();
	$CategoryOptions[''] = array(
		'value'     => '',
		'text'      => $categories[''],
		'selected'	=> ''
	);
}

if (isset($subcategories[$feedbackreport->Category]) && $feedbackreport->Category != '') {
	$SubCategoryOptions = array();
	foreach ($subcategories[$feedbackreport->Category] as $key=>$label) {
		$SubCategoryOptions[] = array(
			'value'     => $key,
			'text'      => $label,
			'selected'  =>((isset($feedbackreport->SubCategory) && $key == $feedbackreport->SubCategory))
		);
	}
} else {
	$SubCategoryOptions = array();
	$SubCategoryOptions[''] = array(
		'value'     => '',
		'text'      => $subcategories[''],
		'selected'	=> ''
	);
}
    
if($feedbackreport->ReportType == '') {
	$CategoryDisplay = "display: none;";
	$SubCategoryDisplay = "display: none;";
} else {
	$CategoryDisplay = 'display: block;';
	if($feedbackreport->Category == '') {
		$SubCategoryDisplay = "display: none;";
	} else {
		$SubCategoryDisplay = 'display: block;';
	}
}
	
$EditorData = array(
	'ID'            => isset($feedbackreport->ID_ERROR)?$feedbackreport->ID_ERROR:null,
	'class'         => 'standard_form',
	'Post'          => MainHelper::site_url('players/feedback/edit/' . $feedbackreport->ID_ERROR),//$_SERVER['PHP_SELF'],
	'MainOBJ'       => isset($feedbackreport) ? $feedbackreport : (isset($translated) ? $translated : array()),
	'Title'         => $this->__('Support ticket'),
	'ID_PRE'         => 'feedbackreport',
	'Elements'      => array(
		array( // all the hidden values
			'type'      => 'hidden',
			'values'    => array (
				array('error_id', (isset($feedbackreport) ? $feedbackreport->ID_ERROR : 0))
			)
		),
		array(
			'type'  => 'titleex',
			'info' => '<img src="'.MainHelper::site_url('global/img/icon-feedback-ima.64x32.png').'"/>'.$this->__('You can always update your ticket with new information'),
			'text'  => $this->__('Update support ticket')
		),
		array(
			'type'  => 'text',
			'title' => $this->__('Subject'),
			'value' => $feedbackreport->ErrorName,
			'id'    => 'reportName',
			'name'  => 'report_name'
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
			'type'      => 'screenshot',
			'title'		=> $this->__('Upload screenshot'),
			'info' 		=> $this->__('Only one image per support ticket'),
			'table'		=> 'SyBugReports',
			'name'    	=> 'ID_ERROR',
			'link'    	=> 'players/feedback/edit/',
			'show'      => "show"
		),
		array(
			'type'      => 'textfield',
			'id'        => 'report_log',
            'name'		=> 'report_log',
			'text'      => $this->__('Additional description'),
			'value'     => '',
			'maxlen'   => '2000',
			'toolbar'   => 'light'
		),
		array(
			'type'      => 'info',
			'value'     => $this->__('Communication Log'),
			'info'     => $feedbackreport->ErrorLog
		)
	)
);

ContentHelper::ParseEditorData($EditorData);