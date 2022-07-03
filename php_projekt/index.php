<?php

require_once 'Model/AccesDB.php';
require_once 'Model/DB_mySqli.php';
session_start();

$conn =   DB_mySqli::getInstance();


if(isset($_SESSION['login'])){
    if($_SESSION['login'] === 'ok'){
       
        include('Templates/log-out-header.php');
    } else {

        include('Templates/header-login.php');
    }
   
} else {
    include('Templates/header-login.php');
}

include('Templates/header.php');

echo '
 
<table class="content-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>NOM</th>
        <th>PRENOM</th>
        <th>CLUB</th>
        <th>CATEGORIE</th>
        <th>POINTS</th>
    </tr>
</thead>
</table>
 ';

$query = "select membre.id as id, membre.nom, membre.prenom, club.nom as club, categorie.nom as categorie, sum(participer.score) as points
            from (((membre INNER JOIN club on membre.codeClub=club.id) 
            INNER JOIN categorie on membre.categorie = categorie.id)
            inner join participer on membre.id = participer.id_membre)
            group by membre.id
            order by categorie.id, points desc;";
$result = $conn->query($query);

if(!$result) {
$conn->close();
die("error");
}

while($row = mysqli_fetch_assoc($result)) {
   
   
    $id = $row['id'];
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $club = $row['club'];
    $categorie = $row['categorie'];
    $points = $row['points'];

    echo <<<__END
    <table class="content-table">
    <tbody>
    <tr>
        <td>$id</td>
        <td>$nom</td>
        <td>$prenom</td>
        <td>$club</td>
        <td>$categorie</th>
        <td>$points</th>
    </tr>
    </tbody>
    </table>
    __END;


}



?>