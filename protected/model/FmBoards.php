<?php
Doo::loadCore('db/DooSmartModel');

class FmBoards extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_OWNER;

    /**
     * @var enum 'company','game','group').
     */
    public $OwnerType;

    /**
     * @var smallint Max length is 5.  unsigned.
     */
    public $ID_BOARD;

    /**
     * @var tinyint Max length is 4.  unsigned.
     */
    public $ID_CAT;

    /**
     * @var tinyint Max length is 4.  unsigned.
     */
    public $ChildLevel;

    /**
     * @var smallint Max length is 5.  unsigned.
     */
    public $ID_PARENT;

    /**
     * @var smallint Max length is 5.
     */
    public $BoardOrder;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ID_LAST_MSG;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ID_MSG_UPDATED;

    /**
     * @var tinytext
     */
    public $BoardName;

    /**
     * @var text
     */
    public $BoardDesc;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $TopicCount;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $PostCount;
    public $isClosed;
	
	public $childBoards = array();

	private $URL;

    public $_table = 'fm_boards';
    public $_primarykey = 'ID_BOARD';
    public $_fields = array('ID_OWNER','OwnerType','ID_BOARD','ID_CAT','ChildLevel','ID_PARENT','BoardOrder','ID_LAST_MSG','ID_MSG_UPDATED','BoardName','BoardDesc','TopicCount','PostCount', 'isClosed');

	public function __get($attr) {

        switch ($attr) {
			
        	case 'URL':
				$this->$attr = Url::getUrl($this, "URL");
        		break;
        }
        return $this->$attr;
    }
	
	function getParentBoards(){
		if($this->ChildLevel != 0){
			$parents = array();
			$parentId = $this->ID_PARENT;
			
			
			for($i = $this->ChildLevel-1; $i >= 0 ; $i--){
				$params = array();
				
				$params['where'] = "ID_BOARD = ? AND ID_OWNER = ? AND OwnerType = ?";
				$params['param'] = array($parentId, $this->ID_OWNER, $this->OwnerType);
				$params['limit'] = 1;
				
				$parents[$i] = Doo::db()->find('FmBoards', $params);
				
				if($parents[$i] != null){
					$parentId = $parents[$i]->ID_PARENT;
				}
			}
			
			return $parents;
		}
		return array();
	}
	
	public function getChildCount(){
		$params['select'] = "COUNT(1) as 'cnt'";
		$params['where'] = "ID_OWNER = ? AND OwnerType = ? AND ID_PARENT = ?";
		$params['limit'] = 1;
		$params['param'] = array($this->ID_OWNER, $this->OwnerType, $this->ID_BOARD);
		
		$data = Doo::db()->find('FmBoards', $params);
		
		return $data->cnt;
	}
	
}
?>