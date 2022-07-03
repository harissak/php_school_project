<?php
session_start();


$_SESSION['isUpdate']=true;

if(!empty($_GET['id'])) {
    

    $_SESSION['id']=$_GET['id'];

    if($_SESSION['table']==='categorie'){
        header("Location: ../View/insert-categorie.php");

    } else if($_SESSION['table']==='membre'){
        header("Location: ../View/insert-membre.php");

    }else if($_SESSION['table']==='club'){
        header("Location: ../View/insert-club.php");

    }else if($_SESSION['table']==='turnoi'){
        header("Location: ../View/insert-turnoi.php");

    }else if($_SESSION['table']==='participant'){
        header("Location: ../View/insert-participant.php");

    }else if($_SESSION['table']==='administrateur'){
        header("Location: ../View/insert-judgeAdmin.php");
        $_SESSION['admin-judge']='administrateur';

    }else if($_SESSION['table']==='judgearbitre'){
        header("Location: ../View/insert-judgeAdmin.php");
        $_SESSION['admin-judge']='judgearbitre';

    } else if($_SESSION['table']==='participer'){
        header("Location: ../View/insert-result.php");

    }else {
        echo "UPDATE TABLE DOES NOT EXIST";
    }



} else {
    echo "GET METHOD UPDATE empty";
}

?>