<?php

class Image {

	/**
	 * Uses uploadify
	 */
	public function uploadImages($folder, $oldImage = '', $file = '', $pathextension = true) {
            if($file!='') {
                $tempFile = $file['tmp_name'];
		$targetFile = $file['name'];

		// Validate the file type
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
		$fileParts = pathinfo($file['name']);
            }
            else {
                $tempFile = $_FILES['Filedata']['tmp_name'];
		$targetFile = $_FILES['Filedata']['name'];

		// Validate the file type
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
		$fileParts = pathinfo($_FILES['Filedata']['name']);
            }

		if (in_array($fileParts['extension'], $fileTypes)) {
			$newName = preg_replace("/[^a-z0-9-]/", "", strtolower($targetFile));
			$newName = mb_substr($newName, 0, -4);
			$newName = mb_substr($newName, 0, 20);
                            
                        $path = Doo::conf()->SITE_PATH . 'global/pub_img/' . $folder . '/';
                        
                        $addPath = $pathextension == true ? substr($newName, 0, 1) . '/' . substr($newName, 1, 1) . '/' : '';

			//remove old images
			if ($oldImage != '') {
				$addPathDel = substr($oldImage, 0, 1) . '/' . substr($oldImage, 1, 1) . '/';
				$pathToStoreDel = $path . $addPathDel;

				$gd = new SnGdImage($pathToStoreDel, $pathToStoreDel, true);

				foreach (Doo::conf()->image_sizes as $size) {
					$gd->thumbSuffix = $size;
					$gd->removeImage($oldImage);
				}
			}

			$pathToStore = $path . $addPath;
			$gd = new SnGdImage($pathToStore, $pathToStore, true);
			$gd->generatedQuality = 85;
			$newName = $newName . '_' . time() . '_' . rand(1000, 9000);
			$img = $gd->uploadImage('Filedata', $newName);

			$return = array();
			$return['filename'] = $img;
			$targetFile = str_replace(array('_', '-'), " ", strtolower($targetFile));
			$targetFile = str_replace(array('.jpg', '.png', '.gif', '.jpeg'), "", $targetFile);
			$return['original_name'] = $targetFile;
			return $return;
		} else {
			return 'Invalid file type.';
		}
	}
	
	public function importImage($folder, $imageUrl, $oldImage = '') {
		$targetFile = explode("/", $imageUrl);
		$targetFile = end($targetFile);

		// Validate the file type
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // File extensions
		$fileParts = pathinfo($targetFile);

		$imageContents = @file_get_contents($imageUrl);
		
		if (isset($fileParts['extension']) and in_array($fileParts['extension'], $fileTypes)) {
			
			$newName = preg_replace("/[^a-z0-9-]/", "", strtolower($targetFile));
			$newName = mb_substr($newName, 0, -4);
			$newName = mb_substr($newName, 0, 20);

			$path = Doo::conf()->SITE_PATH . 'global/pub_img/' . $folder . '/';
			$addPath = substr($newName, 0, 1) . '/' . substr($newName, 1, 1) . '/';

			//remove old images
			if ($oldImage != '') {
				$addPathDel = substr($oldImage, 0, 1) . '/' . substr($oldImage, 1, 1) . '/';
				$pathToStoreDel = $path . $addPathDel;

				$gd = new SnGdImage($pathToStoreDel, $pathToStoreDel, true);

				foreach (Doo::conf()->image_sizes as $size) {
					$gd->thumbSuffix = $size;
					$gd->removeImage($oldImage);
				}
			}
			
			$pathToStore = $path . $addPath;
			if (!file_exists($pathToStore)) {
				Doo::loadHelper('DooFile');
				$fileManager = new DooFile(0777);
				$fileManager->create($pathToStore);
			}
		
			$newName = $newName . '_' . time() . '_' . rand(1000, 9000);
			$downloadImage = file_put_contents($pathToStore.$newName.'.'.$fileParts['extension'], $imageContents);

			$return = array();
			$return['filename'] = $newName.'.'.$fileParts['extension'];
			$targetFile = str_replace(array('_', '-'), " ", strtolower($targetFile));
			$targetFile = str_replace(array('.jpg', '.png', '.gif', '.jpeg'), "", $targetFile);
			$return['original_name'] = $targetFile;
			return $return;
		} else {
			return 'Invalid file type.';
		}
	}

	public function deleteImage($folder, $imageName, $pathextenstion = true) {
		//remove old images
		if ($imageName != '') {
			$path = Doo::conf()->SITE_PATH . 'global/pub_img/' . $folder . '/';
			$addPathDel = $pathextenstion ? substr($imageName, 0, 1) . '/' . substr($imageName, 1, 1) . '/' : '';
			$pathToStoreDel = $path . $addPathDel;

			$gd = new SnGdImage($pathToStoreDel, $pathToStoreDel, true);

			foreach (Doo::conf()->image_sizes as $size) {
				$gd->thumbSuffix = $size;
				$gd->removeImage($imageName);
			}
		}
	}
    
