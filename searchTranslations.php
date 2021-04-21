<?php
//$content = explode("\n", file_get_contents('protected/lang/ro/ro.csv'));
//foreach ($content as $c) {
//	print '"'.trim($c)."<br/>";
//	
//}
//exit;



function scanFileNameRecursivly($path = '', &$name = array()) {
	$path = $path == '' ? dirname(__FILE__) : $path;
	$lists = @scandir($path);

	if (!empty($lists)) {
		foreach ($lists as $f) {

			if (is_dir($path . DIRECTORY_SEPARATOR . $f) && $f != ".." && $f != ".") {
				scanFileNameRecursivly($path . DIRECTORY_SEPARATOR . $f, &$name);
			} else {
				if(substr($path . DIRECTORY_SEPARATOR . $f, -3, 3) == 'php') {
					$name[] = $path . DIRECTORY_SEPARATOR . $f;
				}
				
			}
		}
	}
	return $name;
}

$file_names = scanFileNameRecursivly();

$result = array();
foreach($file_names as $file) {
	
	if (file_exists($file)) {
		
		$content = file_get_contents($file);
		if (preg_match_all('/this->__\(\s*\'((?:[^\']|(?<=\\\)\')+)\'/us', $content, $resultMatch)) {
			$result = array_merge($result, $resultMatch[1]);
			
		}
	} else {
		echo "No file";
	}
}
$result = array_unique($result);

if(!empty($result)) {
	foreach($result as $item) {
		echo '"'.$item.'";"'.$item.'"'.'<br/>';
	}
}
?>