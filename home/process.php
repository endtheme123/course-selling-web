<?php
session_start();  
include "../db_conn.php";
// echo $_POST['action']=="load_data";
$response = " ";
if($_POST['action']=="load_data"){


foreach($_POST["data"] as $ownership) {
    // echo;
    // system.out.println( $ownership['CID']);
    $sql = "SELECT * FROM course WHERE CourseID LIKE " . $ownership['CID'];
    // echo $sql;
    

    $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $response .= "<div  class = 'course'>
            <img src=". $row['CoverImage'] ." alt='gg'>
            <h3><b>".$row['CourseName'] ." </b></h3>
            <h4> <b>Batch: </b>".$ownership['batch']. "</h4>
            <h4> <b>Batch ID: </b>".$ownership['BatchID']. "</h4>
            <h4>".$row['Cost'] ."VND</h4>
            <h4> <b>Length: </b>".$row['Time']. " lectures</h4>
            <h4><b>Scholarship: </b>" .$row['Scholarship']."%</h4>";
            
    $sql2 = "SELECT * FROM courseownership WHERE UserID = ".$_SESSION['id']. " AND CourseID = ".$row['CourseID'];
         
      
        
      // echo $_GET['seach']);
      // echo $sql;
      $result2 = mysqli_query($conn, $sql2);
      if(mysqli_num_rows($result2)===0) {
          
     
        $response .="<button onclick='courseBuy(this.id)'  id='".$ownership['ID']."' class='button cbut' >Submit</button>";
             } else { 
              
                $response .="<p class='button submited'>Submitted</p>";
              } 
              $response .="</div>";
        }
}


} elseif ($_POST['action']=="search_data"){
  // echo isset($_POST["scholarship"]);
  echo empty($_POST["scholarship"]);

        $domains = empty($_POST["domain"]) ? array() : $_POST["domain"];
        $scholarship = empty($_POST["scholarship"]) ? 0 : 1;
        
    
        foreach($_POST["data"] as $ownership) {
            
            // echo $sql;
            $sql = "SELECT * FROM course WHERE CourseID LIKE " . $ownership['CID'];
        
        if($_POST["search"] != NULL) {
          $sql = $sql . " AND CourseName LIKE '%". $_POST["search"] ."%'";
        }
        if($domains ?? null) {
          $sql = $sql . " AND ( 1 = 0";
          foreach($domains as $domain) {
            $sql = $sql . " OR Tag LIKE '%$domain%'";
          }

          $sql = $sql . " ) ";
          
      }
      if($_POST['clim'] != NULL && $_POST['clim'] > 0)  {
       
        $sql = $sql . " AND Cost <= ".(int)$_POST['clim'];
      }
      
      
      if($_POST['tlimin']!= NULL ) {
        $sql = $sql . " AND Time >=". (int)$_POST['tlimin'];
      }
      
      if($_POST['tlimax']!=NULL && $_POST['tlimax'] > 0) {
        $sql = $sql . " AND Time <= ".(int)$_POST['tlimax'];
      }
      if(!empty($scholarship) ) {
        if((int)$scholarship === 1) {
          $sql = $sql . " AND Scholarship > 0";
        }
      }
        echo $sql;
            $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $response .= "<div  class = 'course'>
                    <img src=". $row['CoverImage'] ." alt='gg'>
                    <h3><b>".$row['CourseName'] ." </b></h3>
                    <h4> <b>Batch: </b>".$ownership['batch']. "</h4>
                    <h4> <b>Batch ID: </b>".$ownership['BatchID']. "</h4>
                    <h4>".$row['Cost'] ."VND</h4>
                    <h4> <b>Length: </b>".$row['Time']. " lectures</h4>
                    <h4><b>Scholarship: </b>" .$row['Scholarship']."%</h4>";
                    
            $sql2 = "SELECT * FROM courseownership WHERE UserID = ".$_SESSION['id']. " AND CourseID = ".$row['CourseID'];
                 
              
                
              // echo $_GET['seach']);
              // echo $sql;
              $result2 = mysqli_query($conn, $sql2);
              if(mysqli_num_rows($result2)===0) {
                  
             
                $response .="<button onclick='courseBuy(this.id)' id = '".$ownership['id']."' class='button cbut' >Submit</button>";
                     } else { 
                      
                        $response .="<p class='button submited'>Submitted</p>";
                      } 
                      $response .="</div>";
                }
        }
    } elseif ($_POST['action']=="load_owned_data"){ 
      $data = empty($_POST["data"]) ? array() : $_POST["data"];
      foreach($data as $ownership) {
        $sql3 = "select cos.UserID, DATE(cos.StartDate) as Sdate  , cos.Finish, DATE(cos.FinishDate) as Fdate ,c.CourseName
      from courseownership cos
      INNER JOIN course c on cos.CourseID = c.CourseID
      
      WHERE cos.UserID = ".$ownership["UID"];
          
      
        
      // echo isset($_GET['seach']);
      // echo $sql3;
        $result3 = mysqli_query($conn, $sql3);
  
  
        while ($row3 = mysqli_fetch_assoc($result3)) {
      
          
      $response .= "<a href=''>
      
        <h4>". $row3['CourseName']."</h4>
        <hr>
        <p><b>Starting Date: </b>".$row3['Sdate']."</p>
        <p><b>Finishing Date: </b>".($row3['Fdate']==Null ? 'Not Yet' : $row3['Fdate'])."</p>
        <p><b>Status: </b> ".($row3['Finish'] === 1 ? 'Finished' : 'Studying') ."</p>
        
      
      </a>";

    }
      }
      
  }
    
      

echo $response;
?>