<?php

class AdminTranslateController extends AdminController {

    /**
     * Main website
     *
     */
    public function index() {
        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $translate = new Translate();
        $translate->SetParams($this->params);
        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            //Update all entries on save button click
            foreach ($_POST as $k => $v) {
                $idstr = explode('edit', $k);
                if (count($idstr) > 1) {
                    $id = $idstr[1];

                    $query = "SELECT TransText" . $translate->A2 . " as TransText FROM ge_screentexts WHERE ID_TEXT=$id";
                    $rs = Doo::db()->query($query)->fetchall();
                    if (isset($rs[0])) {
                        $oldTT = $rs[0]['TransText'];

                        //Only update changed value!
                        if ($oldTT != $v) {
                            if (strpos($v, "'") >= 0)
                                $v = str_replace("'", "''", $v);
                            $query = "UPDATE ge_screentexts " .
                                    "SET TransText" . $translate->A2 . "='$v' " .
                                    "WHERE ID_TEXT=$id";
                            $rs = Doo::db()->query($query);

                            //If english transtext is changed, then delete all the foreign transtexts at this entry
                            $translate->DeleteForeignTransTextAtID($translate->A2, $id);
                        }
                    }
                }
            }

            /* 			//Update textfield in language list if changed.
              $editname = $_POST['editname'];
              $editid = $_POST['editid'];
              $editvalue = $_POST[$editname];

              $query = "UPDATE ge_screentexts ".
              "SET TransText".$translate->A2."='$editvalue' ".
              "WHERE ID_TEXT=$editid";
              $rs = Doo::db()->query($query);
             */
        }

        $totalLang = $translate->getTotal(
                $translate->sortType, $translate->sortDir, $translate->A2, $translate->transFilter);

        $pager = $this->appendPagination(
                $list, new stdClass(), $totalLang, MainHelper::site_url(
                        'admin/translate' . (isset($translate->A2) ? ('/' . $translate->A2) : '')
                        . (isset($translate->transFilter) ? ('/' . $translate->transFilter) : '')
                        . (isset($translate->sortType) ? ('/sort/' . $translate->sortType . '/' . $translate->sortDir) : '')
                        . '/page'), Doo::conf()->adminTranslateLimit);

        $list['totalNew'] = $translate->getTotal(
                $translate->sortType, $translate->sortDir, $translate->A2, 'new');

        $list['translateTexts'] = $translate->getAllTranslateTexts(
                $pager->limit, $translate->sortType, $translate->sortDir, $translate->A2, $translate->transFilter);

        $list['translate'] = $translate;
        $list['languages'] = $translate->getLanguages();
        $list['rightmenuselect'] = "Languages";
        $list['mainpage'] = "translate";

