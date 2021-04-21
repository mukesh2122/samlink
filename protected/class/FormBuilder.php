<?php
	Class FormOption {
		public $Value;
		public $Text;
		public $Selected;
		public $Id			= null;
		public $Action		= null;
		
                /**
                 * 
                 * @param String $Value
                 * @param String $Text
                 * @param Boolean $Selected
                 */
		public function __construct($Value = '', $Text = '', $Selected = false) {
			$this->Value 	= $Value;
			$this->Text 	= $Text;
			$this->Selected = $Selected;
		}
		
		public function Get() {
			$result = array(
				'value'		=> $this->Value,
				'text'		=> $this->Text,
				'selected'	=> $this->Selected
			);
			// Optional values
			if (!is_null($this->Id)) {
				$result['id'] = $this->Id;
			}
			if (!is_null($this->Action)) {
				$result['action'] = $this->Action;
			}
			return $result;			
		}
		
		/**
		 * @param Mixed 	$SourceObject 	The object that contains the options.
		 * @param String	$ValueKey		The object key that accesses the value-part of the html option.
		 * @param String	$TextKey		The object key that accesses the text-part of the html option.
		 * @param String	$SelectedKey	The object key that we need to check to know if it's selected.
		 * @param Mixed		$SelectedValue	This can either be a single value (with a check if it's == $SourceObject->$SelectedKey) \
		 * 									Or it can be an array (where the check is in_array($SourceObject->$SelectedKey, $SelectedValue))
		 * @return Array of options
		 */
		public static function CreateFromObject($SourceObject, $ValueKey, $TextKey, $SelectedKey, $SelectedValue) {
			$result = array();
			foreach ($SourceObject as $Option) {
				if (is_array($SelectedValue)) {
					$result[] = new FormOption($Option->$ValueKey, $Option->$TextKey, in_array($Option->$SelectedKey, $SelectedValue));
				} else {
					$result[] = new FormOption($Option->$ValueKey, $Option->$TextKey, $Option->$SelectedKey == $SelectedValue);
				}				
			}
			return $result;
		}
	}

	/**
	 * This class is a wrapper for the ContentHelpers ParseEditorData
	 * Goal of it is to provide easy overview (with a PHPDoc compatible IDE).
	 * No misspells of keys or having to remember everything.
	 * 
	 * @author Thomas Hartvig <ungamed.th@gmail.com>
	 */
	Class FormBuilder {
		public $EditorData;
                private $Hidden      = null;
		
		/**
		 * @param String $PostURL	The url to post to.
		 * @param String $Classes	An array of class names to add to the form element (optional).
		 * @param String $FormId 	The HTML ID of the form (optional).
		 */
		public function __construct($PostURL = '#', $Classes = null, $FormId = null) {
			$this->EditorData = array();
			$this->ImplicitAdd('Post', $PostURL);
			if (!is_null($Classes)) $this->Add('class', implode(' ', $Classes));
			if (!is_null($FormId)) $this->Add('formid', $FormId);
			$this->ImplicitAdd('Elements', array());
		}
		
                /**
                 * Adds all the picture support with crop function.
                 * 
                 * @param String $Title         eg. 'Group'
                 * @param String $OwnerType     eg. 'group'
                 * @param Object $MainObj       eg. $group
                 * @param String $Owner         eg. $group->ID_GROUP
                 */
		public function AddPicture($Title, $OwnerType, $MainObj, $Owner) {
			$this->ImplicitAdd('Title', $Title);
			$this->ImplicitAdd('ID_PRE', $OwnerType);
			$this->ImplicitAdd('MainOBJ', $MainObj);
			$this->ImplicitAdd('ID', $Owner);
			$this->AddElement('picture');
		}
		
		private function ExtendOnNotNull(&$Arr, $Key, $Value) {
			if (!is_null($Value)) {
				$Arr[$Key] = $Value;
			}
		}

		/**
		 * 	@param String 	$Text		 Sets the text/title/label for the element.
		 * 	@param String 	$Info		Used add extra info (optional)
		 */
		public function AddTitle($Text, $Info = null) {
			if (is_null($Info)) {
				$this->AddElement('title', array(
					'text'	=> $Text
				));				
			} else {
				$this->AddElement('titleex', array(
					'text'	=> $Text,
					'info'	=> $Info
				));
			}
		}

		/**
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Id			Sets the html id.
		 *	@param Boolean	$Checked	(attr: checked)
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 * 	@param String 	$Name		Sets the name of the input element (if left out the ID is used)
		 * 	@param String 	$Label		Sets the label of the element.
		 */
		public function AddCheckbox($Title, $Id, $Checked, $Tooltip = null, $Name = null, $Label = null) {
			$this->AddElement('checkbox', array(
				'title'		=> $Title,
				'id' 		=> $Id,
				'checked' 	=> $Checked,
				'tooltip' 	=> $Tooltip,
				'name'		=> $Name,
				'label'		=> $Label
			));
		}

		/**
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param Array 	$Options	An associative array of options (Use the helper class: FormOption to create it)
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 */
		public function AddCustomCheckboxes($Title, $Options, $Tooltip = null) {
			$this->AddElement('customboxes', array(
				'title'		=> $Title,
				'options' 	=> $Options,
				'tooltip' 	=> $Tooltip
			));
		}

		/**
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Id			Sets the html id.
		 * 	@param Array 	$Options	An associative array of options (Use the helper class: FormOption to create it)
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 */
		public function AddCheckboxes($Title, $Id, $Options, $Tooltip = null) {
			$this->AddElement('checkboxes', array(
				'title'		=> $Title,
				'id' 		=> $Id,
				'options' 	=> $Options,
				'tooltip' 	=> $Tooltip
			));
		}

		/**
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Info		Used add extra info (optional)
		 */
		public function AddInfo($Value, $Info = null) {
			$this->AddElement('info', array(
				'value'		=> $Value,
				'info' 		=> $Info
			));
		}

		/**		
		 * 	@param String 	$Id			Sets the html id.
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 * 	@param String 	$Class		 Adds a class (or more seperated by a space) (optional)
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Name		Sets the name of the input element (if left out the ID is used)
		 */
		public function AddTextInput($Id, $Title, $Tooltip = null, $Class = null, $Value = null, $Name = null) {
			$this->AddElement('text', array(
				'id'		=> $Id,
				'title'		=> $Title,
				'tooltip'	=> $Tooltip,
				'class'		=> $Class,
				'value'		=> $Value,
				'name' 		=> $Name
			));
		}


		/**		
		 * 	@param String 	$Id			Sets the html id.
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 * 	@param String 	$Class		 Adds a class (or more seperated by a space) (optional)
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Name		Sets the name of the input element (if left out the ID is used)
		 */
		public function AddPasswordInput($Id, $Title, $Tooltip = null, $Class = null, $Value = null, $Name = null) {
			$this->AddElement('password', array(
				'id'		=> $Id,
				'title'		=> $Title,
				'tooltip'	=> $Tooltip,
				'class'		=> $Class,
				'value'		=> $Value,
				'name' 		=> $Name
			));
		}
                
                /**
                 * Creates a input element of type "hidden".
                 * 
                 * @param String $Name      Name (and id) of the hidden element
                 * @param String $Value     Value of the hidden element.
                 */
                public function AddHidden($Name, $Value='') {
                    if (is_null($this->Hidden)) {
                        $this->Hidden = array();
                    }
                    $this->Hidden[] = array($Name, $Value);
                }

		/**
		 * 	@param String 	$Id			Sets the html id.
		 * 	@param String 	$Text		 Sets the text/title/label for the element.
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 */
		public function AddTextfield($Id, $Text, $Value, $Tooltip = null) {
			$this->AddElement('textfield', array(
				'id'		=> $Id,
				'text'		=> $Text,
				'value'		=> $Value,
				'tooltip' 	=> $Tooltip
			));
		}

		/**
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Link		(attr: link)
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Rel		Used to identify the javascript function executed. (fx. rel='iframe' will do a ajax call)
		 * 	@param String 	$Class		 Adds a class (or more seperated by a space) (optional)
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 */
		public function AddLabeledLink($Title, $Link, $Value, $Rel = null, $Class = null, $Tooltip = null) {
			$this->AddElement('linklabel', array(
				'title'		=> $Title,
				'link'		=> $Link,
				'value'		=> $Value,
				'rel'		=> $Rel,
				'class'		=> $Class,
				'tooltip' 	=> $Tooltip
			));
		}
		/**
		 * Adds a textfield for a description
		 * 
		 * @param String $Id 		The Id of the html element (and the name if non is given).
		 * @param String $Title 	The label/title that will be shown to the user.
		 * @param String $Name	The name attribute of the input element.
		 * @param String $Value	The default value (defaults to an empty string).
		 * @param String $Tooltip	A hint for the user (Recommended to use).
		 */
		public function AddDescription($Id, $Title, $Name = null, $Value = null, $Tooltip = null) {
			$this->AddElement('desc', array(
				'id'		=> $Id,
				'title'		=> $Title,
				'name'		=> $Name,
				'value'		=> $Value,
				'tooltip'	=> $Tooltip
			));
		}
		
		/**
		 * 	@param String 	$Id			Sets the html id.
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Prefix		Sets the name prefix of the selector elements eg. on the month selector name="prefixmonth".
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 */
		public function AddDateInput($Id, $Title, $Prefix, $Value, $Tooltip = null) {
			$this->AddElement('date', array(
				'id'		=> $Id,
				'title'		=> $Title,
				'prefix'	=> $Prefix,
				'value'		=> $Value,
				'tooltip'	=> $Tooltip
			));
		}
		
		/**
		 * 	@param String 	$Id			Sets the html id.
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param Array 	$Options	An associative array of options (Use the helper class: FormOption to create it)
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 * 	@param String 	$Name		Sets the name of the input element (if left out the ID is used)
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Text		 Sets the text/title/label for the element.
		 */
		public function AddSelectInput($Id, $Title, $Options, $Tooltip = null, $Name = null, $Value = null, $Text = null) {
			$this->AddElement('select', array(
				'id'		=> $Id,
				'title'		=> $Title,
				'options'	=> $Options,
				'tooltip'	=> $Tooltip,
				'name'		=> $Name,
				'value'		=> $Value,
				'text'		=> $Text
			));
		}

		/**
		 * 	@param String 	$Text		 Sets the text/title/label for the element.
		 * 	@param String 	$Class		 Adds a class (or more seperated by a space) (optional)
		 */
		public function AddJSLink($Text, $Class = null) {
			$this->AddElement('jslink', array(
				'text'	=> $Text,
				'class'	=> $Class
			));
		}
		/**
		 * 
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Text		 Sets the text/title/label for the element.
		 * 	@param String 	$Class		 Adds a class (or more seperated by a space) (optional)
		 * 	@param String 	$Rel		Used to identify the javascript function executed. (fx. rel='iframe' will do a ajax call)
		 */
		public function AddJSLinkLabel($Title, $Text, $Class = null, $Rel = null) {
			$this->AddElement('labellink', array(
				'title'	=> $Title,
				'text'	=> $Text,
				'class'	=> $Class,
				'rel'	=> $Rel
			));
		}
		
		/**
		 * 	@param String 	$Text		Sets the text/title/label for the element.
		 * 	@param String 	$Info		Used add extra info (optional)
		 * 	@param String 	$Class		Adds a class (or more seperated by a space) (optional)
		 * 	@param String 	$Title		Used to set the overall title of the element.
		 * 	@param String 	$Rel		Used to identify the javascript function executed. (fx. rel='iframe' will do a ajax call)
		 * 	@param String 	$Tooltip	Creates a hint (optional)
		 * 	@param Array 	$Options	An associative array of options (Use the helper class: FormOption to create it)
		 * 	@param String 	$Label		Sets the label of the element.
		 * 	@param String 	$Value		Sets the default value of the HTML element.
		 * 	@param String 	$Id			Sets the html id.
		 * 	@param String 	$Name		Sets the name of the input element (if left out the ID is used)
		 * 	@param String 	$Prefix		Sets the name prefix of the selector elements eg. on the month selector name="prefixmonth". (only for date selector)
		 * 	@param String 	$Error		(attr: error)
		 */
		 
		 
		/**
		 * Internal function used to exclude null-value options, and add the options (the last step).
		 *
		 * @param String $Type The type of the element.
		 * @param Array $options Associative array that defines the behavior of the element 
		 */
		private function AddElement($Type, $options = array()) {
			$Element = array('type' => $Type);
			foreach ($options as $key => $value) {
				$this->ExtendOnNotNull($Element, $key, $value);
			}
			array_push($this->EditorData['Elements'], $Element);
		}
		
		/*
		 * This function adds unchecked data, only use if you know what your doing.
		 * (But rather than using this better implement your use into the class).
		 */
		public function ImplicitAdd($Key, $Value) {
			$this->EditorData[$Key] = $Value;
		}
		
		/**
		 * Shows (outputs) the generated form.
		 */
		public function Show() {
                    if (!is_null($this->Hidden) && is_array($this->Hidden)) {
                        $this->EditorData['Elements'][] = array(
                            'type'      => 'hidden',
                            'values'    => $this->Hidden
                        );
                        
                    }
                    ContentHelper::ParseEditorData($this->EditorData);
		}
	}
?>