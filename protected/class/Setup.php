<?php

class Setup {


	public function GetModules()
	{
		$query = "SELECT t1.*,t2.isEnabled as depend_isEnabled
                  FROM sy_modules as t1
                  LEFT JOIN sy_modules as t2
                  ON t1.dependID=t2.ID_MODULE
                  ORDER BY t1.dependID,t2.ID_MODULE";
		$rs = Doo::db()->query($query)->fetchall();

		//Add functions to modules
		//Add fields to modules
		$n = count($rs);
		for ($i=0;$i<$n;$i++)
		{
			$ID_MODULE = $rs[$i]['ID_MODULE'];
			$rs[$i]['functions'] = $this->GetFunctions($ID_MODULE);
			$rs[$i]['fields'] = $this->GetFields($ID_MODULE);
			$rs[$i]['extrafields'] = $this->GetExtraFields($ID_MODULE);
			$rs[$i]['categories'] = $this->GetCategories($ID_MODULE);
			$rs[$i]['settings'] = $this->GetSettings($ID_MODULE);
			$rs[$i]['availability'] = $this->GetAvailability($ID_MODULE);
		}
			
		return $rs;	
	}
	
	public function GetModule($ID_MODULE)
	{
		$query = "SELECT t1.*,t2.isEnabled as depend_isEnabled FROM sy_modules as t1
			LEFT JOIN sy_modules as t2
			ON t1.dependID=t2.ID_MODULE 
			WHERE t1.ID_MODULE=$ID_MODULE";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
		{
			//Functions and fields
			$ID_MODULE = $rs[0]['ID_MODULE'];
			$rs[0]['functions'] = $this->GetFunctions($ID_MODULE);
			$rs[0]['fields'] = $this->GetFields($ID_MODULE);
			$rs[0]['extrafields'] = $this->GetExtraFields($ID_MODULE);
			$rs[0]['categories'] = $this->GetCategories($ID_MODULE);
			$rs[0]['settings'] = $this->GetSettings($ID_MODULE);
			$rs[0]['availability'] = $this->GetAvailability($ID_MODULE);

			return $rs[0];
		}
		return array();	
	}
	
	public function GetFunctions($ID_MODULE)
	{
		$query = "SELECT s1.* ,s2.isEnabled as df_enabledID, s3.isEnabled as dm_enabledID 
			FROM sy_modulefunctions as s1
			LEFT JOIN sy_modulefunctions as s2
			ON s1.dependFunctionID = s2.ID_MODFUNC
			LEFT JOIN sy_modules as s3
			ON s1.dependModuleID = s3.ID_MODULE 
			WHERE s1.ID_MODULE=$ID_MODULE";

		$rs = Doo::db()->query($query)->fetchall();
		return $rs;	
	}

	public function GetFields($ID_MODULE)
	{
		$query = "SELECT * FROm sy_fields WHERE ID_MODULE=$ID_MODULE";

		$rs = Doo::db()->query($query)->fetchall();
		return $rs;	
	}
	
	public function SetPublish($ID_MODULE, $isEnabled)
	{
		//Set isPublished module
		$isPublished = $isEnabled;
		$query = "UPDATE sy_menu,sy_menu_modules SET sy_menu.isPublished=$isPublished 
			WHERE sy_menu.ID_MENU = sy_menu_modules.ID_MENU 
			AND	sy_menu_modules.ID_MODULE=$ID_MODULE";
		$rs = Doo::db()->query($query);
	}
	
	public function UpdateFunctions($ID_MODULE)
	{
		//Update functions
		$functions = $this->GetFunctions($ID_MODULE);
		foreach($functions as $function)
		{
			$isEnabled = 0;
			$ID_MODFUNC = $function['ID_MODFUNC'];
			foreach ($_POST as $k=>$v)
				if ($k == "modfunc$ID_MODFUNC")
					$isEnabled = 1;

			$rs = Doo::db()->query("UPDATE sy_modulefunctions SET isEnabled=$isEnabled WHERE ID_MODFUNC=$ID_MODFUNC");
		}
	}
				
