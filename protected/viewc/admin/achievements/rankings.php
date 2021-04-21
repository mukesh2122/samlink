<?php
    echo $this->renderBlock('achievements/common/rankings_list', array(
                            'rankings' => $rankings
    ));
?>
<?php
if(isset($pager)){
	echo $this->renderBlock('common/pagination', array('pager'=>$pager));
}
?>