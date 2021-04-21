<?php
	session_start();

	function resizeImage($Filename, $sizeX, $sizeY) {
			$Temp = explode('.', $Filename);
			$Extenstion = end($Temp);
			switch ($Extenstion) {
				case 'jpeg':
				case 'jpg':
					$src = imagecreatefromjpeg($Filename);
					break;
				case 'png':
					$src = imagecreatefrompng($Filename);
					break;
				case 'gif':
					$src = imagecreatefromgif($Filename);
					break;
			}

			if (is_null($src)) die("Cant handle it, giving up....");

			$x = imagesx ($src);
			$y = imagesy ($src);


			// original height / original width x new width = new height
			if ($y > $sizeY) {
				$aspect = $x / $y;
				$temp = $y - $sizeY;
				$y = $sizeY;
				$x -= ($temp * $aspect);
			}

			$y = ($y / $x * $sizeX);
			$x = $sizeX;
			
			$dest = imagecreatetruecolor($x, $y);
			
			imagecopyresampled($dest, $src,
				0, 0,                            // Destination
				0, 0,
				$x, $y,                          //Dest
				imagesx ($src), imagesy ($src)   // Src
			);

			switch ($Extenstion) {
				case 'jpeg':
				case 'jpg':
					imagejpeg($dest, $Filename, 80);
					break;
				case 'png':
					imagepng($dest, $Filename);
					break;
				case 'gif':
					imagegif($dest, $Filename);
					break;
			}
	
			imagedestroy($dest);
			imagedestroy($src);
	}

	if (isset($_FILES['qqfile'])) {
		$ScriptFilename = $_SERVER['SCRIPT_FILENAME'];
		$pathParts      = explode('/', $ScriptFilename);
		$temp           = array_chunk($pathParts, count($pathParts) - 2);
		$BasePath       = implode('/', $temp[0]);
		if (isset($_REQUEST['folder']))
			$BasePath .= '/global/pub_img/'. $_REQUEST['folder'];


		function CreateDestination($Filename) {
			global $BasePath;
			$name = mb_substr($Filename, 0, mb_strrpos($Filename, '.'));
			$ext = mb_substr($Filename, mb_strrpos($Filename, '.') + 1);
			$Filename = $name.'_'.time().'_'.rand(1000, 9000).'.'.$ext;
			$newPath1 = $BasePath . '/' . $Filename[0];
			$newPath2 = $newPath1 . '/' . $Filename[1];
			if (!is_dir($newPath1)) mkdir($newPath1);
			if (!is_dir($newPath2)) mkdir($newPath2);
			return $newPath2.'/'.$Filename;
		}

		$File = $_FILES['qqfile'];
		if (strpos($File['type'], 'image/') !== 1) {
			$Filename = CreateDestination(strtolower(utf8_decode($File['name'])));
			move_uploaded_file($File['tmp_name'], $Filename);
			$_SESSION['lastUploadedImage'] = array();
			$_SESSION['lastUploadedImage']['Filename'] = $Filename;
			$_SESSION['lastUploadedImage']['MIME']     = $File['type'];

		/*
		    'type' => 'image/jpeg',
		    'size' => 128701,
		*/
			resizeImage($Filename, 800, 600);
			$Filename = substr($Filename, strlen($_SERVER['DOCUMENT_ROOT']));
			$Filename = ($Filename[0] !== '/' ? ('/' . $Filename) : $Filename);
			$File['img'] = utf8_encode($Filename).'?noCache='.time();
			$_SESSION['lastUploadedImage']['URL'] = utf8_encode($Filename);
			$File['img800x600'] = utf8_encode($Filename).'?noCache='.time();
			echo json_encode($File);
		} else {
			echo 'Not an image';
		}
	} else {
		
		$Positions = array(
			'x1' => $_POST['x'],
			'y1' => $_POST['y'],
			'x2' => $_POST['x2'],
			'y2' => $_POST['y2']
		);
		
		$Size = array(
			'Width'  => $_POST['w'],
			'Height' => $_POST['h']
		);

		$Info = getimagesize($_SESSION['lastUploadedImage']['Filename']);

		if ($Info['mime'] == $_SESSION['lastUploadedImage']['MIME']) {
			$Temp = explode('.', $_SESSION['lastUploadedImage']['Filename']);
			$Extenstion = end($Temp);
			$src = null;
			switch ($Extenstion) {
				case 'jpeg':
				case 'jpg':
					$src = imagecreatefromjpeg($_SESSION['lastUploadedImage']['Filename']);
					break;
				case 'png':
					$src = imagecreatefrompng($_SESSION['lastUploadedImage']['Filename']);
					break;
				case 'gif':
					$src = imagecreatefromgif($_SESSION['lastUploadedImage']['Filename']);
					break;
			}

			if (is_null($src)) die("Cant handle it, giving up....");

			$dest = imagecreatetruecolor($_REQUEST['DestWidth'], $_REQUEST['DestHeight']);

			// Copyint $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
			//imagecopy($dest, $src, 0, 0, $Positions['x1'], $Positions['y1'], $Size['Width'], $Size['Height']);
			imagecopyresampled($dest, $src,
				0, 0,                                 // Destination
				$Positions['x1'], $Positions['y1'],   // Src
				$_REQUEST['DestWidth'], $_REQUEST['DestHeight'], //Dest
				$Size['Width'], $Size['Height']       // Src
			);

			switch ($Extenstion) {
				case 'jpeg':
				case 'jpg':
					imagejpeg($dest, $_SESSION['lastUploadedImage']['Filename'], 80);
					break;
				case 'png':
					imagepng($dest, $_SESSION['lastUploadedImage']['Filename']);
					break;
				case 'gif':
					imagegif($dest, $_SESSION['lastUploadedImage']['Filename']);
					break;
			}
			echo json_encode(array(
				'img' => $_SESSION['lastUploadedImage']['URL']
			));
			imagedestroy($dest);
			imagedestroy($src);
		} else {
			echo 'Still not an image';
		}
	}
?>
