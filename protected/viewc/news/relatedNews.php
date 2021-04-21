<?php
	$Related = new News;
	echo $Related->getRelatedNewsTableRows($newsID, $relatedLimit);
?>
