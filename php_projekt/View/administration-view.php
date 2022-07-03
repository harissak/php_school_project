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
            $_SESSION['page']='administrateur';
            echo <<<__END
                    <form action="../Controller/newSeason.php" method="post">  
                        <input type="submit" name="newSeason" value="Start new season"> 
                        
                    </form>
                 __END;
        }
    }
}



$accessDB= new AccesDB();

$admin= $accessDB->ListerLesAdministrateurs();
$presentation = new Presentation();
$presentation->adminList($admin);



?>