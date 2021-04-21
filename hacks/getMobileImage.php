<?php
include 'protected/helper/MainHelper.php';

 $_id=$_POST['objID'];
 $obj=$_POST['obj'];
 $size=$_POST['imageSize'];
$game;
$gameObj;
 if($obj=='games'){
  $game=new Games();
   $gameObj= $game-> getGameByID($_id);   
 }elseif($obj=='player'){
    $game=new User();
   $gameObj= $game-> getById($_id);   
 }elseif($obj=='company'){
    $game=new Companies();
   $gameObj= $game-> getCompanyByID($_id);     
 }elseif($obj=='news'){
      $game=new News();
   $gameObj= $game-> getArticleByID($_id,0);     
 }elseif($obj=='wall'){
      $game=new Wall();
   $gameObj= $game-> getPost($_id,false);      
 }elseif($obj=='group'){
    $game=new Groups();
   $gameObj= $game-> getGroupByID($_id);     
 }
  
$mainHelper = new MainHelper(); 
$myImage = $mainHelper->showImage($gameObj, $size);
print(json_encode($myImage));
?> 

