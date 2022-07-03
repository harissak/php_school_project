<?php
session_start();




    if(isset($_POST['insert'])) {
      $table = $_SESSION['page'];


      if($table === 'categorie') {
            
        header("Location: ../View/insert-categorie.php");
            

      } else if($table === 'membre') {
            
        header("Location: ../View/insert-membre.php");
            

      } else if($table === 'club') {
            
        header("Location: ../View/insert-club.php");
            

      } else if($table === 'administrateur') {
            
        header("Location: ../View/insert-judgeAdmin.php");
            

      } else if($table === 'judgearbitre') {
            
        header("Location: ../View/insert-judgeAdmin.php");
            

      } else if($table === 'turnoi') {
            
        header("Location: ../View/insert-turnoi.php");
            
      }else if($table === 'participer') {
            
        header("Location: ../View/insert-result.php");
            
      }


      } 

    
?>