    public function cropImage($folder, $oldImage = '') {
        $result = array();
        $result['filename'] = '';
        
        $path = Doo::conf()->SITE_PATH . 'global/pub_img/' . $folder . '/'.substr($oldImage, 0, 1) . '/' . substr($oldImage, 1, 1) . '/';
        $pathImage = $path.$oldImage;

		// Crop from original image
		list($imgSizeX, $imgSizeY) = getimagesize($pathImage);
		list($monSizeX, $monSizeY) = getimagesize(substr($pathImage, 0, strrpos($pathImage, '.')).IMG_800x600.'.jpg');
		$ratioX = $imgSizeX / $monSizeX;
		$ratioY = $imgSizeY / $monSizeY;
        $gd = new DooGdImage();
		$gd->generatedQuality = 85;
        $result['filename'] = $gd->crop(
			$pathImage
		,	floor($_POST['w'] * $ratioX)
		,	floor($_POST['h'] * $ratioY)
		,	floor($_POST['x'] * $ratioX)
		,	floor($_POST['y'] * $ratioY)
		,	substr($pathImage, 0, strrpos($pathImage, '.'))
		);

		// Delete original image if not jpg
		if (strtolower(substr($pathImage, strrpos($pathImage, '.') + 1)) != 'jpg') {
			unlink($pathImage);
		}
		
		// Crop from monitor image
//        $gd = new DooGdImage();
//        $result['filename'] = $gd->crop(
//			substr($pathImage, 0, strrpos($pathImage, '.')).IMG_800x600.'.jpg'
//		,	$_POST['w']
//		,	$_POST['h']
//		,	$_POST['x']
//		,	$_POST['y']
//		,	substr($pathImage, 0, strrpos($pathImage, '.'))
//		);

        $filename = explode('/',$result['filename']);
        $result['filename'] = end($filename);

        //remove old images
        if ($oldImage != '') {
            $gd = new SnGdImage($path, $path, true);

            foreach (Doo::conf()->image_sizes as $size) {
                //$gd->thumbSuffix = $size;
                //$gd->removeImage($oldImage);
                if(is_file(substr($pathImage, 0, strrpos($pathImage, '.')).$size.'.jpg'))
                {
                    unlink(substr($pathImage, 0, strrpos($pathImage, '.')).$size.'.jpg');
                }
            }
        }
        
        return $result;
    }

	public function uploadImage($folder, $oldImage = '') {

		$fileName;
		$fileSize;
		$return = array();
		$return['error'] = '';
		$return['filename'] = '';

		if (isset($_GET['qqfile'])) {
			$fileName = $_GET['qqfile'];

			// xhr request
			$headers = apache_request_headers();
			$fileSize = (int) $headers['Content-Length'];
		} elseif (isset($_FILES['qqfile'])) {
			$fileName = basename($_FILES['qqfile']['name']);
			$fileSize = $_FILES['qqfile']['size'];
		} else {
			$return['error'] = "File not passed";
			return $return;
		}

		if ($fileSize == 0) {
			$return['error'] = "File size is zero";
			return $return;
		}

		if ($fileSize < 10) {
			$return['error'] = "File size is smaller than 10 bytes";
			return $return;
		}
//		if ($fileSize > 300 * 1024) {
//			$return['error'] = "File size is bigger than 300kB";
		if ($fileSize > 2048 * 1024) {
			$return['error'] = "File size is bigger than 2MB";
			return $return;
		}
		if (count($_FILES)) {

			$newName = mb_substr($fileName, 0, mb_strrpos($fileName, '.'));
			$newName = mb_substr($newName, 0, 20);
			$newName = preg_replace("/[^a-z0-9-]/", "_", strtolower($newName));

			$path = Doo::conf()->SITE_PATH . 'global/pub_img/' . $folder . '/';
			$addPath = substr($newName, 0, 1) . '/' . substr($newName, 1, 1) . '/';

			//remove old images
			if ($oldImage != '') {
				$addPathDel = substr($oldImage, 0, 1) . '/' . substr($oldImage, 1, 1) . '/';
				$pathToStoreDel = $path . $addPathDel;

				$gd = new SnGdImage($pathToStoreDel, $pathToStoreDel, true);

				foreach (Doo::conf()->image_sizes as $size) {
					$gd->thumbSuffix = $size;
					$gd->removeImage($oldImage);
				}
			}

			$pathToStore = $path . $addPath;
			$gd = new SnGdImage($pathToStore, $pathToStore, true);
			$gd->generatedQuality = 85;
			$newName = $newName . '_' . time() . '_' . rand(1000, 9000);
			$img = $gd->uploadImage('qqfile', $newName);

			$return['filename'] = $img;
			return $return;
		} else {
			$return['error'] = "Query params not passed";
			return $return;
		}
	}

}

?>