<?php
include 'session.php';
include 'functions.php';
if(!isset($_SESSION['userId']) && !$_SESSION['isLogin']){
    header("location: login.php");
 }
$current_page = basename($_SERVER['PHP_SELF']);
$menus = read('menus','asc');
$subMenus = read('submenus', 'asc');
// echo $_SESSION['userId'];
// $userRole = readcolumn('users', 'role_id', $_SESSION['userId']);
$userPermissions =explode(",",  read_where('users',"id=".$_SESSION['userId'])[0]['permissions']);
// print_r($userPermissions);
$userMenus=[];
$userPages =[];
foreach($userPermissions as $per){
    $menuid= readcolumn('submenus',"menu_id",$per);
    $href = readcolumn('submenus',"href",$per);
 if(!in_array($menuid , $userMenus)){
    array_push($userMenus,$menuid);
 }
array_push($userPages,$href );

}

if(!in_array($current_page, $userPages)){
    header("location: 404.php");
}
include 'header.php';
include 'sidebar.php';
include 'topbar.php';
?>