<?php
if(isset($function) && $function=='edit') {
    $downloadName = $downloadItem->DownloadName;
    $downloadDesc = $downloadItem->DownloadDesc;
    $downloadURL = $downloadItem->URL;
    $downloadFileSize = $downloadItem->FileSize;
    $filetype = $downloadItem->ID_FILETYPE;
}
elseif(isset($function) && $function=='add') {
    $downloadName = '';
    $downloadDesc = '';
    $downloadURL = '';
    $downloadFileSize = '';
}

if(count($companyDownloadTabs)==0) {
    $companyDownloadTabs[] = (object) array(
                'ID_FILETYPE' => 0,
                'FiletypeName' => $this->__('Create filetype first')
            );
}
$EditorData = array(
        'ID'            => isset($downloadItem->ID_DOWNLOAD)?$downloadItem->ID_DOWNLOAD:null,
        'formid'        => 'adddownloads_company_form',
        'Post'          => '',//$_SERVER['PHP_SELF'],
        'Title'         => 'Downloads',
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('ID_OWNER', $company->ID_COMPANY),
                    array('download_id', isset($downloadItem->ID_DOWNLOAD)?$downloadItem->ID_DOWNLOAD:null),
                    array('OwnerType', 'company'),
                    array('function', $function)
                )
            ),
            array(
                'type'  => 'title',
                'class' => 'pl0',
                'text'  => $function=='add' ? $this->__('Add download') : ($function=='edit' ? $this->__('Edit download') : $this->__('Downloads'))
            ),
            array(
                'title'     => $this->__('Download Name'),
                'id'        => 'download_filename',
                'value'     => $downloadName
            ),
            array(
                'type'      => 'textfield',
                'id'        => 'download_description',
                'text'      => $this->__('Download Description'),
                'value'     => $downloadDesc,
                'options'   => array('height' => '80')
            ),
            array(
                'title'     => $this->__('URL'),
                'id'        => 'download_fileurl',
                'value'     => $downloadURL
            ),
            array(
                'title'     => $this->__('Filetype'),
                'id'        => 'tab_id',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($companyDownloadTabs, 'ID_FILETYPE', 'FiletypeName', 'ID_FILETYPE', array((isset($filetype)?$filetype:null)))
            ),
            array(
                'title'     => $this->__('Filesize (MB)'),
                'id'        => 'download_filesize',
                'value'     => $downloadFileSize
            )
        )
    );
    
    ContentHelper::ParseEditorData($EditorData);
?>