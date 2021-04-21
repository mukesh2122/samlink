<?php $platformText = $this->__('All platforms'); ?>
<script type="text/javascript">
var ownerType = '<?php echo $ownerType; ?>';
var companytypes = <?php echo json_encode($companytypes); ?>;
var gametypes = <?php echo json_encode($gametypes); ?>;
var companyOwnerArray = <?php echo json_encode($companyOwnerArray); ?>;
var gameOwnerArray = <?php echo json_encode($gameOwnerArray); ?>;
function dropkickChange() {
    if(ownerType === 'company') {
        changeCategory("newsType","newsOwner",companyOwnerArray);
    } else if(ownerType === 'game') {
        changeCategory("newsType","newsOwner",gameOwnerArray,"newsPlatform","<?php echo $platformText; ?>");
    };
};
function newsAdminChangeOwner() {
    var game = document.getElementById("newsOwner").value;
    ajaxCall(game,"newsPlatform","<?php echo $platformText; ?>");
};
$(document).ready(function() {
    $("#newsType").on("change", function() { dropkickChange(); });
    $("#newsOwner").on("change", function() { if(this.value !== "0") { ajaxCall(this.value, "newsPlatform", "<?php echo $platformText; ?>") }; });
    $("#change_type").click(function() {
        if(ownerType === 'company') {
            changeTypeCategory("newsType", "newsOwner", gametypes, gameOwnerArray, "newsPlatform", "<?php echo $platformText; ?>");
            document.getElementById("change_type").value = '<?php echo $this->__('Go to '); ?>' + ownerType;
            ownerType='game';
            document.getElementById("ownerType").value = ownerType;
            document.getElementById("divPlatform").style.display = '';
        } else if(ownerType === 'game') {
            changeTypeCategory("newsType", "newsOwner", companytypes, companyOwnerArray, null, null);
            document.getElementById("change_type").value = '<?php echo $this->__('Go to '); ?>' + ownerType;
            ownerType='company';
            document.getElementById("ownerType").value = ownerType;
            document.getElementById("divPlatform").style.display = 'none';
        };
    });
});
</script>
<?php
    $player = User::getUser();
    if($ownerType == 'company') {
        $altType = 'game';
        $ownerArray = $companyOwnerArray;
        $types = $companytypes;
        include(realpath(dirname(__FILE__) . '/../../companies/common/top.php'));
    } elseif($ownerType == 'game') {
        $altType = 'company';
        $ownerArray = $gameOwnerArray;
        $types = $gametypes;
        include(realpath(dirname(__FILE__) . '/../../games/common/top.php'));
    };

    if(isset($newsItem) || $adminPanel == 1) {
        $newsTypeDisplay = 'display: block;';
        $newsOwnerDisplay = 'display: block;';
        $buttonDisplay = 'display: block;';
    } else {
        $newsTypeDisplay = 'display: none;';
        $newsOwnerDisplay = 'display: none;';
        $buttonDisplay = 'display: none;';
    };

    if(isset($post)) {
        echo '<div class="error pt10">', $this->__('Error. News could not be saved'), '!</div>';
    };

    if(isset($newsItem)) {
        $translatedLangs = $newsItem->getTranslatedLanguages($language);
        $editUrl = $typeUrl . '/admin/edit-news/' . $newsItem->ID_NEWS . '/';
        $langList = array();
        if(!empty($translatedLangs)) {
            echo '<div class="mt10">' . $this->__('Switch to Translated Language'), '</div>';
            foreach($translatedLangs as $langID=>$langName) {
                $langList[] = '<a href="' . $editUrl . $langID . '">' . $langName . '</a>';
            };
            echo implode(", ", $langList);
        };
    };

    $owners = array();
    $allPlatforms = array();
    $allPlatforms[] = (object) array(
                'ID_PLATFORM' => 0,
                'PlatformName' => $this->__('All Platforms')
            );

    if(isset($newsItem) || $adminPanel==0) {
        foreach($ownerArray as $owner) {
            if($owner->TypeID==$type) { $owners[] = $owner; };
        };
        if($ownerType=='game' && isset($itemPlatforms)) {
            foreach($itemPlatforms as $platformOptions) {
                $allPlatforms[] = $platformOptions->SnPlatforms;
            };
        };
    } else {
        $owners[] = (object) array(
            'OwnerID' => NULL,
            'Name' => $this->__('Choose category first')
        );
    };

    if(isset($post) and isset($post['name'])) { $headline = $post['name']; }
    else if(isset($translated)) { $headline = $translated->Headline; }
    else { $headline = ''; };

    if(isset($post) and isset($post['messageIntro'])) { $intro = $post['messageIntro']; }
    else if(isset($translated)) { $intro = $translated->IntroText; }
    else { $intro = ''; };

    if(isset($post) and isset($post['messageText'])) { $fullText = $post['messageText']; }
    else if(isset($translated)) { $fullText = $translated->NewsText; }
    else { $fullText = ''; };

    if(isset($post) && isset($post['language'])) { $selectedLang = $post['language']; }
    elseif(isset($language)) { $selectedLang = $language; }; 
    $langOptions = array();
    foreach($languages as $lang) {
        $langOptions[] = array(
            'text'      => $lang->NativeName,
            'value'     => $lang->ID_LANGUAGE,
            'selected'  =>((isset($selectedLang) && $lang->ID_LANGUAGE == $selectedLang))
        );
    };

    if($ownerType=='game') { $platformDisplay = 'display: block;'; }
    else { $platformDisplay = "display: none;"; };

    if($function=='edit') { $pictureDisplay = "show"; }
    else { $pictureDisplay = "hide"; };

    $EditorData = array(
        'ID'            => isset($newsItem->ID_NEWS) ? $newsItem->ID_NEWS : null,
        'class'         => 'news_validate',
        'Post'          => '',//$_SERVER['PHP_SELF'],
        'MainOBJ'       => isset($newsItem) ? $newsItem : (isset($translated) ? $translated : array()),
        'Title'         => 'News',
        'ID_PRE'        => 'news',
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('hiddenOwnerID', (isset($ownerID) ? $ownerID : 0)),
                    array('isAdminPanel', $adminPanel),
                    array('function', $function),
                    array('ownerType', $ownerType),
                    array('newsID', (isset($newsItem) ? $newsItem->ID_NEWS : 0))
                )
            ),
            array(
                'type'  => 'title',
                'class' => 'pl0',
                'text'  => $this->__('News Specifications')
            ),
            array(
                'type'  => 'select',
                'title' => $this->__('Language'),
                'id'    => 'newsLanguage',
                'name'  => 'language',
                'options'   => $langOptions
            ),
            array(
                'title'     => $this->__('Category'),
                'id'        => 'newsType',
                'divstyle'  => $newsTypeDisplay,
                'class'     => 'change',
                'name'      => 'type',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($types, 'TypeID', 'Name', 'TypeID', array((isset($type) ? $type : null)))
            ),
            array(
                'title'     => $this->__('Owner'),
                'id'        => 'newsOwner',
                'divstyle'  => $newsOwnerDisplay,
                'class'     => 'changeOwner',
                'name'      => 'ownerID',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($owners, 'OwnerID', 'Name', 'OwnerID', array((isset($newsItem) ? $newsItem->ID_OWNER : null)))
            ),
            array(
                'title'     => $this->__('Platform'),
                'id'        => 'newsPlatform',
                'divstyle'  => $platformDisplay,
                'divid'     => 'divPlatform',
                'name'      => 'platform',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($allPlatforms, 'ID_PLATFORM', 'PlatformName', 'ID_PLATFORM', array((isset($newsItem) ? $newsItem->ID_PLATFORM : null)))
            ),
            array(
                'title'     => $this->__('Change Type'),
                'id'        => 'change_type',
                'divstyle'  => $buttonDisplay,
                'type'      => 'button',
                'value'     => $this->__('Go to ') . $this->__($altType),
                'options'   => ContentHelper::ObjArrayToOptions($owners, 'OwnerID', 'Name', 'OwnerID', array((isset($newsItem) ? $newsItem->ID_OWNER : null)))
            ),
            array(
                'type'  => 'title',
                'class' => 'pl0',
                'text'  => $this->__('News Content')
            ),
            array(
                'title'     => $this->__('Headline'),
                'id'        => 'newsHeadline',
                'name'      => 'name',
                'value'     => $headline,
                'maxlen'    => 200,
            ),
            array(
                'type'      => 'textfield',
                'id'        => 'messageIntro',
                'text'      => $this->__('Short Description'),
                'value'     => $intro,
                'options'   => array('height' => '80', 'width' => '800'),
                'maxlen'    => 170,
            ),
            array(
                'type'      => 'textfield',
                'id'        => 'messageText',
                'text'      => $this->__('News Text'),
                'value'     => $fullText,
                'options'   => array('width' => '800'),
                'maxlen'    => "16000000",
            ),
            array(
                'type'      => 'picture',
                'show'      => $pictureDisplay
            )
        )
    );

    if($player->canAccess('Approve news') === true) {
        $EditorData['Elements'][] = array(
            'type'      => 'checkbox',
            'title'     => $this->__('Publish Language Article'),
            'checked'   => (isset($translated) and $translated->Published == 1),
            'id'        => 'langArticle',
            'name'      => 'publishLangArticle'
        );
        $EditorData['Elements'][] = array(
            'type'      => 'checkbox',
            'title'     => $this->__('Publish Main Article'),
            'checked'   => (isset($newsItem) and $newsItem->Published == 1),
            'id'        => 'mainArticle',
            'name'      => 'publishMainArticle'
        );
    };

//    $EditorData['Elements'][] = array('type'=>'picture');
    ContentHelper::ParseEditorData($EditorData);
?>