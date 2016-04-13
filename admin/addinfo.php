<?php 
    $dbhost = 'localhost';
    $dbuser = 'drugs';
    $dbpass = 'drugs';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    
    if(! $conn ) {
       die('Could not connect: ' . mysql_error());
    }

?>
<?php
session_start();
require_once '../signup-email-verification/class.user.php';
$user_home = new USER();


$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $_SESSION['username'] = $username;
        
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
   if ($_SESSION['userSession'] != true && $row['userEmail'] != "calvin@hyphen.hk") {
         header("Location: /drugs/"); /* Redirect browser */
   }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/templatemo-style.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>     
    <title>Drugs</title>
</head>
   
   <body>
      <?php
         if(isset($_POST['add'])) {

            if(! get_magic_quotes_gpc() ) {
               $name = addslashes ($_POST['name']);
               $detail = addslashes ($_POST['detail']);
            }else {
               $name = $_POST['name'];
               $detail = $_POST['detail'];
            }
            
            $effects = $_POST['effects'];
            $type = $_POST['type'];
            
            $sql = "INSERT INTO drugs ". "(name,detail, effects,type,
               date_publish) ". "VALUES('$name','$detail','$effects','$type', NOW())";
               
            mysql_select_db('drugs');
            $retval = mysql_query( $sql, $conn );
            
            if(! $retval ) {
               die('Could not enter data: ' . mysql_error());
            }
            
            echo "<h2 class='main-title text-center dark-blue-text' style='font-size:56px;'>Entered data successfully\n</h2>";
            echo "<meta http-equiv='refresh' content='1;/drugs/admin/addinfo.php'>";
            mysql_close($conn);
         }else {
            ?>

    <div class="fixed-header">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand" href="#">Drugs</a>
            </div>
            <nav class="main-menu">
                <ul>
                    <li><a class='external' href="/drugs/">Home</a></li>
                    <li><a class='external current' href="addinfo.php">Add Drugs</a></li>
                    <li><a class='external' href="addcenter.php">Add Center</a></li>
                    <li><a class='external' href="youtube.php">Add Video</a></li>
                    <li><a class='external' href="/drugs/file-upload/index.php">Upload Files</a></li>
<!--
                    <?php
	                	if($_SESSION['LoggedIn']["Username"] == "admin"){
		                	echo "<li><a class='external' href='/drugs/admin/'>Admin Page</a></li>";
	                	}else if(isset($_SESSION['LoggedIn'])){
		                	echo "<li><a class='external' href='favourite.php'>Favourite List</a></li>";
	                	}
	                ?>
-->
                    <?php 
                      if($_SESSION['userSession'] == true && $row['userEmail'] == "calvin@hyphen.hk"){
                      //your logout link
                        echo "<li><a class='external' href='/drugs/login/logout.php'>Logout</a></li>";
                      }else{
                      //your login link
                        echo "<li><a class='external' href='/drugs/login/index.php'>Login</a></li>";
                      }
                      
                    ?>



                    
                </ul>
            </nav>
        </div>
    </div>
    
    <div class="container">
        <section class="col-md-12 content" id="home">
               <form method="post" action="<?php $_PHP_SELF ?>" style="width:50%;margin:0 auto;">
                  <table width="100%" border="0" cellspacing="1" cellpadding="2">
                  
                     <tr style="height:100px;">
                        <td>Drug Name</td>
                        <td><input name="name" type="text" id="name"></td>
                     </tr>
                  
                     <tr style="height:100px;">
                        <td>Drug Detail</td>
                        <td><textarea name="detail" type="text" id="detail"></textarea></td>
                     </tr>
                  
                     <tr style="height:100px;">
                        <td>Drug Effects</td>
                        <td><textarea name="effects" type="text" id="effects"></textarea></td>
                     </tr>

                     <tr style="height:100px;">
                        <td>Drug Type</td>
                        <td><input name="type" type="text" id="type"></td>
                     </tr>

                     <tr style="height:100px;">
                        <td> </td>
                        <td>
                           <input name="add" type="submit" id="add" value="Add Drug">
                        </td>
                     </tr>
                  
                  </table>
               </form>
       </section>

</div>

<?php include("../include/footer.php"); ?>
            

            
            <?php
         }
      ?>
   
   </body>
</html>