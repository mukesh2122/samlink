<?php
Doo::loadCore('db/DooSmartModel');

class BstTransactions extends DooSmartModel {

 public $ID_NOTICE;
 public $ID_TRANSACTION;
 public $FK_NOTICE;
 public $FK_RESPONSE;
 public $ID_SELLER;
 public $ID_BUYER;
 public $Credits;
 public $SaleType;
 public $TransactionTime;
 public $_table = 'bst_transactions';
 public $_primarykey = 'ID_TRANSACTION';
 public $_fields = array(
  'ID_TRANSACTION',
'FK_NOTICE',
'FK_RESPONSE',
'ID_SELLER',
'ID_BUYER',
'Credits',
'SaleType',
'TransactionTime',

        );
};
?>
