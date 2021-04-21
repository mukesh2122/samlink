<?php
    $urlValue = filter_input(INPUT_SERVER, 'REQUEST_URI');

    $cssFNmodel = new CssFilename();
    $table = $cssFNmodel->_table;
    $Opts = array(
        "select"=> "{$table}.Path, {$table}.FilenameDesc",
        "param" => array($urlValue),
        "where" => "MATCH {$table}.FilenameDesc AGAINST (? IN BOOLEAN MODE)",
    );
    $result = $cssFNmodel->getOne($Opts);

    if(!empty($result)) {
        $DLFileName = $appUrl . 'global/css/' . $result->Path;
        if(file_exists($DLFileName)) { echo '<link rel="stylesheet" type="text/css" href="', $DLFileName, '">'; };
    } else {
        $userID = (Auth::isUserLogged()) ? User::getUser()->ID_PLAYER : 0;
        $cssModel = new CssProfiletable();
        $newOpts = array(
            "param" => array($userID),
            "where" => "{$cssModel->_table}.fk_playerID = ?",
        );
        $Result = $cssModel->getOne($newOpts);

        function urlValue($input) {
            return (FALSE !== strpos(filter_input(INPUT_SERVER, "REQUEST_URI"), $input)) ? TRUE : FALSE;
        };

        switch(TRUE){
            case (urlValue("/game/")):
            case (urlValue("games")):
                $cssPath = "defaultCssGames";
                break;
            case (urlValue("/company/")):
            case (urlValue("companies")):
                $cssPath = "defaultCssCompanies";
                break;
            case (FALSE !== stripos($urlValue, "/group/")):
            case (FALSE !== stripos($urlValue, "/groups")):
                $cssPath = "css_groups";
                break;
            case (FALSE !== stripos($urlValue, "/news")):
                $cssPath = "css_news";
                break;
            case (FALSE !== stripos($urlValue, "/event/")):
            case (FALSE !== stripos($urlValue, "/events")):
                $cssPath = "css_events";
                break;
            case (urlValue("/recruitment2")):
            case (urlValue("/recruitment2/")):
                $cssPath = "css_recruitment";
                break;
            default: 
                $cssPath = "defaultNewCss";
        };

        $DLFileName = $appUrl .'global/css/' . $cssPath . '.css';
        if(file_exists($DLFileName)) { echo '<link href="',$DLFileName,'" rel="stylesheet" type="text/css">'; };
    };
?>