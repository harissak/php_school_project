<?php require_once '../Model/AccesDB.php'; ?>

<?php
session_start();

$id='';


if(!empty($_GET['id'])) {

    $id=$_GET['id'];

    $table = $_SESSION['table'];
    
    $delete = new AccesDB();
    $delete->deleteFromTable($id,$table);
    $_SESSION['id']=null;
    $_SESSION['table']=null;


} else {
    echo "GET METHOD empty";
}

?>