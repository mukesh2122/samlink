<?php
Doo::loadCore('db/DooSmartModel');

class EsTransactions extends DooSmartModel{

	public $ID_TRANSACTION;
	public $FK_OWNER;
	public $OwnerType;
	public $TransactionType;
	public $TransactionTime;
	public $Credits;
	public $Coins;
	public $FK_TRANSACTOR;
	public $TransactorType;

	public $_table = 'es_transactions';
	public $_primarykey = 'ID_TRANSACTION';
	public $_fields = array(
                        'ID_TRANSACTION',
                        'FK_OWNER',
                        'OwnerType',
                        'TransactionType',
                        'TransactionTime',
                        'Credits',
                        'Coins',
                        'FK_TRANSACTOR',
                        'TransactorType',
                         );
}
?>
