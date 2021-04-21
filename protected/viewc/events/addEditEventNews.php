<?php

//echo "<pre>";
//print_r($languages);
//echo "</pre>";
//RETURN FALSE;
    $player = User::getUser();
    include(realpath(dirname(__FILE__).'/common/top.php'));
    
    if (isset($post)) {
        echo '<div class="error pt10">'.$this->__('Error. News could not be saved!').'</div>';
    }
    
    if (isset($newsItem)) {
        $translatedLangs = $newsItem->getTranslatedLanguages($language);
        $editUrl = MainHelper::site_url('event/'.$newsItem->ID_EVENT.'/edit/'.$newsItem->ID_NEWS.'/');
        $langList = array();
        if (!empty($translatedLangs)) {
            echo '<div class="mt10">'.$this->__('Switch to Translated Language').'</div>';
            foreach ($translatedLangs as $langID=>$langName) {
                $langList[] = '<a href="'.$editUrl.$langID.'">'.$langName.'</a>';
            }
            echo implode(", ", $langList);
        }
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
    } elseif (isset($language)) {
        $selectedLang = $language;
    }
    
    $langOptions = array();
    if($ownerType!==GROUP) {
        foreach ($languages as $lang) {
            $langOptions[] = array(
                'text'      => $lang->NativeName,
                'value'     => $lang->ID_LANGUAGE,
                'selected'  =>((isset($selectedLang) && $lang->ID_LANGUAGE == $selectedLang))
            );
        }
    }
    else {
        $langOptions[] = array(
            'text'      => $languages->NativeName,
            'value'     => $languages->ID_LANGUAGE,
            'selected'  =>((isset($selectedLang) && $languages->ID_LANGUAGE == $selectedLang))
        );
    }
    
    if($function=='edit') {
        $pictureDisplay = "show";
    }
    else {
        $pictureDisplay = "hide";
    }
    
    $EditorData = array(
        'ID'            => isset($newsItem->ID_NEWS)?$newsItem->ID_NEWS:null,
        'class'         => 'news_validate',
        'Post'          => '',//$_SERVER['PHP_SELF'],
        'MainOBJ'       => isset($newsItem) ? $newsItem : (isset($translated) ? $translated : array()),
        'Title'         => 'News',
        'ID_PRE'        => 'news',
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('ownerID', (isset($ownerID) ? $ownerID : 0)),
                    array('function', $function),
                    array('ownerType', $ownerType),
                    array('eventID', $event->ID_EVENT),
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
            ),
            array(
                'type'      => 'picture',
                'show'      => $pictureDisplay
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
        $EditorData['Elements'][] = array(
            'type'      => 'checkbox',
            'title'     => $this->__('Publish Main Article'),
            'checked'   => (isset($newsItem) and $newsItem->Published == 1),
            'id'        => 'mainArticle',
            'name'      => 'publishMainArticle'
        );
    }
    
//    $EditorData['Elements'][] = array('type'=>'picture');
    ContentHelper::ParseEditorData($EditorData);
?>