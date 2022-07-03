<?php

require_once 'DB_mysqli.php';


class AccesDB {
    private $connection;

    public function requet (string $sql) {
        $this->connection = DB_mySqli::getInstance();

        return $this->connection->query($sql);
    } 



    //lister les categories
    public function ListerLesCategories($table) {
        $conn=DB_mySqli::getInstance();
        $lesCategoriesDisp = array();

        $result = $this->selectAll($table);  
         
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $cat = new $table();
                $this->setValue($cat, $row);
                $lesCategoriesDisp[]= $cat;


            }
        return $lesCategoriesDisp;

    }

    //lister les turnoi
    public function ListerLesTurnoi() {
        $conn=DB_mySqli::getInstance();
        $lesTurnoiDisp = array();


        $query="select turnoi.id, turnoi.turnoiCode, turnoi.dtturnoi, categorie.nom as nomCategorie, club.nom as codeClub 
        from ((turnoi inner join categorie on turnoi.nomCategorie = categorie.id)
        inner join club on turnoi.codeClub = club.id)";

        $result = $conn->query($query); 

        if(!$result) {

            $conn->close();
            die("error");
        }

        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $cat = new turnoi();
                $this->setValue($cat, $row);
                $lesTurnoiDisp[]= $cat;


            }
        return $lesTurnoiDisp;

    }

    //lister les results
    public function ListerLesResult() {

        
        require_once '../Controller/participer.php';
        $conn=DB_mySqli::getInstance();
        $lesResultDisp = array();


        $query="select participer.id, membre.nom as id_membre, turnoi.turnoiCode as id_turnoi, participer.score 
        from ((participer inner join membre on participer.id_membre = membre.id)
        inner join turnoi on participer.id_turnoi = turnoi.id)
        order by participer.id_turnoi, participer.score desc";

        $result = $conn->query($query); 

        if(!$result) {

            $conn->close();
            die("error");
        }

        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $res = new participer();
                $this->setValue($res, $row);
                $lesResultDisp[]= $res;


            }
        return $lesResultDisp;

    }

    public function ListerLesClub() {

        
        require_once '../Controller/club.php';

        $conn=DB_mySqli::getInstance();
      
        $query="select club.id, club.nom, club.codePostal, club.localite, club.rue, membre.nom as responsable
        from club inner join membre on club.responsable = membre.id";

        $result = $conn->query($query); 

        
        return $result;

    }

    //lister les membre
    public function ListerLesMembre() {
        $conn=DB_mySqli::getInstance();
        $membreList = array();


        $query= "select membre.id,membre.nom,membre.prenom,membre.codePostal, membre.localite, membre.rue, membre.gsm, membre.dateDeNaissance, membre.serie, categorie.nom as categorie, club.nom as codeClub, membre.totalPointsSaison, membre.moteDePass, membre.email
        FROM ((membre INNER JOIN categorie ON membre.categorie =categorie.id) INNER JOIN club ON membre.codeClub = club.id)";  
        
        $result = $conn->query($query); 

            if(!$result) {

                $conn->close();
                die("error");
            }

        
            
            $rows= $result->num_rows;
            for($i=0; $i<$rows; ++$i) {

                $row=$result->fetch_array(MYSQLI_ASSOC);

                    $membre = new membre();
                    $this->setValue($membre, $row);
                    $membreList[]= $membre;


                }
            return $membreList;

    }

    //lister les joudges
    public function ListerLesJudgearbitre() {

        require_once '../Controller/judgearbitre.php';

        $conn=DB_mySqli::getInstance();
        $lesJudgeDisp = array();

        $query = "select judgearbitre.id, membre.nom as id_membre
        from judgearbitre inner join membre on judgearbitre.id_membre = membre.id";

        $result = $conn->query($query); 

        if(!$result) {

            $conn->close();
            die("error in connection to database");
        }
         
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $judge = new judgearbitre();
                $this->setValue($judge, $row);
                $lesJudgeDisp[]= $judge;


            }
        return $lesJudgeDisp;

    }

    //lister les administrateurs
    public function ListerLesAdministrateurs() {
        require_once '../Controller/administrateur.php';
        $conn=DB_mySqli::getInstance();
        $lesAdminsDisp = array();

        $query = "select administrateur.id, membre.nom as id_membre
        from administrateur inner join membre on administrateur.id_membre = membre.id";

        $result = $conn->query($query); 

        if(!$result) {

            $conn->close();
            die("error");
        }
         
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $admin = new administrateur();
                $this->setValue($admin, $row);
                $lesAdminsDisp[]= $admin;


            }
        return $lesAdminsDisp;

    }

    //select everything from tables
    public function selectAll ($table) {

        $conn=DB_mySqli::getInstance();
        $query = "SELECT * FROM $table";
        $result = $conn->query($query); 

        if(!$result) {

            $conn->close();
            die("error");
        }

        return $result;

    }

    //set values to construct
    public function setValue ($object, $row) {
        foreach($row as $key => $value) {

            $setter = 'set'. ucfirst($key);
            if(method_exists($object, $setter)){
                $object->$setter(htmlspecialchars($value));
            } else {
                printf('Error', $setter);
            }
        }
    }

    //delete from table 
    public function deleteFromTable($id, $tableDelete){
        $conn=DB_mySqli::getInstance();
        $query = "delete FROM ".$tableDelete." where id = ".$id;
        $result = $conn->query($query); 

        if(!$result) {
            $conn->close();
            die("error");
            } else {
 
                switch ($tableDelete) {

                    case 'categorie':
                      header("Location: ../View/categories-view.php");
                      break;

                    case 'club':
                      header("Location: ../View/club-view.php");
                         break;
                    case 'membre':
                        header("Location: ../View/membre-view.php");
                           break;
                    case 'turnoi':
                        header("Location: ../View/turnoi-view.php");
                           break;
                    case 'administrateur':
                        header("Location: ../View/administration-view.php");
                             break;
                    case 'judgearbitre':
                         header("Location: ../View/administration-view.php");
                            break;              

                    default:
                    echo" Something went wrong";
                    }

                $conn->close();
            }
    }

    //insert new categorie
    public function newCategorie ($nom, $ageMin, $ageMax) {
        $conn=DB_mySqli::getInstance();
        $query = "INSERT INTO categorie (nom, ageMin,ageMax) values ('".$nom."','".$ageMin."','".$ageMax."');";
        $result = $conn->query($query); 
        $conn->close();

        return $result;
    }

    //update categorie
    public function updateCategorie($id, $nom, $ageMin, $ageMax) {
        $conn=DB_mySqli::getInstance();
        $query= "UPDATE categorie SET nom ='$nom',ageMin='$ageMin',ageMax='$ageMax' WHERE id = ".$id;
        $result = $conn->query($query); 
        $conn->close();

        return $result;
    }

    //insert new member
    public function newMembre ($nom, $prenom, $codePostal,$localite, $rue, $gsm, $dateDeNaissance, $serie, $categorie,$codeClub, $moteDePass, $email) {

        $conn=DB_mySqli::getInstance();
        $query = "INSERT INTO membre (nom, prenom, codePostal, localite, rue, gsm, dateDeNaissance, serie, categorie, codeClub, totalPointsSaison, moteDePass, email)
         values ('".$nom."','".$prenom."','".$codePostal."','".$localite."','".$rue."','".$gsm."','".$dateDeNaissance."','".$serie."','".$categorie."','".$codeClub."','0','".$moteDePass."','".$email."');";
        $result = $conn->query($query); 
        $conn->close();

        return $result;
    }

    //update membre
    public function updateMembre($id,$nom, $prenom, $codePostal,$localite, $rue, $gsm,$dateDeNaissance, $serie, $categorie,$codeClub, $moteDePass, $email, $totalPointsSaison) {
        $conn=DB_mySqli::getInstance();
        $query= "UPDATE membre SET nom ='$nom',prenom='$prenom',codePostal='$codePostal',localite ='$localite',rue='$rue',gsm='$gsm',dateDeNaissance ='$dateDeNaissance',serie='$serie',categorie='$categorie',codeClub ='$codeClub',moteDePass='$moteDePass',email='$email',totalPointsSaison ='$totalPointsSaison' 
        WHERE id = ".$id;
        $result = $conn->query($query); 
        $conn->close();

        return $result;
    }

    //insert club
    public function newClub($nom, $cpl,$ville,$rue,$responsable){
        $conn=DB_mySqli::getInstance();
        $query = "INSERT INTO club (nom, codePostal, localite, rue,responsable)
         values ('".$nom."','".$cpl."','".$ville."','".$rue."','".$responsable."');";
        $result = $conn->query($query); 
        $conn->close();

        return $result;

    }

    //update club
    public function updateClub($id,$nom, $cpl,$ville,$rue,$responsable){

        $conn=DB_mySqli::getInstance();
        $query= "UPDATE club SET nom ='$nom',codePostal='$cpl',localite ='$ville',rue='$rue',responsable='$responsable' WHERE id = ".$id;
        $result = $conn->query($query); 
        $conn->close();

        return $result;
    }

    //new turnoi
    public function newTurnoi ($codeTurnoi,$dtt,$nomCat,$codeClub){
        $conn=DB_mySqli::getInstance();
        $query = "INSERT INTO turnoi (codeTurnoi,dt_turnoi, nomCategorie,codeClub)
         values ('".$codeTurnoi."','".$dtt."','".$nomCat."','".$codeClub."');";
        $result = $conn->query($query); 
        $conn->close();

        return $result;

    }

    //update turnoi
    public function updateTurnoi ($id,$codeTurnoi,$dtt,$nomCat,$codeClub){

        $conn=DB_mySqli::getInstance();
        $query= "UPDATE turnoi SET dtturnoi ='$dtt',nomCategorie='$nomCat',turnoiCode='$codeTurnoi',codeClub ='$codeClub' WHERE id = ".$id;
        $result = $conn->query($query); 
        $conn->close();

        return $result;
    }

     //new admin-judge
     public function newJudgeAdmin($id_membre,$table){
        $conn=DB_mySqli::getInstance();
        $query = "INSERT INTO $table (id_membre)values ('".$id_membre."');";
        $result = $conn->query($query); 
        $conn->close();

        return $result;
 

    }

     //update admin-judge
     public function updateJudgeAdmin($id,$id_membre,$table){
        $conn=DB_mySqli::getInstance();
        $query = "UPDATE $table SET id_membre ='$id_membre' WHERE id = ".$id;
        $result = $conn->query($query); 
        $conn->close();

        return $result;
 

    }

    //new result
    public function newResult ($nom, $turnoi, $score) {
       
        $conn=DB_mySqli::getInstance();
        $query = "INSERT INTO participer (id_membre, id_turnoi, score)values ('".$nom."','".$turnoi."','".$score."');";
        $result = $conn->query($query); 
        $conn->close();

        return $result;
 
    }

    //update result
    public function updateResult ($id,$nom, $turnoi, $score) {

        $conn=DB_mySqli::getInstance();
        $query = "UPDATE participer SET id_membre ='$nom',id_turnoi ='$turnoi',score ='$score'  WHERE id = ".$id;
        $result = $conn->query($query); 
        $conn->close();

        return $result;
    }

    //search categories 
    public function searchTables ($text) {
        $conn=DB_mySqli::getInstance();
        $query= "SELECT * FROM categorie WHERE id LIKE '%$text%' OR nom LIKE '%$text%' OR ageMin LIKE '%$text%' OR ageMax LIKE '%$text%'";
        $result = $conn->query($query); 
        $lesCategoriesDisp = array();
       
        if(!$result) {

            $conn->close();
            die("error ovdje");
        } 
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $categorie = new categorie();
                $this->setValue($categorie, $row);
                $lesCategoriesDisp[]= $categorie;


            }

            return $lesCategoriesDisp;

       
    }

    //search membre
    public function searchMembreTeble ($text) {

        $conn=DB_mySqli::getInstance();

        $query= "SELECT * FROM membre WHERE id LIKE '%$text%' OR nom LIKE '%$text%' 
        OR prenom LIKE '%$text%' OR codePostal LIKE '%$text%' OR localite LIKE '%$text%'
        OR rue LIKE '%$text%' OR gsm LIKE '%$text%' OR categorie LIKE '%$text%'
        OR codeClub LIKE '%$text%' OR totalPointsSaison LIKE '%$text%'";

        $result = $conn->query($query); 
        $lesMembreList = array();
        
        if(!$result) {

            $conn->close();
            die("Error search membre");
        } 
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $membre = new membre();
                $this->setValue($membre, $row);
                $lesMembreList[]= $membre;


            }

            return $lesMembreList;
    }

    // search club
    public function searchClubTable ($text) {

        $conn=DB_mySqli::getInstance();
        $query= "SELECT * FROM club WHERE id LIKE '%$text%' OR nom LIKE '%$text%' 
        OR codePostal LIKE '%$text%' OR localite LIKE '%$text%'
        OR rue LIKE '%$text%' OR responsable LIKE '%$text%'";
      
      $result = $conn->query($query); 

      if(!$result) {

          $conn->close();
          die("error");
      }

      return $result;

            
    }

    //search admin
    public function searchAdministrateurTable ($text) {
        $conn=DB_mySqli::getInstance();
        $query= "SELECT * FROM administrateur WHERE id LIKE '%$text%'";
        $result = $conn->query($query); 
        $lesAdminList = array();
        if(!$result) {

            $conn->close();
            die("Error search membre");
        } 
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $administrateur = new administrateur();
                $this->setValue($administrateur, $row);
                $lesAdminList[]= $administrateur;


            }

            return $lesAdminList;
    }

    //search judge
    public function searchJudgeTable ($text) {
        $conn=DB_mySqli::getInstance();
        $query= "SELECT * FROM judgearbitre WHERE id LIKE '%$text%'";
        $result = $conn->query($query); 
        $lesJudgeList = array();
        if(!$result) {

            $conn->close();
            die("Error search membre");
        } 
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $judgearbitre = new judgearbitre();
                $this->setValue($judgearbitre, $row);
                $lesJudgeList[]= $judgearbitre;


            }

            return $lesJudgeList;
    }

    //search turnoi
    public function searchTurnoiTable ($text) {
      
        $conn=DB_mySqli::getInstance();
       
       $query= "SELECT * FROM turnoi WHERE id LIKE '%$text%' OR dtturnoi LIKE '%$text%' OR nomCategorie LIKE '%$text%' OR codeClub LIKE '%$text%'";
        $result = $conn->query($query); 
        $lesTurnoiList = array();
      
        if(!$result) {

            $conn->close();
            die("Error search turnoi");
        } 

        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $turnoi = new turnoi();
                $this->setValue($turnoi, $row);
                $lesTurnoiList[]= $turnoi;


            }

            return $lesTurnoiList;
    }

    //search participant
    public function searchResultTable($text) {

        
        require_once '../Controller/participer.php';

        $conn=DB_mySqli::getInstance();
        $query= "SELECT * FROM participer WHERE id LIKE '%$text%' OR id_membre LIKE '%$text%' 
        OR score LIKE '%$text%' OR id_turnoi LIKE '%$text%'";
        $result = $conn->query($query); 
        $lesParticipentList = array();
        if(!$result) {

            $conn->close();
            die("Error search result");
        } 
        $rows= $result->num_rows;
           for($i=0; $i<$rows; ++$i) {

            $row=$result->fetch_array(MYSQLI_ASSOC);

                $participer = new participer();
                $this->setValue($participer, $row);
                $lesParticipentList[]= $participer;


            }

            return $lesParticipentList;
    }

    public function checkEmail ($email) {
        $conn=DB_mySqli::getInstance();
        $query= "select * FROM membre WHERE email LIKE '%$email%'";
        $result = $conn->query($query); 
        
        $rows= $result->num_rows;

        return $rows;       
          
    }

    public function getPoints($email) {

        $conn=DB_mySqli::getInstance();
        $query= "SELECT * FROM MEMBRE WHERE email = '$email'";
        $select_user_points = mysqli_query($conn, $query);
        $points=0;

        while($row = mysqli_fetch_array($select_user_points)) {
            $points = $row['totalPointsSaison'];
  
        }

        return $points;
    }


    //new season
    public function startNewSeason() {

        $conn=DB_mySqli::getInstance();
        $query = "delete FROM participer";
        $query2 = "delete FROM turnoi";

        
        $result = $conn->query($query); 

        if(!$result) {

            $conn->close();
            die("error query 1");
        }

        $result = $conn->query($query2); 

        if(!$result) {

            $conn->close();
            die("error query 2");
        }


        return $result;

    }
   
}

?>