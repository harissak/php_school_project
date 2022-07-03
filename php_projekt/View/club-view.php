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
$_SESSION['page']='club';

if(isset($_SESSION['login'])){

    if(isset($_SESSION['role'])) {

        if($_SESSION['login']==='ok' && $_SESSION['role']==='admin'){
            include('../Templates/admin-control.php');
            $_SESSION['page']='club';
        }
    }
}

$access = new AccesDB();

if(isset($_SESSION['searchActive'])) {
    if($_SESSION['searchActive']){
        $text =   $_SESSION['textToSearch'];

        if($text !== ''){
                   
            $result = $access->searchClubTable($text);
            $presentation = new Presentation();
            $presentation->clubList ($result);
            $_SESSION['searchActive']=null;
        } else {
            $result = $access->ListerLesClub();
            $presentation = new Presentation();
            $presentation->clubList ($result);
        } 

    }
} else {

    $result = $access->ListerLesClub();
    $presentation = new Presentation();
    $presentation->clubList ($result);
}



?>