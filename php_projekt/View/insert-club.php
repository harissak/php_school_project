<?php


require_once '../Model/DB_mySqli.php';

session_start();
include('../Templates/header-subcat.php');
$conn =   DB_mySqli::getInstance();
 
if(isset($_SESSION['isUpdate'])){
    if($_SESSION['isUpdate']){

       $id=  $_SESSION['id'];
        $query = "select * FROM club where id = ".$id;
        $result = $conn->query($query);
       
       if(!$result) {
        $conn->close();
        die("error");
        }

        while($row = mysqli_fetch_assoc($result)) {
        
           
            $codePostal = $row['codePostal'];
            $localite = $row['localite'];
            $nom = $row['nom'];
            $rue = $row['rue'];
            $responsable = $row['responsable'];

            echo
            <<<__END
            <div class="loginbox">
                <h3>scrabble</h3>
        
                    <form action="../Controller/requests.php" method="post">  
                    <input type="text" name="nom" placeholder="Nom du categorie" value="$nom" required> 
                    <input type="number" name="codePostal" placeholder="Code Postal" value="$codePostal"required>
                    <input type="text" name="localite" placeholder="Localite" value="$localite"required>
                    <input type="text" name="rue" placeholder="Rue" value="$rue"required>
                    <input type="text" name="responsable" placeholder="Responsable" value="$responsable"required>
                    <button type="submit" name="updateClub">Submit</button>
                
                    </form>
            </div>
            __END;
           
         }

         $_SESSION['isUpdate']=null;
         $conn->close();
   } else {
        echo "Error read session";
        $_SESSION['isUpdate']=null;
        $_SESSION['id']=null;
    }
} else { 
echo
'   
<div class="loginbox">
    <h3>scrabble</h3>
   
    <form action="../Controller/requests.php" method="post">  
                    <input type="text" name="nom" placeholder="Nom du categorie" required> 
                    <input type="number" name="codePostal" placeholder="Code Postal" required>
                    <input type="text" name="localite" placeholder="Localite" required>
                    <input type="text" name="rue" placeholder="Rue" required>
                    <input type="text" name="responsable" placeholder="Responsable" required>
                    <button type="submit" name="insertClub">Submit</button>
                
    </form>
</div>';}
?>