        $data['title'] = 'Translate';
        $data['body_class'] = 'index_translate';
        $data['selected_menu'] = 'translate';
        $data['left'] = $this->renderBlock('translate/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('translate/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('translate/index', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function edit() {
        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $translate = new Translate();
        $translate->SetParams($this->params);
        $list = array();

        if (!isset($this->params['A2'])) {
            DooUriRouter::redirect(MainHelper::site_url('admin/translate'));
        }


        //Create $translateitem manually...
        $query = "SELECT *, TransText" . $translate->A2 . " as TransText FROM ge_screentexts " .
                "WHERE ge_screentexts.ID_TEXT=" . $this->params['ID_TEXT'];
        $rs = Doo::db()->query($query)->fetchall();
        $translateitem = $rs[0];



        if (!$translateitem) {
            DooUriRouter::redirect(MainHelper::site_url('admin/translate'));
        }
        if (isset($_POST) and !empty($_POST)) {

            $translate->updateTranslateInfo($translate->A2, $translateitem, $_POST);
            DooUriRouter::redirect(
                    //MainHelper::site_url('admin/translate/'.$languageFilter));
                    MainHelper::site_url('admin/translate'
                            . (isset($translate->A2) ? ('/' . $translate->A2) : '')
                            . (isset($translate->transFilter) ? ('/' . $translate->transFilter) : '')
                            . (isset($translate->sortType) ? ('/sort/' . $translate->sortType . '/' . $translate->sortDir) : '')
                            . (($translate->page != '') ? ('/page/' . $translate->page) : '')
            ));
        }


        $list['translate'] = $translate;
        $list['translateitem'] = $translateitem;
        $list['languages'] = $translate->getLanguages();

        $list['rightmenuselect'] = "Languages";
        $list['mainpage'] = "translate";

        $data['title'] = 'Edit Text';
        $data['body_class'] = 'index_translate';
        $data['selected_menu'] = 'translate';
        $data['left'] = $this->renderBlock('translate/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('translate/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('translate/edit', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    /*
      public function newTranslate() {
      $player = User::getUser();
      if($player->canAccess('Translate') === FALSE) {
      DooUriRouter::redirect(MainHelper::site_url('admin'));
      }

      $translate = new Translate();
      $list = array();
      if(isset($_POST) and !empty($_POST)) {
      $statusNewLanguage = $translate->createLanguage($_POST);
      if ($statusNewLanguage!=true)
      {
      DooUriRouter::redirect(MainHelper::site_url('admin/translate/new'));
      }
      else
      {
      DooUriRouter::redirect(MainHelper::site_url('admin/translate'));
      }
      }

      $list['languages'] = $translate->getLanguages();
      $list['rightmenuselect'] = "NewLanguage";

      $data['title'] = 'New Language';
      $data['body_class'] = 'index_translate';
      $data['selected_menu'] = 'translate';
      $data['left'] =  $this->renderBlock('translate/common/leftColumn',$list);
      $data['right'] = $this->renderBlock('translate/common/rightColumn', $list);
      $data['content'] = $this->renderBlock('translate/new', $list);
      $data['header'] = $this->getMenu();
      $this->render3Cols($data);
      } */

    public function keycontent() {
        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $translate = new Translate();
        $translate->SetParams($this->params);
        $list = array();


        if (isset($_POST['submitmode'])) {
            //Perform replace key-content in database
            $submitmode = $_POST['submitmode'];
            if ($submitmode == "submit") {
                $KeyWord = $_POST['KeyWord'];
                $ChangeWord = $_POST['ChangeWord'];

                $TT = "TransText" . $translate->A2;

                //Replace only checked
                foreach ($_POST as $k => $v) {
                    $s = explode('TEXT', $k);
                    if (count($s) > 1) {
                        $ID_TEXT = $s[1];
                        $query = "UPDATE ge_screentexts SET $TT = REPLACE ($TT,'$KeyWord','$ChangeWord') " .
                                "WHERE ID_TEXT=$ID_TEXT";
                        //echo "$query<br/>";
                        $rs = Doo::db()->query($query);
                    }

                    $ID_LANGUAGE = $translate->GetLangID($translate->A2);

                    $groupTypes = $translate->getGroupTypes();
                    foreach ($groupTypes as $groupType) {
                        $s = explode("{$groupType}TXT", $k);
                        if (count($s) > 1) {
                            $ID_GROUP = $s[1];
                            $translate->UpdateReplaceGroupText($groupType, $ID_LANGUAGE, $ID_GROUP, $KeyWord, $ChangeWord);
                        }
                    }
                }

                //Leave submit mode!
                DooUriRouter::redirect(MainHelper::site_url('admin/translate/keycontent/lang/' . $translate->A2));
            }
        }

        $list['translate'] = $translate;
        $list['languages'] = $translate->getLanguages();

        $list['mainpage'] = "translate/keycontent/lang";
        $list['rightmenuselect'] = "KeyContent";

        $data['title'] = 'Key content';
        $data['body_class'] = 'index_translate';
        $data['selected_menu'] = 'translate';
        $data['left'] = $this->renderBlock('translate/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('translate/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('translate/keycontent', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    /**
     * Download current language as ";" separated txt file.
     *
     */
    public function dllang() {

        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $translate = new Translate();
        $translate->SetParams($this->params);

        header('Content-type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename="language' . $translate->A2 . '.txt"');

        $query = "SELECT TransKey,TransText" . $translate->A2 . " as TransText FROM ge_screentexts
			ORDER BY TransKey";
        $rs = Doo::db()->query($query)->fetchAll();
        //$list = $rs->fetchAll(PDO::FETCH_CLASS);
        for ($i = 0; $i < count($rs); $i++) {
            $row = $rs[$i];
            $TransKey = $row['TransKey'];
            $TransText = $row['TransText'];
            echo '"' . $TransKey . '";"' . $TransText . '"' . "\r\n";
        }
    }

    public function lnggroup() {
        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $translate = new Translate();
        $translate->SetParams($this->params);

        $groupType = $this->params['grouptype'];

        //Update all textareas when submit save button
        if (isset($_POST['ID_LANGUAGE'])) {
            foreach ($_POST as $k => $v) {
                $s = explode('textarea', $k);
                if (count($s) > 1) {
                    $ID_GROUP = $s[1];
                    $translate->UpdateFromTextarea($groupType, $_POST['ID_LANGUAGE'], $ID_GROUP, $v);
                }
            }

            DooUriRouter::redirect(
                    MainHelper::site_url('admin/translate/lnggroup/' . $groupType . '/lang' . (isset($translate->A2) ? ('/' . $translate->A2) : '')));
        }


        //Import missing texts
        if (isset($_POST['missingaction'])) {
            if ($_POST['missingaction'] = 'importmissing') {
                $translate->ImportMissingGroupTrans($groupType);

                DooUriRouter::redirect(
                        MainHelper::site_url('admin/translate/lnggroup/' . $groupType . '/lang' . (isset($translate->A2) ? ('/' . $translate->A2) : '')));
            }
        }





        $list = array();
        $list['translate'] = $translate;
        $list['languages'] = $translate->getLanguages();
        $list['grouptype'] = $groupType;


        $list['mainpage'] = "translate/lnggroup/$groupType/lang";
        $list['rightmenuselect'] = "LngGroup";

        $data['title'] = 'Language group';
        $data['body_class'] = 'index_translate';
        $data['selected_menu'] = 'translate';
        $data['left'] = $this->renderBlock('translate/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('translate/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('translate/lnggroup', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function languages() {
        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }




        /*
          //Show language from browser...
          //$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
          var_dump($_SERVER['HTTP_ACCEPT_LANGUAGE']);
          exit;
         */

        $translate = new Translate();
        $translate->SetParams($this->params);
        $translate->A2 = "languages";
        //Redirect to normal translate page if it is not super admin
        if (!$translate->superadmin) {
            DooUriRouter::redirect(MainHelper::site_url('admin/translate'));
        }



        //Callback from edit
        if (isset($_POST['ID_LANGUAGE'])) {
            $ID_LANGUAGE = $_POST['ID_LANGUAGE'];
            $A2 = $_POST['A2'];
            $NativeName = $_POST['NativeName'];
            $EnglishName = $_POST['EnglishName'];
            $isEnabled = (isset($_POST['isEnabled'])) ? "1" : "0";

            $query = "UPDATE ge_languages SET " .
                    "A2='$A2'," .
                    "NativeName='$NativeName'," .
                    "EnglishName='$EnglishName'," .
                    "isEnabled=$isEnabled " .
                    "WHERE ID_LANGUAGE=$ID_LANGUAGE";

            $rs = Doo::db()->query($query);

            //Clear cache
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'external/clearcache');
            //curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);

            //Avoid double submit on refresh
            DooUriRouter::redirect(MainHelper::site_url('admin/translate/languages'));
        }




        $list = array();
        $list['languages'] = $translate->getLanguages();
        $list['languageObjects'] = $translate->getLanguageObjects();
        $list['mainpage'] = "translate";
        $list['translate'] = $translate;

        $data['left'] = $this->renderBlock('translate/common/leftColumn', $list);
        $data['title'] = 'Languages';
        $data['body_class'] = 'index_languages';
        $data['selected_menu'] = 'translate/languages';
        $data['content'] = $this->renderBlock('translate/languages', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editlanguage() {
        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $translate = new Translate();
        $translate->SetParams($this->params);

        $ID_LANGUAGE = $this->params['ID'];
        $selected_language = $translate->getLanguageObjectByID($ID_LANGUAGE);





        if (!isset($this->params['ID']) || !isset($selected_language)) {
            DooUriRouter::redirect(MainHelper::site_url('admin/translate/languages'));
        }



        $list['selected_language'] = $selected_language;
        $list['mainpage'] = "editlanguage";

        $data['title'] = 'Edit language';
        $data['body_class'] = 'index_editlanguage';
        $data['selected_menu'] = 'translate';
        $data['content'] = $this->renderBlock('translate/editlanguage', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editlangadmin() {
        $player = User::getUser();
        if ($player->canAccess('Translate') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $translate = new Translate();
        $translate->SetParams($this->params);

        $ID_LANGUAGE = $this->params['ID'];
        $selected_language = $translate->getLanguageObjectByID($ID_LANGUAGE);





        if (!isset($this->params['ID']) || !isset($selected_language)) {
            DooUriRouter::redirect(MainHelper::site_url('admin/translate/languages'));
        }



        $list['selected_language'] = $selected_language;
        $list['mainpage'] = "editlangadmin";

        $data['title'] = 'Edit language administrators';
        $data['body_class'] = 'index_editlangadmin';
        $data['selected_menu'] = 'translate';
        $data['content'] = $this->renderBlock('translate/editlangadmin', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

}
