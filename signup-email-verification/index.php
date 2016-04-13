<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('/drugs/');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	
	if($user_login->login($email,$upass))
	{
		$user_login->redirect('/drugs/');
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <!-- Bootstrap -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/drugs/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/drugs/css/templatemo-style.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>  

     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
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
                    <li><a class="external" href="/drugs/">Home</a></li>
                    <li><a class='external' href="/drugs/info.php">Drugs Details</a></li>
                    <li><a class='external' href="/drugs/center.php">Drugs Center</a></li>
                    <li><a class='external' href="/drugs/comment_box/">Comments</a></li>
                    <li><a class='external' href="/drugs/doc.php">Download</a></li>
                    <li><a class='external' href="youtube.php">Youtube</a></li>
                    <?php
	                	if($_SESSION['userSession'] == true && $row['userEmail'] == "calvin@hyphen.hk"){
		                	echo "<li><a class='external' href='/drugs/admin/'>Admin</a></li>";
	                	}else if($_SESSION['userSession'] == true && $row['userEmail'] != "calvin@hyphen.hk"){
		                	echo "<li><a class='external' href='favourite.php'>Favourite</a></li>";
	                	}else{
		                	echo "";
	                	}
	                ?>
                </ul>
            </nav>
        </div>
    </div>  
    <div class="container">
        <section class="col-md-12 content" id="home">
	            
				<?php 
				if(isset($_GET['inactive']))
				{
					?>
		            <div class='alert alert-error'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it. 
					</div>
		            <?php
				}
				?>
		        <form class="form-signin" method="post">
		        <?php
		        if(isset($_GET['error']))
				{
					?>
		            <div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Wrong Details!</strong> 
					</div>
		            <?php
				}
				?>
		        <h2 class="main-title text-center dark-blue-text">Sign In.</h2><hr />
		        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
		        <input type="password" class="input-block-level" placeholder="Password" name="txtupass" required />
		     	<hr />
		        <button class="btn btn-large btn-primary" type="submit" name="btn-login">Sign in</button>
		        <a href="signup.php" style="float:right;" class="btn btn-large">Sign Up</a><hr />
		        <a href="fpass.php">Lost your Password ? </a>
		      </form>
        </section>

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
<?php include("../include/footer.php"); ?>    
  </body>
</html>