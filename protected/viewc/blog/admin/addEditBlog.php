<?php //Redirect if blogs not enabled
if (MainHelper::IsModuleEnabledByTag('blogs') == 0)
        DooUriRouter::redirect(MainHelper::site_url());
if (!Auth::isUserLogged()) DooUriRouter::redirect(MainHelper::site_url('signin'));
$player = User::getUser();
include(realpath(dirname(__FILE__).'/../common/top.php')); ?>

<?php
    
    if (isset($post)) {
        echo '<div class="error pt10">'.$this->__('Error. News could not be saved!').'</div>';
    }
    
    if(isset($post) and isset($post['name'])) {
        $headline = $post['name'];
    } 
    elseif(isset($item->ID_NEWS)) {
        $headline = $item->Headline;
    }    
    else {
        $headline = '';
    }
    
    if(isset($post) and isset($post['messageIntro'])) {
        $intro = $post['messageIntro'];
    } 
    elseif(isset($item->ID_NEWS)) {
        $intro = $item->IntroText;
    }    
    else {
        $intro = '';
    }
    
    if(isset($post) and isset($post['messageText'])) {
        $fullText = $post['messageText'];
    } 
    elseif(isset($item->ID_NEWS)) {
        $fullText = $item->NewsText;
    }    
    else {
        $fullText = '';
    }
        
    if($function=='edit') {
        $pictureDisplay = "show";
    }
    else {
        $pictureDisplay = "hide";
    }
    
    $EditorData = array(
        'ID'            => isset($item->ID_NEWS)?$item->ID_NEWS:null,
        'class'         => 'news_validate',
        'Post'          => '',//$_SERVER['PHP_SELF'],
        'MainOBJ'       => isset($item) ? $item : array(),
        'Title'         => 'Blog',
        'ID_PRE'        => 'blog',
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('published', 1),
                    array('ownerID', (isset($item) ? $item->ID_OWNER : 0)),
                    array('language', 1),
                    array('ownerType', PLAYER),
                    array('newsID', (isset($item) ? $item->ID_NEWS : 0))
                )
            ),
            array(
                'type'  => 'title',
                'class' => 'pl0',
                'text'  => $this->__('Blog Content')
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
    ContentHelper::ParseEditorData($EditorData);
?>