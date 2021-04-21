<?php
    $player = User::getUser();
    $userLanguages = $player ? explode(",", $player->OtherLanguages) : null;
    
    if (isset($post)) {
        echo '<div class="error pt10">'.$this->__('Error. News could not be saved!').'</div>';
    }
    
    if(isset($post) and isset($post['name'])) {
        $headline = $post['name'];
    } else if(isset($translated)) {
        $headline = $translated->Headline;
    } else {
        $headline = '';
    }
    
    if(isset($post) and isset($post['messageIntro'])) {
        $intro = $post['messageIntro'];
    } else if(isset($translated)) {
        $intro = $translated->IntroText;
    } else {
        $intro = '';
    }
    
    if(isset($post) and isset($post['messageText'])) {
        $fullText = $post['messageText'];
    } else if(isset($translated)) {
        $fullText = $translated->NewsText;
    } else {
        $fullText = '';
    }
    
    if (isset($post) && isset($post['language'])) {
        $selectedLang = $post['language'];
    } elseif (isset($translated)) {
        $selectedLang = $translated->ID_LANGUAGE;
    } 
    $langOptions = array();
    $langOrigins = array();
    foreach ($languages as $lang) {
         if(in_array($lang->ID_LANGUAGE, $userLanguages) && array_key_exists($lang->ID_LANGUAGE, $translatedLangs)===FALSE) {
             $langOptions[] = array(
                'text'      => $lang->NativeName,
                'value'     => $lang->ID_LANGUAGE,
                'selected'  =>((isset($selectedLang) && $lang->ID_LANGUAGE == $selectedLang))
             );
         }
         elseif(array_key_exists($lang->ID_LANGUAGE, $translatedLangs)) {
             $langOrigins[] = array(
                'text'      => $lang->NativeName,
                'value'     => $lang->ID_LANGUAGE,
                'selected'  =>((isset($selectedLang) && $lang->ID_LANGUAGE == $selectedLang))
             );
         }
    }
    
    $EditorData = array(
        'ID'            => isset($newsItem->ID_NEWS)?$newsItem->ID_NEWS:null,
        'class'         => 'news_validate',
        'formid'        => 'newsTranslate',
        'Post'          => '',//$_SERVER['PHP_SELF'],
        'MainOBJ'       => isset($newsItem) ? $newsItem : (isset($translated) ? $translated : array()),
        'Title'         => 'News',
        'ID_PRE'        => 'news',
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
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
                'title' => $this->__('Original Language'),
                'id'    => 'newsOrigin',
                'name'  => 'originLanguage',
                'options'   => $langOrigins
            ),
            array(
                'type'  => 'select',
                'title' => $this->__('Translation Language'),
                'id'    => 'newsLanguage',
                'name'  => 'language',
                'options'   => $langOptions
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
                'value'     => $headline
            ),
            array(
                'type'      => 'textfield',
                'id'        => 'messageIntro',
                'text'      => $this->__('Short Description'),
                'value'     => $intro,
                'options'   => array('height' => '80')
            ),
            array(
                'type'      => 'textfield',
                'id'        => 'messageText',
                'text'      => $this->__('News Text'),
                'value'     => $fullText
            )
        )
    );
    
    if ($player->canAccess('Approve news') === true) {
        $EditorData['Elements'][] = array(
            'type'      => 'checkbox',
            'title'     => $this->__('Publish Language Article'),
            'checked'   => (isset($translated) and $translated->Published == 1),
            'id'        => 'langArticle',
            'name'      => 'publishLangArticle'
        );
    }
    
//    $EditorData['Elements'][] = array('type'=>'picture');
    ContentHelper::ParseEditorData($EditorData);
?>