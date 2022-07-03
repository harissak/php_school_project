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

if(isset($_SESSION['login'])){

    if(isset($_SESSION['role'])) {

        if($_SESSION['login']==='ok' && $_SESSION['role']==='admin'){
            include('../Templates/admin-control.php');
            $_SESSION['page']='judgearbitre';
        }
    }
}


$accessDB= new AccesDB();
$judge = $accessDB->ListerLesJudgearbitre();
$presentation = new Presentation();
$presentation->judgeList($judge);

?>