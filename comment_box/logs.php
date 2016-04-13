<?php
    session_start();
        
    if(isset($_COOKIE['username'])){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['usertype'] = $_COOKIE['usertype'];
    }

    if(isset($_GET['function'])){
        $action = $_GET['function'];
        if($action=="getsession"){
          function getSession(){
              if(isset($_SESSION['username'])){
                  $rows =  array("name" => $_SESSION['username'],
                                          "type" =>$_SESSION['usertype']);
                  echo JSON_encode($rows);
              }else{
                  $rows = array();
                  echo json_encode($rows);
              }
          }
        }else if($action=="logout"){
          function logout(){
               if(isset($_SESSION['username'])){
                  session_unset();
                  session_destroy();
                  if(isset($_COOKIE["username"])){
                      unset($_COOKIE["username"]);
                      unset($_COOKIE['usertype']);
                      setcookie('username', '', time() - 3600, '/');
                      setcookie('usertype', '', time() - 3600, '/');
                  }
                  echo "Logged Out!";
              }else{
                 
              }
            }
        }
    }    
?>
<?php

require("db/db.php");
$result = mysqli_query($con, "SELECT * FROM comments ORDER BY id ASC");
while($row=mysqli_fetch_array($result)){
echo "<div class='comments_content'>";
if($_SESSION["Username"] == $row['name']){
echo "<h4><a href='delete.php?id=" . $row['id'] . "'> X</a></h4>";
}else{
	echo "";
}
echo "<h1>" . $row['name'] . "</h1>";
echo "<h2>" . $row['date_publish'] . "</h2>";
echo "<h3>" . $row['comments'] . "</h3>";
echo "</div>";
}
mysqli_close($con);

?>