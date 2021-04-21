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
		'selected'  => ''
	);
}

$CategoryOptions = array();
$CategoryOptions[''] = array(
	'value'     => '',
	'text'      => $categories[''],
	'selected'	=> ''
);

$SubCategoryOptions = array();
$SubCategoryOptions[''] = array(
	'value'     => '',
	'text'      => $subcategories[''],
	'selected'	=> ''
);
    
$CategoryDisplay = "display: none;";
$SubCategoryDisplay = "display: none;";
	
$EditorData = array(
	'ID'            => isset($feedbackreport->ID_ERROR)?$feedbackreport->ID_ERROR:null,
	'class'         => 'standard_form',
	'Post'          => MainHelper::site_url('players/feedback/new'),//$_SERVER['PHP_SELF'],
	'MainOBJ'       => isset($feedbackreport) ? $feedbackreport : (isset($translated) ? $translated : array()),
	'Title'         => $this->__('Support ticket'),
	'ID_PRE'         => 'feedbackreport',
	'Elements'      => array(
		array(
			'type'  => 'titleex',
			'info' => '<img src="'.MainHelper::site_url('global/img/icon-feedback-ima.64x32.png').'"/>'.$this->__('You can always update your ticket with new information'),
			'text'  => $this->__('Create new support ticket')
		),
		array(
			'type'  => 'text',
			'title' => $this->__('Subject'),
			'value'     => '',
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
			'type'      => 'textfield',
			'id'        => 'report_log',
            'name'		=> 'report_log',
			'text'      => $this->__('Description'),
			'value'     => '',
			'maxlen'   => '2000',
			'toolbar'   => 'light'
		),
	)
);

ContentHelper::ParseEditorData($EditorData);