	public function UpdateFields($ID_MODULE)
	{
		//Update functions
		$fields = $this->GetFields($ID_MODULE);
		foreach($fields as $field)
		{
			$isEnabled = 0;
			$isRequired = 0;
			$ID_FIELD = $field['ID_FIELD'];
			foreach ($_POST as $k=>$v)
			{
				if ($k == "fieldenabled$ID_FIELD")
					$isEnabled = 1;
				if ($k == "fieldrequired$ID_FIELD")
					$isRequired = 1;
			}
			$rule = ($isRequired==1) ? 'true' : 'false';

			$query = "UPDATE sy_fields 
				SET isEnabled=$isEnabled, isRequired=$isRequired,
				rule = REPLACE(REPLACE(rule,'true','false'),'false','$rule') 
				WHERE ID_FIELD=$ID_FIELD";

			$rs = Doo::db()->query($query);
		}
	}
	
	public function UpdateModuleDependencies()
	{
		//Update dependencies
		$modules = $this->GetModules();
		foreach ($modules as $module)
		{
			$ID_MODULE = $module['ID_MODULE'];
			$isEnabled = $module['isEnabled'];
			if ($module['dependID']!="0" && $module['depend_isEnabled']!="1")
				$isEnabled = 0;
			$query = "UPDATE sy_modules SET isEnabled=$isEnabled WHERE ID_MODULE=$ID_MODULE";
			$rs = Doo::db()->query($query);

			$this->SetPublish($ID_MODULE, $isEnabled);			

			//Functions
			$functions = $this->GetFunctions($ID_MODULE);
			foreach ($functions as $function)
			{
				$ID_MODFUNC = $function['ID_MODFUNC'];
				$isEnabled = $function['isEnabled'];
				//Update functions depending on other module
				if ($function['dependModuleID']!="0" && $function['dm_enabledID']!="1")
					$isEnabled = 0;

				//Update functions depending on other function
				if ($function['dependFunctionID']!="0" && $function['df_enabledID']!="1")
					$isEnabled = 0;

				$query = "UPDATE sy_modulefunctions SET isEnabled=$isEnabled WHERE ID_MODFUNC=$ID_MODFUNC";
				$rs = Doo::db()->query($query);
			
			}
			
		}
	}

	
	public function GetExtraFields($ID_MODULE)
	{
		//Get extra fields for this ownertype
		$query = "SELECT sn_entityextras.*  
			FROM sy_modules,sn_entityextras 
			WHERE sy_modules.OwnerType = sn_entityextras.OwnerType
			AND sy_modules.ID_MODULE=$ID_MODULE 
			ORDER BY sn_entityextras.Priority";
		$rs = Doo::db()->query($query)->fetchall();
		return $rs;	
	}

	public function GetExtraField($ID_FIELD)
	{
		//Get specific extra field
		$query = "SELECT * FROM sn_entityextras WHERE ID_FIELD=$ID_FIELD";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			return $rs[0];

		return array();	
	}
	
	public function AddExtraField($OwnerType,$FieldName,$FieldType,$Priority)
	{
		//Insert new extra field
		$query = "INSERT INTO sn_entityextras (OwnerType,FieldName,FieldType,Priority) VALUES ('$OwnerType','$FieldName','$FieldType',$Priority)";
		$rs = Doo::db()->query($query);
	}
	
	public function DeleteExtraField($ID_FIELD)
	{
		//Delete extra field and its _rel data
		$tablename = "sn_playersextra_rel";
		$query = "DELETE FROM sn_entityextras WHERE ID_FIELD=$ID_FIELD;
			DELETE FROM $tablename WHERE ID_FIELD=$ID_FIELD";
		$rs = Doo::db()->query($query);
	}

