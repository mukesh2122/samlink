<?php
Doo::loadCore('db/DooSmartModel');

class GeScreenTexts extends DooSmartModel{

    public $ID_TEXT;
    public $TransKey;
    public $TransTextEN;
    public $TransTextDK;
    public $TransTextDE;
    public $TransTextFR;
    public $TransTextES;
    public $TransTextRO;
    public $TransTextLT;
    public $TransTextBG;
    public $TransTextNL;
    public $TransTextEL;
    public $TransTextTR;
    public $TransTextZH;
    public $TransTextIS;
    public $TransTextBR;
    public $TransTextTH;
    public $TransTextPT;
    public $TransTextRU;
    public $TransTextPL;
    public $TransTextFI;
    public $TransTextFA;
    public $TransTextDA;
    public $TransTextNO;
    public $TransTextSE;
    public $TransTextHu;
    public $isChanged;
    public $LastUpdatedTime;
    public $allowEdit;

    public $_table = 'ge_screentexts';
    public $_primarykey = 'ID_TEXT';
    public $_fields = array(
                            'ID_TEXT',
                            'TransKey',
                            'TransTextEN',
                            'TransTextDK',
                            'TransTextDE',
                            'TransTextFR',
                            'TransTextES',
                            'TransTextRO',
                            'TransTextLT',
                            'TransTextBG',
                            'TransTextNL',
                            'TransTextEL',
                            'TransTextTR',
                            'TransTextZH',
                            'TransTextIS',
                            'TransTextBR',
                            'TransTextTH',
                            'TransTextPT',
                            'TransTextRU',
                            'TransTextPL',
                            'TransTextFI',
                            'TransTextFA',
                            'TransTextDA',
                            'TransTextNO',
                            'TransTextSE',
                            'TransTextHU',
                            'isChanged',
                            'LastUpdatedTime',
                            'allowEdit',
                         );

}
?>