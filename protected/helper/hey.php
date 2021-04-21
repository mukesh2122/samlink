<?php
 
 include 'http://playnation.eu/beta/protected/helper/MainHelper.php';
 // allow_url_include 'http://www.playnation.eu/protected/helper/MainHelper.php';
 //blizzardent_1322578999_2232.jpeg
 
  $game=new Games();
   $gameObj= $game-> getGameByID('1');
 $size='_100x100';
 $mainHelper = new MainHelper(); 
 $myImage = $mainHelper->showImage($gameObj, $size, false, array('no_img' => 'noimage/no_game'.$size.'.png'));
 print $myImage;
 echo $myImage;
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <a href="<?php $myImage?>" title="<?php $myImage?>"></a>
    </body>
</html>