	public function UpdateExtraField($ID_FIELD,$FieldName,$FieldType,$Priority)
	{
		//Update extrafield
		$query = "UPDATE sn_entityextras SET FieldName='$FieldName',FieldType='$FieldType',Priority=$Priority WHERE ID_FIELD=$ID_FIELD";
		$rs = Doo::db()->query($query);
	}

	public function GetCategories($ID_MODULE)
	{
		//Get categories for module
		$query = "SELECT sy_categories.*  
			FROM sy_modules,sy_categories 
			WHERE sy_modules.OwnerType = sy_categories.OwnerType
			AND sy_modules.ID_MODULE=$ID_MODULE";
		$rs = Doo::db()->query($query)->fetchall();
		return $rs;	
	}
	
	public function GetCategory($ID_CATEGORY)
	{
		//Get categories for module
		$query = "SELECT * FROM sy_categories WHERE ID_CATEGORY=$ID_CATEGORY";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			return $rs[0];

		return array();	
	}

	public function AddCategory($OwnerType,$CategoryName,$MBA_enabled)
	{
		//Insert new category
		$query = "INSERT INTO sy_categories (OwnerType,CategoryName,MBA_enabled) VALUES ('$OwnerType','$CategoryName','$MBA_enabled')";
		$rs = Doo::db()->query($query);
	}

	public function DeleteCategory($ID_CATEGORY)
	{
		//Delete category and its _rel data
		$tablename = "sn_playercategory_rel";
		$query = "DELETE FROM sy_categories WHERE ID_CATEGORY=$ID_CATEGORY;
			DELETE FROM $tablename WHERE ID_CATEGORY=$ID_CATEGORY";
		$rs = Doo::db()->query($query);
	}

	public function UpdateCategory($ID_CATEGORY,$CategoryName,$MBA_enabled)
	{
		//Update category
		$query = "UPDATE sy_categories SET CategoryName='$CategoryName',MBA_enabled='$MBA_enabled' WHERE ID_CATEGORY=$ID_CATEGORY";
		$rs = Doo::db()->query($query);
	}

	public function GetSettings($ID_MODULE)
	{
		//Get settings for module
		$query = "
			SELECT
				sy_settings.*,
				sy_modulesettings_rel.SettingType,
				sy_modulesettings_rel.DataSource
			FROM
				sy_modulesettings_rel
			RIGHT JOIN
				sy_settings
			ON
				sy_modulesettings_rel.ID_SETTING = sy_settings.ID_SETTING
			WHERE
				sy_modulesettings_rel.ID_MODULE = $ID_MODULE";
		$rs = Doo::db()->query($query)->fetchall();
		return $rs;	
	}

	public function UpdateSettings($ID_MODULE)
	{
		//Update settings
		$settings = $this->GetSettings($ID_MODULE);
		foreach($settings as $setting)
		{
			$ID_SETTING = $setting['ID_SETTING'];
			foreach ($_POST as $k=>$v)
				if ($k == "settings_$ID_SETTING")
					$value = $v;

			$SettingType = $setting['SettingType'];
			$query = "UPDATE sy_settings SET $SettingType='$value' WHERE ID_SETTING='$ID_SETTING'";
			$rs = Doo::db()->query($query);
		}
	}		

	public function GetAvailability($ID_MODULE)
	{
		$query = "SELECT * FROM sy_moduleoff WHERE ID_MODULE=$ID_MODULE";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			return $rs[0];

		return array();		
	}

	public function UpdateAvailability($ID_MODULE)
	{
		//Update availability
		$availability = $this->GetAvailability($ID_MODULE);
		if (!empty($availability))
		{
			$NotAvailable = isset($_POST['na_notavailable']) ? 1 : 0;
			$Message = $_POST['na_message'];
			$rs = Doo::db()->query("UPDATE sy_moduleoff 
				SET NotAvailable=$NotAvailable, Message='$Message' 
				WHERE ID_MODULE=$ID_MODULE");
		}

	}
	
}

