<?php

class SnGdImage extends DooGdImage {

    /**
     * Resizes the Image and keep it proportioned
     *
     * Resize the image to fit within specified area while maintaining the image ratio.
     *
     * There are 3 modes of operation which are
     *  - To resize so width matches specification and height it auto determined (set width but leave height as null)
     *  - To resize so height matches spectification and width is auto determined (set width to null and height to desired height)
     *  - To resize so image fits within the area defined by width and height (set both width and height)
     *
     * @param string $file The image file name.
     * @param int $width The maximum width of the new image (or null if only setting height)
     * @param int $height The maximum height of the new image (or null if only setting width)
     * @param string $rename New file name for the processed image file to be saved.
     * @return bool|string Returns the generated image file name. Return false if failed.
     */
    public function ratioResize($file, $width=null, $height=null, $rename='') {

        $file = $this->uploadPath . $file;
        $imginfo = $this->getInfo($file);

        if ($rename == '')
            $newName = substr($imginfo['name'], 0, strrpos($imginfo['name'], '.')) . $this->thumbSuffix . '.' . $this->generatedType;
        else
            $newName = $rename . '.' . $this->generatedType;

        if ($width === null && $height === null) {
            return false;
        } elseif ($width !== null && $height === null) {
            $resizeWidth = $width;
            $resizeHeight = ($width / $imginfo['width']) * $imginfo['height'];
        } elseif ($width === null && $height !== null) {
            $resizeWidth = ($height / $imginfo['height']) * $imginfo['width'];
            $resizeHeight = $height;
        } else {
			
			if($imginfo['width'] < $width and $imginfo['height'] < $height) {
				$width = $imginfo['width'];
				$height = $imginfo['height'];
			}
			
            if ($imginfo['width'] > $imginfo['height']) {
                $resizeWidth = $width;
                $resizeHeight = ($width / $imginfo['width']) * $imginfo['height'];
            } else {
                $resizeWidth = ($height / $imginfo['height']) * $imginfo['width'];
                $resizeHeight = $height;
            }
        }

        //create image object based on the image file type, gif, jpeg or png
        $this->createImageObject($img, $imginfo['type'], $file);
        if (!$img)
            return false;

        if (function_exists('imagecreatetruecolor')) {
            $newImg = imagecreatetruecolor($resizeWidth, $resizeHeight);
            imagecopyresampled($newImg, $img, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $imginfo['width'], $imginfo['height']);
        } else {
            $newImg = imagecreate($resizeWidth, $resizeHeight);
            imagecopyresampled($newImg, $img, ($width - $resizeWidth) / 2, ($height - $resizeHeight) / 2, 0, 0, $resizeWidth, $resizeHeight, $imginfo['width'], $imginfo['height']);
        }

        imagedestroy($img);

        if ($this->saveFile) {
            //delete if exist
            if (file_exists($this->processPath . $newName))
                unlink($this->processPath . $newName);
            $this->generateImage($newImg, $this->processPath . $newName);
            imagedestroy($newImg);
            return $this->processPath . $newName;
        }
        else {
            $this->generateImage($newImg);
            imagedestroy($newImg);
        }

        return true;
    }

}
