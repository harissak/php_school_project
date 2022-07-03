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
$_SESSION['page']='membre';

if(isset($_SESSION['login'])){

    if(isset($_SESSION['role'])) {

        if($_SESSION['login']==='ok' && $_SESSION['role']==='admin'){
            include('../Templates/admin-control.php');
            $_SESSION['page']='membre';
        }
    }
}


$accessDB= new AccesDB();

if(isset($_SESSION['searchActive'])) {
    if($_SESSION['searchActive']){
        $text =   $_SESSION['textToSearch'];

        if($text !== ''){
            $membre = $accessDB->searchMembreTeble($text);
            $presentation = new Presentation();
            $presentation->membersList($membre);
            $_SESSION['searchActive']=null;
        } else {
            $membre = $accessDB->ListerLesMembre();
            $presentation = new Presentation();
            $presentation->membersList($membre);
        } 

    }
} else {

    $membre = $accessDB->ListerLesMembre();
    $presentation = new Presentation();
    $presentation->membersList($membre);
}



?>