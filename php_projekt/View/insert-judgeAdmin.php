<?php


require_once '../Model/DB_mySqli.php';
require_once '../Model/AccesDB.php';


session_start();

include('../Templates/header-subcat.php');


$conn =   DB_mySqli::getInstance();
$accessDB= new AccesDB();

$list= $accessDB->selectAll('membre');
$table = $_SESSION['table'];
 
if(isset($_SESSION['isUpdate'])){
    if($_SESSION['isUpdate']){

       $id=  $_SESSION['id'];
        $query = "SELECT * FROM $table where id = ".$id;
        $result = $conn->query($query);
       
       if(!$result) {
        $conn->close();
        die("error update arbitre/membre");
        }

        while($row = mysqli_fetch_assoc($result)) {
        
           
            $id_membre = $row['id_membre'];

            echo <<<__END

                    <div class="loginbox">
                        <h3>scrabble</h3>
                
                            <form action="../Controller/requests.php" method="post"> 
                    __END; 
                    
                            echo'  <select name="id_membre" required>
                                    <option selected="selected" value="">Select membre</option>'; 
                                        while($row = mysqli_fetch_assoc($list)){
                                            echo "<option value='{$row['id']}'>{$row['id']} {$row['nom']} {$row['prenom']}</option>";
                                        }
                            echo '</select>';

                echo <<<__END
                        <button type="submit" name="updateJudgeAdmin">Submit</button>
                        
                            </form>
                    </div>
                    __END;
                
         }

         $conn->close();
   } else {
        echo "session problems";
    }
} else { 
        echo
        ' <div class="loginbox">
            <h3>scrabble</h3>
            <form action="../Controller/requests.php" method="post">'; 

        echo'  <select name="id_membre" required>
                <option selected="selected" value=""}>Select membre</option>'; 
                   
                while($row = mysqli_fetch_assoc($list)){
                    echo "<option value='{$row['id']}'>{$row['id']} {$row['nom']} {$row['prenom']}</option>";
                 }

                echo '</select>';
            
        echo '<button type="submit" name="insertJudgeAdmin">Submit</button>
                </form>
                </div>';
    }
?>