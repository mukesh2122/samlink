<?php

class Translate {

    var $params;
    var $transFilter;
    var $A2;
    var $sortType;
    var $sortDir;
    var $page;
    var $search;
    var $superadmin;
    var $langAllowed;

    public function SetParams($params0) {
        //Init params variables
        $this->params = $params0;

        $this->transFilter = (isset($this->params['transfilter']) ? $this->params['transfilter'] : 'all');
        $this->A2 = (isset($this->params['A2']) ? $this->params['A2'] : 'EN');
        $this->sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'TransText';
        $this->sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'asc';
        $this->page = isset($this->params['page']) ? $this->params['page'] : '';


        //Get seachtext from post and save in session. If not, then find it in old session.
        if (isset($_POST['search'])) {
            $this->search = $_POST['search'];
            $_SESSION['search'] = $this->search;
        } else {
            if (isset($_SESSION['search'])) {
                $this->search = $_SESSION['search'];
            } else {
                $this->search = '';
            }
        }

        //Clear searchtext if new language selected
        $oldLang = isset($_SESSION['oldLang']) ? $_SESSION['oldLang'] : "";
        if ($oldLang != $this->A2) {
            $this->search = "";
            $_SESSION['search'] = "";
        }
        $_SESSION['oldLang'] = $this->A2;

        //Superadmin?
        $player = User::getUser();
        $mygroup = Doo::conf()->userGroups[$player->ID_USERGROUP];
        $this->superadmin = in_array("*", $mygroup['allowed']);

        //Translator rights, unless superadmin
        if ($this->superadmin) {
            $this->langAllowed = array();
        } else {
            $ID_PLAYER = $player->ID_PLAYER;
            $this->langAllowed = Doo::db()->fetchall(
                    "SELECT ge_languages.ID_LANGUAGE,ge_languages.A2
				FROM sy_translators,ge_languages
				WHERE sy_translators.ID_PLAYER=$ID_PLAYER
				AND ge_languages.ID_LANGUAGE=sy_translators.ID_LANGUAGE");

            //Make language valid
            if (!$this->IsLanguageAllowed($this->A2))
                if (isset($this->langAllowed[0]))
                    $this->A2 = $this->langAllowed[0]['A2'];
        }
    }

    function IsLanguageAllowed($cmp) {
        foreach ($this->langAllowed as $la)
            if ($cmp == $la['A2'])
                return true;

        return false;
    }

    function GetLangID($A2) {
        //Get languagecodes
        $queryLang = "SELECT * FROM ge_languages WHERE A2 in ('$A2')";
        $rsLang = Doo::db()->fetchall($queryLang);
        if (isset($rsLang[0]))
            return $rsLang[0]['ID_LANGUAGE'];

        return null;
    }

    function GetEN_XXLangID($A2) {
        //Get languagecodes
        $queryLang = "SELECT * FROM ge_languages WHERE A2 in ('EN') " .
                "UNION SELECT * FROM ge_languages WHERE A2 in ('$A2')";
        $rsLang = Doo::db()->fetchall($queryLang);
        $langEN = "EN";
        $langXX = "EN";
        if (isset($rsLang[0])) {
            $langEN = $rsLang[0]['ID_LANGUAGE'];
        }
        if (isset($rsLang[1])) {
            $langXX = $rsLang[1]['ID_LANGUAGE'];
        }

        return array('EN' => $langEN, 'XX' => $langXX);
    }

    function GetFilterQuery($limit, $tab = 'Status', $order = 'asc', $A2 = NULL, $select, $transFilter) {
        $search = "";
        if (isset($this->search)) {
            $s = $this->search;
            if ($s != '' && $s != null)
                $search = " AND ge_screentexts.TransText$A2 like '%$s%' ";
        }

        //Skip non english entries if not allowed
        $testAllowEdit = ($A2 == "EN") ? "" : " AND allowEdit=1 ";

        $order = strtoupper($order);

        if ($tab == 'TransKey')
            $orderBy = "ge_screentexts.TransKey $order, ge_screentexts.TransText$A2";
        else if ($tab == 'TransText')
            $orderBy = "ge_screentexts.TransText$A2 $order, ge_screentexts.TransKey";
        else
            $orderBy = "ge_screentexts.textID $order";

        $orderBy = "ORDER BY " . $orderBy;

        if ($limit <> "") {
            $limit = "LIMIT $limit";
        } else {
            $limit = "";
        }

        $defquery = "SELECT $select " .
                "FROM ge_screentexts " .
                "WHERE ge_screentexts.TransText$A2<>'' AND ge_screentexts.TransText$A2 IS NOT NULL " .
                $search .
                $testAllowEdit .
                "$orderBy $limit";

        $query = $defquery;


        if ($transFilter == "new") {
            if ($A2 == "EN") {
                //new EN: Show texts with empty TransText
                $query = "SELECT $select " .
                        "FROM ge_screentexts " .
                        "WHERE TransText$A2='' OR TransText$A2 IS NULL " .
                        $search .
                        $testAllowEdit .
                        "$orderBy $limit";
            } else { //XX
                //new XX: Show entries that only exists in english BUT NOT in XX lang
                $langID = $this->GetEN_XXLangID($A2);

                /* $query = "SELECT $select ".
                  "FROM ge_screentexts,ge_languages ".
                  "WHERE ge_languages.A2='EN' ".
                  "AND ge_screentexts.ID_LANGUAGE = ge_languages.ID_LANGUAGE ".
                  "AND ge_screentexts.TransKey NOT IN ".
                  "(SELECT TransKey FROM ge_screentexts WHERE ID_LANGUAGE={$langID['XX']}) ".
                  "$orderBy LIMIT $limit"; */
                //Now, it only shows the english entries, since there are no empty entries on XX lang.
                //So until the table is complete for this, it now return no rows.
                $query = "SELECT $select FROM ge_screentexts,ge_languages WHERE 1=2";

                $query = "SELECT $select " .
                        "FROM ge_screentexts " .
                        "WHERE TransTextEN <>'' AND TransTextEN IS NOT NULL " .
                        "AND (TransText$A2 ='' OR TransText$A2 IS NULL) " .
                        $search .
                        $testAllowEdit .
                        "$orderBy $limit";
            }
        } else { //all
            if ($A2 == "EN") {
                //all EN: Show all entries
                $query = $defquery;
            } else { //XX
                //all XX: Show all entries that only exists in english
                $langID = $this->GetEN_XXLangID($A2);

                $query = "SELECT $select " .
                        "FROM ge_screentexts " .
                        "WHERE TransTextEN <>'' AND TransTextEN IS NOT NULL " .
                        $search .
                        $testAllowEdit .
                        "$orderBy $limit";

                //$query = "SELECT * FROM ge_screentexts WHERE ID_LANGUAGE={$langID['XX']} ".
                //"AND TransKey in (SELECT TransKey FROM ge_screentexts WHERE ID_LANGUAGE={$langID['EN']})";
            }
        }

        return $query;
    }

    /**
     * Returns selected language
     *
     * @return list
     */
    public function getAllTranslateTexts($limit, $tab = 'Status', $order = 'asc', $A2 = NULL, $transFilter) {

        /* 		$order = strtoupper($order);

          if($tab == 'TransKey')
          $orderBy = "ge_screentexts.TransKey $order, ge_screentexts.TransText";
          else if($tab == 'TransText')
          $orderBy = "ge_screentexts.TransText $order, ge_screentexts.TransKey";
          else
          $orderBy = "ge_screentexts.textID $order";


          $query = "SELECT ge_screentexts.*,ge_languages.* ".
          "FROM ge_screentexts,ge_languages ".
          "WHERE ge_languages.A2='$A2' ".
          "AND ge_screentexts.ID_LANGUAGE = ge_languages.ID_LANGUAGE ".
          "ORDER BY {$orderBy} LIMIT $limit";
         */
        $query = $this->GetFilterQuery($limit, $tab, $order, $A2, "ge_screentexts.*,TransText$A2 as TransText", $transFilter);
        $rs = Doo::db()->query($query);
        $list = $rs->fetchAll(PDO::FETCH_CLASS);

        return $list;
    }

    /**
     * Returns amount of words in wanted language
     *
     * @return int
     */
    public function getTotal($tab = 'Status', $order = 'asc', $A2 = NULL, $transFilter) {
        //Count correctly according to all/new/EN/XX filter in getAllTranslate..
        //$query0 = "SELECT COUNT(1) as cnt FROM ge_screentexts,ge_languages
        //	WHERE ge_languages.A2='$A2' AND ge_screentexts.ID_LANGUAGE = ge_languages.ID_LANGUAGE
        //	LIMIT 1";*/
        $query = $this->GetFilterQuery("1", $tab, "", $A2, "COUNT(1) as cnt", $transFilter);
        $totalNum = (object) Doo::db()->fetchRow($query);
        return $totalNum->cnt;
    }

    public function createLanguage($post) {
        if (!empty($post)) {
            $player = User::getUser();

            //Get post variables
            $A2 = $post['A2'];
            $NativeName = $post['NativeName'];
            $EnglishName = $post['EnglishName'];

            //Test if countrycode is not used before
            $query = "SELECT COUNT(*) as cnt FROM ge_languages WHERE A2='$A2'";
            $totalNum = (object) Doo::db()->fetchRow($query);
            $cnt = $totalNum->cnt;
            if ($cnt > 0) {
                return "country code exists...";
            }

            //Create the language
            $queryNew = "INSERT INTO ge_languages (A2,NativeName,EnglishName,isEnabled) VALUES " .
                    "('$A2','$NativeName','$EnglishName',1)";
            $q = Doo::db()->query($queryNew);

            //Get the ID_LANGUAGE for the new language
            $queryNew = "SELECT * FROM ge_languages WHERE A2='$A2'";
            $rs = Doo::db()->query($queryNew)->fetchall();
            $newID_LANGUAGE = $rs[0]['ID_LANGUAGE'];

            //Create texts for the new language based on the english entries
            $query = "SELECT ge_screentexts.* FROM ge_screentexts,ge_languages " .
                    "WHERE ge_screentexts.ID_LANGUAGE = ge_languages.ID_LANGUAGE " .
                    "AND ge_languages.A2='EN'";
            $rs = Doo::db()->query($query)->fetchall();
            $languages = array();
            for ($i = 0; $i < count($rs); $i++) {
                $row = $rs[$i];
                $TransKey = $row['TransKey'];
                $TransText = $row['TransText'];
                $queryNew = "INSERT INTO ge_screentexts (ID_LANGUAGE,TransKey,TransText,isChanged) VALUES " .
                        "($newID_LANGUAGE,'$TransKey','$TransText',0)";
                $q = Doo::db()->query($queryNew);
            }
            return true;
        }
        return false;
    }

    public function DeleteForeignTransTextAtID($languageFilter, $ID_TEXT) {
        if ($languageFilter == "EN") {
            $queryLang = "SELECT A2 FROM ge_languages WHERE A2<>'$languageFilter'";
            $rs = Doo::db()->query($queryLang)->fetchall();
            foreach ($rs as $lang) {
                $A2 = $lang['A2'];
                $query = "UPDATE ge_screentexts SET TransText$A2='' " .
                        "WHERE ID_TEXT=$ID_TEXT";
                $q = Doo::db()->query($query);
            }
        }
    }

    public function updateTranslateInfo($languageFilter, $translateitem, $post) {
        if (!empty($post)) {
            $player = User::getUser();
            $tmpLog = '';
            if (isset($post['TransText']) && $post['TransText'] != $translateitem['TransText' . $languageFilter]) {
                $tmpLog .= "Name changed from '" . $translateitem['TransText' . $languageFilter] . "' to '" .
                        $post['TransText'] . "'</br>";
                $translateitem['TransText' . $languageFilter] = $post['TransText'];
            }
            if ($tmpLog != '') {
                //Update the text
                $query = "UPDATE ge_screentexts SET TransText$languageFilter='" . $translateitem['TransText' . $languageFilter] .
                        "' WHERE ID_TEXT=" . $translateitem['ID_TEXT'];
                $rs = Doo::db()->query($query);

                //If english transtext is changed, then delete all the foreign transtexts at this entry
                $this->DeleteForeignTransTextAtID($languageFilter, $translateitem['ID_TEXT']);
            }

            //Only update allowEdit if english
            if ($languageFilter == "EN") {
                $allowEdit = (isset($post['allowEdit'])) ? "1" : "0";

                $query = "UPDATE ge_screentexts SET allowEdit=$allowEdit " .
                        " WHERE ID_TEXT=" . $translateitem['ID_TEXT'];
                $rs = Doo::db()->query($query);
            }


            return true;
        }
        return false;
    }

    /**
     * Returns list of languages
     *
     * @return unknown
     */
    public function getLanguages() {


        $query = "SELECT * FROM ge_languages";
        $rs = Doo::db()->query($query)->fetchall();
        $languages = array();
        for ($i = 0; $i < count($rs); $i++) {
            $row = $rs[$i];
            $ID_LANGUAGE = $row['ID_LANGUAGE'];
            $languages[$row['A2']] = $row['NativeName']/* ." (ID $ID_LANGUAGE)" */;
        }
        return $languages;
    }

    public function getLanguageObjectByID($ID_LANGUAGE) {

        $query = "SELECT * FROM ge_languages WHERE ID_LANGUAGE={$ID_LANGUAGE}";
        $rs = Doo::db()->query($query)->fetchall();
        if (isset($rs[0]))
            return $rs[0];

        return null;
    }

    public function getLanguageObjects() {

        $query = "SELECT * FROM ge_languages";
        $rs = Doo::db()->query($query)->fetchall();
        $languages = array();
        for ($i = 0; $i < count($rs); $i++) {
            $languages[] = $rs[$i];
        }
        return $languages;
    }

    public function GetGroupTypes() {
        return array("package", "menu", "producttype", "companytype", "gametype", "info");
    }

    public function ImportMissingGroupTrans($groupType) {
        $table = "";
        $tablelocales = "";
        $ID_KEY = "";
        $key = "";
        switch ($groupType) {
            case "package":
                $table = "fi_packages";
                $tablelocales = "fi_packagelocales";
                $ID_KEY = "ID_PACKAGE";
                $name = "PackageName";
                break;
            case "menu":
                $table = "sy_menu";
                $tablelocales = "sy_menulocales";
                $ID_KEY = "ID_MENU";
                $name = "MenuName";
                break;
            case "producttype":
                $table = "fi_producttypes";
                $tablelocales = "fi_producttypelocales";
                $ID_KEY = "ID_PRODUCTTYPE";
                $name = "ProductTypeName";
                break;
            case "companytype":
                $table = "sn_companytypes";
                $tablelocales = "sn_companytypelocales";
                $ID_KEY = "ID_COMPANYTYPE";
                $name = "CompanyTypeName";
                break;
            case "gametype":
                $table = "sn_gametypes";
                $tablelocales = "sn_gametypelocales";
                $ID_KEY = "ID_GAMETYPE";
                $name = "GameTypeName";
                break;
            case "prefix":
                $table = "nw_prefixes";
                $tablelocales = "nw_prefixlocales";
                $ID_KEY = "ID_PREFIX";
                $name = "PrefixName";
                break;
            case "info":
                break;
        }
        $query = "SET @ID_LANGUAGE :=(SELECT ID_LANGUAGE FROM ge_languages WHERE A2='{$this->A2}');
			INSERT INTO $tablelocales
				($ID_KEY,ID_LANGUAGE,$name)
			SELECT $ID_KEY,@ID_LANGUAGE,$name
			FROM $table
			WHERE
				(
					SELECT $tablelocales.$name
					FROM $tablelocales
					WHERE $tablelocales.$ID_KEY=$table.$ID_KEY
					AND	$tablelocales.ID_LANGUAGE=@ID_LANGUAGE
				) IS NULL";

        return Doo::db()->query($query);
    }

    public function GetGroupMissingTrans($groupType) {
        switch ($groupType) {
            case "package":
                $query = "SELECT
						NOT (
							SELECT COUNT(*) FROM fi_packagelocales
							WHERE fi_packagelocales.ID_PACKAGE = fi_packages.ID_PACKAGE
							AND fi_packagelocales.ID_LANGUAGE = (SELECT ID_LANGUAGE FROM ge_languages WHERE A2='{$this->A2}')
						) as missing,
						fi_packages.PackageName as groupName
					FROM fi_packages;";
                return Doo::db()->query($query)->fetchall();
                break;
            case "menu":
                $query = "SELECT
						NOT (
							SELECT COUNT(*) FROM sy_menulocales
							WHERE sy_menulocales.ID_MENU = sy_menu.ID_MENU
							AND sy_menulocales.ID_LANGUAGE = (SELECT ID_LANGUAGE FROM ge_languages WHERE A2='{$this->A2}')
						) as missing,
						sy_menu.MenuName as groupName
					FROM sy_menu;";
                return Doo::db()->query($query)->fetchall();
                break;
            case "producttype":
                $query = "SELECT
						NOT (
							SELECT COUNT(*) FROM fi_producttypelocales
							WHERE fi_producttypelocales.ID_PRODUCTTYPE = fi_producttypes.ID_PRODUCTTYPE
							AND fi_producttypelocales.ID_LANGUAGE = (SELECT ID_LANGUAGE FROM ge_languages WHERE A2='{$this->A2}')
						) as missing,
						fi_producttypes.ProductTypeName as groupName
					FROM fi_producttypes;";
                return Doo::db()->query($query)->fetchall();
                break;
            case "companytype":
                $query = "SELECT
						NOT (
							SELECT COUNT(*) FROM sn_companytypelocales
							WHERE sn_companytypelocales.ID_COMPANYTYPE = sn_companytypes.ID_COMPANYTYPE
							AND sn_companytypelocales.ID_LANGUAGE = (SELECT ID_LANGUAGE FROM ge_languages WHERE A2='{$this->A2}')
						) as missing,
						sn_companytypes.CompanyTypeName as groupName
					FROM sn_companytypes;";
                return Doo::db()->query($query)->fetchall();
                break;
            case "gametype":
                $query = "SELECT
						NOT (
							SELECT COUNT(*) FROM sn_gametypelocales
							WHERE sn_gametypelocales.ID_GAMETYPE = sn_gametypes.ID_GAMETYPE
							AND sn_gametypelocales.ID_LANGUAGE = (SELECT ID_LANGUAGE FROM ge_languages WHERE A2='{$this->A2}')
						) as missing,
						sn_gametypes.GameTypeName as groupName
					FROM sn_gametypes;";
                return Doo::db()->query($query)->fetchall();
                break;
             case "prefix":
                $query = "SELECT
						NOT (
							SELECT COUNT(*) FROM nw_prefixlocales
							WHERE nw_prefixlocales.ID_PREFIX = nw_prefixes.ID_PREFIX
							AND nw_prefixlocales.ID_LANGUAGE = (SELECT ID_LANGUAGE FROM ge_languages WHERE A2='{$this->A2}')
						) as missing,
						nw_prefixes.PrefixName as groupName
					FROM nw_prefixes;";
                return Doo::db()->query($query)->fetchall();
                break;
            case "info":
                $query = "SELECT 0 as missing";
                //infoTextEN as groupNameEN,
                return Doo::db()->query($query)->fetchall();
                break;
        }
        return array();
    }

    /**
     * Returns list of texts from fi_... table
     *
     * @return list
     */
    public function GetGroupTexts($groupType, $search = "") {

        $rs = Doo::db()->query("SELECT * FROM ge_languages WHERE A2='{$this->A2}'")->fetchAll();
        if (count($rs) > 0) {
            $ID_LANGUAGE = $rs[0]['ID_LANGUAGE'];
            switch ($groupType) {
                case "package":
                    $query = "SELECT fi_packagelocales.ID_PACKAGE as ID_TEXT, fi_packagelocales.ID_LANGUAGE,
						fi_packagelocales.ID_PACKAGE as ID_group,
						fi_packagelocales.PackageName as groupName,
						fi_packages.PackageName as groupNameEN
						FROM fi_packagelocales, fi_packages
						WHERE ID_LANGUAGE=$ID_LANGUAGE
						AND fi_packagelocales.PackageName Like '%$search%'
						AND fi_packagelocales.ID_PACKAGE = fi_packages.ID_PACKAGE ";
                    return Doo::db()->query($query)->fetchall();
                    break;
                case "menu":
                    $query = "SELECT sy_menulocales.ID_MENU as ID_TEXT,sy_menulocales.ID_LANGUAGE,
						sy_menulocales.ID_MENU as ID_group,
						sy_menulocales.MenuName as groupName,
						sy_menu.MenuName as groupNameEN
						FROM sy_menulocales, sy_menu
						WHERE ID_LANGUAGE=$ID_LANGUAGE
						AND sy_menulocales.MenuName Like '%$search%'
						AND sy_menulocales.ID_MENU = sy_menu.ID_MENU ";
                    return Doo::db()->query($query)->fetchall();
                    break;
                case "producttype":
                    $query = "SELECT fi_producttypelocales.ID_PRODUCTTYPE as ID_TEXT, fi_producttypelocales.ID_LANGUAGE,
						fi_producttypelocales.ID_PRODUCTTYPE as ID_group,
						fi_producttypelocales.ProductTypeName as groupName,
						fi_producttypes.ProductTypeName as groupNameEN
						FROM fi_producttypelocales, fi_producttypes
						WHERE ID_LANGUAGE=$ID_LANGUAGE
						AND fi_producttypelocales.ProductTypeName Like '%$search%'
						AND fi_producttypelocales.ID_PRODUCTTYPE = fi_producttypes.ID_PRODUCTTYPE ";
                    return Doo::db()->query($query)->fetchall();
                    break;
                case "companytype":
                    $query = "SELECT sn_companytypelocales.ID_COMPANYTYPE as ID_TEXT, sn_companytypelocales.ID_LANGUAGE,
						sn_companytypelocales.ID_COMPANYTYPE as ID_group,
						sn_companytypelocales.CompanyTypeName as groupName,
						sn_companytypes.CompanyTypeName as groupNameEN
						FROM sn_companytypelocales, sn_companytypes
						WHERE ID_LANGUAGE=$ID_LANGUAGE
						AND sn_companytypelocales.CompanyTypeName Like '%$search%'
						AND sn_companytypelocales.ID_COMPANYTYPE = sn_companytypes.ID_COMPANYTYPE ";
                    return Doo::db()->query($query)->fetchall();
                    break;
                case "gametype":
                    $query = "SELECT sn_gametypelocales.ID_GAMETYPE as ID_TEXT, sn_gametypelocales.ID_LANGUAGE,
						sn_gametypelocales.ID_GAMETYPE as ID_group,
						sn_gametypelocales.GameTypeName as groupName,
						sn_gametypes.GameTypeName as groupNameEN
						FROM sn_gametypelocales, sn_gametypes
						WHERE ID_LANGUAGE=$ID_LANGUAGE
						AND sn_gametypelocales.GameTypeName Like '%$search%'
						AND sn_gametypelocales.ID_GAMETYPE = sn_gametypes.ID_GAMETYPE ";
                    return Doo::db()->query($query)->fetchall();
                    break;
                case "info":
                    $query = "SELECT sn_info.ID_INFO as ID_TEXT, 0 as ID_LANGUAGE,
						ID_INFO as ID_group,
						infoTextEN as groupNameEN,
						infoText{$this->A2} as groupName
						FROM sn_info
						WHERE 1
						AND infoText{$this->A2} LIKE '%$search%'
						ORDER BY infoTextEN ASC";
                    return Doo::db()->query($query)->fetchall();
                    break;
                case "prefix":
                   $query = "SELECT nw_prefixlocales.ID_PREFIX as ID_TEXT, nw_prefixlocales.ID_LANGUAGE,
						nw_prefixlocales.ID_PREFIX as ID_group,
						nw_prefixlocales.PrefixName as groupName,
						nw_prefixes.PrefixName as groupNameEN
						FROM nw_prefixlocales, nw_prefixes
						WHERE ID_LANGUAGE=$ID_LANGUAGE
						AND nw_prefixlocales.PrefixName Like '%$search%'
						AND nw_prefixlocales.ID_PREFIX = nw_prefixes.ID_PREFIX ";
                    return Doo::db()->query($query)->fetchall();
                    break;
            }
        }
        return array();
    }

    public function UpdateFromTextarea($groupType, $ID_LANGUAGE, $ID_group, $groupName) {
        $query = "";

        if (strpos($groupName, "'") >= 0)
            $groupName = str_replace("'", "''", $groupName);

        switch ($groupType) {
            case "package":
                $query = "UPDATE fi_packagelocales SET PackageName='{$groupName}'
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_PACKAGE={$ID_group}";
                break;
            case "menu":
                $query = "UPDATE sy_menulocales SET MenuName='{$groupName}'
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_MENU={$ID_group}";
                break;
            case "producttype":
                $query = "UPDATE fi_producttypelocales SET ProductTypeName='{$groupName}'
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_PRODUCTTYPE={$ID_group}";
                break;
            case "companytype":
                $query = "UPDATE sn_companytypelocales SET CompanyTypeName='{$groupName}'
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_COMPANYTYPE={$ID_group}";
                break;
            case "gametype":
                $query = "UPDATE sn_gametypelocales SET GameTypeName='{$groupName}'
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_GAMETYPE={$ID_group}";
                break;
            case "prefix":
                $query = "UPDATE nw_prefixlocales SET PrefixName='{$groupName}'
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_PREFIX={$ID_group}";
                break;
            case "info":
                $query = "UPDATE sn_info SET infoText{$this->A2}='{$groupName}'
					WHERE ID_INFO={$ID_group}";
                break;
        }

        if ($query != "")
            $rs = Doo::db()->query($query);
    }

    public function UpdateReplaceGroupText($groupType, $ID_LANGUAGE, $ID_group, $KeyWord, $ChangeWord) {
        $query = "";
        switch ($groupType) {
            case "package":
                $query = "UPDATE fi_packagelocales SET PackageName = REPLACE (PackageName,'$KeyWord','$ChangeWord')
				WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_PACKAGE={$ID_group}";
                break;
            case "menu":
                $query = "UPDATE sy_menulocales SET MenuName = REPLACE (MenuName,'$KeyWord','$ChangeWord')
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_MENU={$ID_group}";
                break;
            case "producttype":
                $query = "UPDATE fi_producttypelocales SET ProductTypeName=REPLACE (ProductTypeName,'$KeyWord','$ChangeWord')
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_PRODUCTTYPE={$ID_group}";
                break;
            case "companytype":
                $query = "UPDATE sn_companytypelocales SET CompanyTypeName=REPLACE (CompanyTypeName,'$KeyWord','$ChangeWord')
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_COMPANYTYPE={$ID_group}";
                break;
            case "gametype":
                $query = "UPDATE sn_gametypelocales SET GameTypeName=REPLACE (GameTypeName,'$KeyWord','$ChangeWord')
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_GAMETYPE={$ID_group}";
                break;
             case "prefix":
                $query = "UPDATE nw_prefixlocales SET PrefixName=REPLACE (PrefixName,'$KeyWord','$ChangeWord')
					WHERE ID_LANGUAGE={$ID_LANGUAGE} AND ID_PREFIX={$ID_group}";
                break;
            case "info":
                $query = "UPDATE sn_info SET infoText{$this->A2}=REPLACE (infoText{$this->A2},'$KeyWord','$ChangeWord')
					WHERE ID_INFO={$ID_group}";
                break;
        }

        if ($query != "")
            $rs = Doo::db()->query($query);
    }

    /**
     * Returns all bug reports list, used for ajax in admin
     *
     * @return SyBugReports list
     */
    public function getSearchBugReports($phrase) {
        if (strlen($phrase) > 2) {
            $list = Doo::db()->find('SyBygReports', array(
                'limit' => 10,
                'asc' => 'ErrorName',
                'where' => 'ErrorName LIKE ?',
                'param' => array('%' . $phrase . '%')
            ));
        }

        return $list;
    }

    public function updateCache(SyBugReports $bugreport) {
        Cache::increase(CACHE_BUGREPORT . $bugreport->ID_ERROR);
    }

}
