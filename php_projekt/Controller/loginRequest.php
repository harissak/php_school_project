<?php include '../Model/DB_mySqli.php'; ?>

<?php
session_start();

$connection= DB_mySqli::getInstance();


    if(isset($_POST['submit'])) {
      $username = $_POST['username'];
      $password = $_POST['password']; 


      $username = mysqli_real_escape_string($connection, $username);
      $password = mysqli_real_escape_string($connection, $password);
      

      $query= "SELECT * FROM MEMBRE WHERE email = '{$username}'";
      $select_user_query = mysqli_query($connection, $query);

      $queryAdmin= "SELECT * FROM administrateur";
      $select_admin_query = mysqli_query($connection, $queryAdmin);


      if(!$select_user_query || !$select_admin_query){

        die("QUERY FAILED". mysqli_error($connection));

      }

      while($row = mysqli_fetch_array($select_user_query)) {
          $user = $row['email'];
          $pass = $row['moteDePass'];
          $id = $row['id'];
          $_SESSION['id']=$id;

      }


      while($row = mysqli_fetch_array($select_admin_query)) {
 
        $adminID = $row['id_membre'];
       


    }


      if($username !== $user || $password !== $pass) {
            
        header("Location: ../View/login-view.php");
            

      } else {

        if($_SESSION['id']=== $adminID){
          header("Location: ../index.php");
        $_SESSION['role']= 'admin';
        $_SESSION['login']='ok';
        } else {
          header("Location: ../index.php");
        $_SESSION['role']= 'membre';
        $_SESSION['login']='ok';
        }

       
      }
    }

    
?>