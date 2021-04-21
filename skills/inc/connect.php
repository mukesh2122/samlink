<?php //if( !defined('IN_SYSTEN')) exit('Du må ikke åbne denne side direkte')?>
<?php
session_start();
$host = "85.17.176.84";
$user = "playnation";
$pass = "WvoYWgR3oS5uUE";

mysql_connect ($host, $user, $pass);
mysql_select_db ("employees");// database navn, erstat med nyt
 

//==============================================================
if (isset($_GET["id"])){
$id = $_GET["id"];
}
if(isset($_GET["admin"])){
array_walk ($admin = $_GET["admin"]); 
}
if(isset($_GET["edit"])){
$edit = $_GET["edit"];
}
if(isset($_GET["don"])){
$don = $_GET["don"];
}
if (isset($_GET["delete"])){
$delete = $_GET["delete"];
}
if(isset($_GET["tilfoj"])){
$tilfoj = $_GET["tilfoj"];
}
if(isset($_GET["newid"])){
$newid = $_GET["newid"];
}
if(isset($_GET["fjern"])){
$fjern = $_GET["fjern"];
}
if (isset($_GET["EditDescription"])){
$EditDescription = $_GET["EditDescription"];
}
?>