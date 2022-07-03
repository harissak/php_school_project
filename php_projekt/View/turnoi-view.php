<?php
require_once '../Model/AccesDB.php';
require_once '../Model/DB_mySqli.php';
require_once 'presentation.php';

$conn =   DB_mySqli::getInstance();


if(isset($_SESSION['login'])){
    if($_SESSION['login'] === 'ok'){
       
        include('../Templates/header-sub-logout.php');
    } else {

        include('../Templates/header-login-subcat.php');
    }
   
} else {
    include('../Templates/header-login-subcat.php');
}


include('../Templates/header-subcat.php');
include('../Templates/search.php');
$_SESSION['page']='turnoi';

if(isset($_SESSION['login'])){

    if(isset($_SESSION['role'])) {

        if($_SESSION['login']==='ok' && $_SESSION['role']==='admin'){
            include('../Templates/admin-control.php');
            $_SESSION['page']='turnoi';
        }
    }
}

$accessDB= new AccesDB();


if(isset($_SESSION['searchActive'])) {
    if($_SESSION['searchActive']){
        $text =   $_SESSION['textToSearch'];

        if($text !== ''){
            $result = $accessDB->searchTurnoiTable($text);
            $presentation = new Presentation();
            $presentation->turnoiList ($result);
            $_SESSION['searchActive']=null;
        } else {
            $turnoi = $accessDB->ListerLesTurnoi();
            $presentation = new Presentation();
            $presentation->turnoiList($turnoi);

        } 

    }
} else {

    $turnoi = $accessDB->ListerLesTurnoi();
    $presentation = new Presentation();
    $presentation->turnoiList($turnoi);

}


?>