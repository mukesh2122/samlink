<?php
Doo::loadCore('db/DooSmartModel');

class EsLadderranges extends DooSmartModel{

	public $entry;
	public $min;
	public $max;
	public $img;

	public $_table = 'es_ladderranges';
	public $_primarykey = '';
	public $_fields = array(
                        'entry',
                        'min',
                        'max',
                        'img',
                         );
}
?>
