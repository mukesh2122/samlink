<?php
Doo::loadCore('db/DooSmartModel');

class SyBugReports extends DooSmartModel{

    public $ID_ERROR;
    public $isBug;
    public $Module;
    public $ReportType;
    public $Category;
    public $SubCategory;
    public $ErrorStatus;
    public $Status;
    public $ErrorName;
    public $ErrorLog;
    public $InternalLog;
    public $ID_REPORTEDBY;
    public $ReportedBy;
    public $CreatedTime;
    public $Priority;
    public $LastUpdatedTime;
    public $LastUpdatedByType;
    public $ID_LASTUPDATEDBY;
    public $LastUpdatedBy;
    public $Developer;
    public $FixedTime;
    public $Approver;
    public $CompletedTime;
    public $ImageURL;

    public $_table = 'sy_bugreports';
    public $_primarykey = 'ID_ERROR';
    public $_fields = array(
                            'ID_ERROR',
                            'isBug',
                            'Module',
                            'ReportType',
                            'Category',
                            'SubCategory',
                            'ErrorStatus',
                            'Status',
                            'ErrorName',
                            'ErrorLog',
                            'InternalLog',
                            'ID_REPORTEDBY',
                            'ReportedBy',
                            'CreatedTime',
                            'Priority',
                            'LastUpdatedTime',
                            'LastUpdatedByType',
                            'ID_LASTUPDATEDBY',
                            'LastUpdatedBy',
                            'ID_DEVELOPER',
                            'Developer',
                            'FixedTime',
                            'ID_APPROVER',
							'Approver',
                            'CompletedTime',
                            'ImageURL',
                         );

    // Checks if player is super admin
    public function isAdmin()
    {
        $p = User::getUser();
        if($p)
        {
            if($p->canAccess('Super Admin Interface') === TRUE)
            {
                return TRUE;
            }
        }
        return FALSE;
    }

}
?>