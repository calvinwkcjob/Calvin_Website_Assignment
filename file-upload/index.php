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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/templatemo-style.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>   
<title>Drugs</title>

</head>
<body>
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
                    <li><a class='external ' href="/drugs/admin/addinfo.php">Add Drugs</a></li>
                    <li><a class='external' href="/drugs/admin/addcenter.php">Add Center</a></li>
                    <li><a class='external' href="/drugs/admin/youtube.php">Add Video</a></li>
                    <li><a class='external current' href="/drugs/file-upload/index.php">Upload Files</a></li>
                    <li><a class='external' href="/drugs/login/logout.php">Logout</a></li>



                    
                </ul>
            </nav>
        </div>
    </div>
    <div class="container">
        <section class="col-md-12 content" id="home">
			<form action="upload.php" method="post" enctype="multipart/form-data" style="width:50%;margin:0 auto;">
			<input type="file" name="file" />
			<button type="submit" name="btn-upload">upload</button>
			</form>
			<div style="width:50%;margin:0 auto;">
		    <br /><br />
			    <?php
				if(isset($_GET['success']))
				{
					?>
			        <label>File Uploaded Successful</label>
			        <?php
				}
				else if(isset($_GET['fail']))
				{
					?>
			        <label>Problem While File Uploading !</label>
			        <?php
				}
				else
				{
					?>
			        <label>Try to upload any files(PDF, DOC, EXE, VIDEO, MP3, ZIP,etc...)</label>
			        <?php
				}
				?>
			</div>
        </section>
		</div>

</body>
</html>