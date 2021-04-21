<?php
if(isset($function) && $function=='edit') {
    $filetypeName = $filetypeItem->FiletypeName;
    $filetypeDesc = $filetypeItem->FiletypeDesc;
}
elseif(isset($function) && $function=='add') {
    $filetypeName = '';
    $filetypeDesc = '';
}
$EditorData = array(
        'ID'            => isset($filetypeItem->ID_FILETYPE)?$filetypeItem->ID_FILETYPE:null,
        'Post'          => '',//$_SERVER['PHP_SELF'],
        'Title'         => 'Filetypes',
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('ID_OWNER', $game->ID_GAME),
                    array('tab_id', isset($filetypeItem->ID_FILETYPE)?$filetypeItem->ID_FILETYPE:null),
                    array('OwnerType', 'game'),
                    array('function', $function)
                )
            ),
            array(
                'type'  => 'title',
                'class' => 'pl0',
                'text'  => $function=='add' ? $this->__('Add filetype') : ($function=='edit' ? $this->__('Edit filetype') : $this->__('Filetypes'))
            ),
            array(
                'title'     => $this->__('Filetype Name'),
                'id'        => 'tab_name',
                'value'     => $filetypeName
            ),
            array(
                'type'      => 'textfield',
                'id'        => 'tab_desc',
                'text'      => $this->__('Filetype Description'),
                'value'     => $filetypeDesc,
                'options'   => array('height' => '80')
            )
        )
    );
    
    ContentHelper::ParseEditorData($EditorData);
?>