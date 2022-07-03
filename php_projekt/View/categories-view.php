<?php


require_once '../Model/AccesDB.php';
require_once '../Model/DB_mySqli.php';
require_once '../Controller/categorie.php';
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
$_SESSION['page']='categorie';

if(isset($_SESSION['login'])){

    if(isset($_SESSION['role'])) {

        if($_SESSION['login']==='ok' && $_SESSION['role']==='admin'){
            include('../Templates/admin-control.php');
            $_SESSION['page']='categorie';
        }
    }
}

$accessDB= new AccesDB();

if(isset($_SESSION['searchActive'])) {
    if($_SESSION['searchActive']){
        $text =   $_SESSION['textToSearch'];

        if($text !== ''){
            $categories = $accessDB->searchTables($text);
            $presentation = new Presentation();
            $presentation->catdisp($categories);
            $_SESSION['searchActive']=null;
        } else {
            $categories = $accessDB->ListerLesCategories("categorie");
            $presentation = new Presentation();
            $presentation->catdisp($categories);
        } 

    }
} else {

    $categories = $accessDB->ListerLesCategories("categorie");
    $presentation = new Presentation();
    $presentation->catdisp($categories);
}

/*
echo <<<__END

<table class="content-table">
    <tr>
    <thead>
        <th>ID</th>
        <th>NOM</th>
        <th>Age minimum</th>
        <th>Age maximum</th>
        <th>AKTION</th>
    </tr>
    </thead>
    </table>



__END;



$query = "SELECT * FROM categorie";
$result = $conn->query($query);

if(!$result) {
$conn->close();
die("error");
}

while($row = mysqli_fetch_assoc($result)) {
   
    $id = $row['id'];
    $maxAge = $row['ageMax'];
    $minAge = $row['ageMin'];
    $nom = $row['nom'];

    echo <<<__END
    <table class="content-table">
    <tbody>
    <tr>
        <td>$id</th>
        <td>$nom</th>
        <td class="table-center">$minAge</th>
        <td class="table-center">$maxAge</th>
        <td class="aktion-buttons"> <form action="../Controller/loginRequest.php" method="post"> 
        <input type="button" name="delete" value="delete">
        <input type="button" name="update"  value="update">
        
        </form>
        </td>
    </tr>
    </tbody>
    </table>
    
    __END;


}
*/

?>