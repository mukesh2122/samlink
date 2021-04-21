<?php
Doo::loadCore('db/DooSmartModel');

class FmCategories extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_OWNER;

    /**
     * @var enum 'company','game','group').
     */
    public $OwnerType;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_CAT;

    /**
     * @var tinyint Max length is 4.
     */
    public $CatOrder;
	public $boards = array();

    /**
     * @var tinytext
     */
    public $CategoryName;

	public $isCollapsed = false;

    /**
     * @var tinyint Max length is 1.
     */
    public $canCollapse;

    public $_table = 'fm_categories';
    public $_primarykey = 'ID_CAT';
    public $_fields = array('ID_OWNER','OwnerType','ID_CAT','CatOrder','CategoryName','canCollapse');

	public function isCollapsed(){
		$user = User::getUser();

		if($user){
			$params['select'] = "COUNT(1) as 'cnt'";
			$params['where'] = "ID_OWNER = ? AND ID_CAT = ? AND OwnerType = ? AND ID_PLAYER = ?";
			$params['limit'] = 1;
			$params['param'] = array($this->ID_OWNER, $this->ID_CAT, $this->OwnerType, $user->ID_PLAYER);

			$data = Doo::db()->find('FmCollapsedCategories', $params);

			if($data != null){
				if($data->cnt == 1){
					$this->isCollapsed = true;
					return true;
				}
			}
		}
		else{
			$cookie = isset($_COOKIE['forum_collapse']) ? unserialize($_COOKIE['forum_collapse']) : array();

			if(!empty($cookie) and isset($cookie[$this->OwnerType.'-'.$this->ID_OWNER.'-'.$this->ID_CAT]) and $cookie[$this->OwnerType.'-'.$this->ID_OWNER.'-'.$this->ID_CAT] == true){
				$this->isCollapsed = true;
				return true;
			}

		}
		$this->isCollapsed = false;
		return false;
	}

	public function getBoardCount(){
		$params['select'] = "COUNT(1) as 'cnt'";
		$params['where'] = "ID_OWNER = ? AND ID_CAT = ? AND OwnerType = ? AND ChildLevel = ?";
		$params['limit'] = 1;
		$params['param'] = array($this->ID_OWNER, $this->ID_CAT, $this->OwnerType, 0);

		$data = Doo::db()->find('FmBoards', $params);

		return $data->cnt;
	}

}
?>