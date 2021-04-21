<?php
class TranslateController extends SnController {

    public function beforeRun($resource, $action) {
        parent::beforeRun($resource, $action);
    }

    private function composeGameObj($id) {
        $game = Games::getGameByID($id);
        $return = array(
            "Name"  => $game->GameName,
            "Desc"  => $game->GameDesc,
        );
        return $return;
    }

    private function composeGroupObj($id) {
        $group = Groups::getGroupByID($id);
        $return = array(
            "Name"  => $group->GroupName,
            "Desc"  => $group->GroupDesc,
        );
        return $return;
    }

    private function composeCompanyObj($id) {
        $comp = Companies::getCompanyByID($id);
        $return = array(
            "Name"  => $comp->CompanyName,
            "Desc"  => $comp->CompanyDesc,
        );
        return $return;
    }

    public function index() {
        $player = NULL;
        if(Auth::isUserLogged()) { $player = User::getUser(); } else { return FALSE; };
        if(!($player->isTranslator() || $player->isDeveloper || $player->isDeveloper() || $player->isSuperUser)) { return FALSE; };
        $type = $this->params['type'];
        if(!isset($type)) { return FALSE; };
        $id = $this->params['id'];
        if(!isset($id)) { return FALSE; };

        $OrigObj = NULL;
        if($type === "game") { $OrigObj = $this->composeGameObj($id); }
        elseif($type === "group") { $OrigObj = $this->composeGroupObj($id); }
        elseif($type === "company") { $OrigObj = $this->composeCompanyObj($id); };
        if(!isset($OrigObj)) { return FALSE; };

        $list["OrigObj"] = $OrigObj;
        $list["transName"] = $this->__($OrigObj["Name"]);
        $list["transDesc"] = $this->__($OrigObj["Desc"]);
        $langObj = Lang::getLangById($player->ID_LANGUAGE);
        $list["langName"] = $langObj->NativeName;
        $list["langID"] = $langObj->A2;
        $otherLangs = explode(",", $player->OtherLanguages);
        $list["otherLangs"] = empty($otherLangs) ? "" : $otherLangs;
        $list["iEnd"] = count($otherLangs);

        $data['title'] = $this->__('Translate');
		$data['body_class'] = 'index_translate';
		$data['header'] = MainHelper::topMenu();
        $data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();

        $data['content'] = $this->renderBlock('translate/index', $list);
		$this->render3Cols($data);
        return TRUE;
    }

    private function txtFormat($tmpTxt) { return addslashes(html_entity_decode($tmpTxt)); }
    private function maxLen($tmpInput) { return DooTextHelper::limitChar($tmpInput, 250); }
    public function save() {
        $player = NULL;
        if(Auth::isUserLogged()) { $player = User::getUser(); } else { return FALSE; };
        $indData = filter_input_array(INPUT_GET);
        if(!isset($indData)) { return FALSE; };
        $newName = $this->txtFormat($indData["newName"]);
        $engName = $this->txtFormat($indData["engName"]);
        $newDesc = $this->txtFormat($indData["newDesc"]);// test these
        $engDesc = $this->txtFormat($indData["engDesc"]);
        $keyName = $this->maxLen($engName);
        $keyDesc = $this->maxLen($engDesc);
        $userLang = "TransText" . $indData["transLang"];
        $transModel = new GeScreenTexts();
        $table = $transModel->_table;
        if(isset($engName) && isset($newName)) {
            $oldNameObj = $transModel->find(array("where" => "TransKey = ?", "param" => array($keyName), "limit" => 1));
            $insName = ($oldNameObj !== FALSE) ? "`ID_TEXT`, " : "";
            $insNKey = ($insName !== "") ? $oldNameObj->ID_TEXT . ", ": "";
            $query = "INSERT INTO ge_screentexts ($insName`TransKey`, `{$userLang}`, `isChanged`, `LastUpdatedTime`, `allowEdit`)
                      VALUES ($insNKey'{$keyName}', '{$newName}', 0, 0, 1)
                      ON DUPLICATE KEY UPDATE `{$userLang}` = '{$newName}'";
            if(!Doo::db()->query($query)) { return FALSE; };
        };
        if(isset($engDesc) && isset($newDesc)) {
            $oldDescObj = $transModel->find(array("where" => "TransKey = ?", "param" => array($keyDesc), "limit" => 1));
            $insDesc = ($oldDescObj !== FALSE) ? "`ID_TEXT`, " : "";
            $insDKey = ($insDesc !== "") ? $oldDescObj->ID_TEXT . ", ": "";
            $query = "INSERT INTO ge_screentexts ($insDesc`TransKey`, `{$userLang}`, `isChanged`, `LastUpdatedTime`, `allowEdit`)
                      VALUES ($insDKey'{$keyDesc}', '{$newDesc}', 0, 0, 1)
                      ON DUPLICATE KEY UPDATE `{$userLang}` = '{$newDesc}'";
            if(!Doo::db()->query($query)) { return FALSE; };
        };
        echo json_encode("success");
        return TRUE;
    }
}
?>