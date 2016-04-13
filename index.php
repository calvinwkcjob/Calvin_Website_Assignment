<?php
session_start();
require_once 'sql/base.php';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/templatemo-style.css">
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
                    <li><a href="#home">Home</a></li>
                    <li><a class='external' href="info.php">Drugs Details</a></li>
                    <li><a class='external' href="center.php">Drugs Center</a></li>
                    <li><a class='external' href="/drugs/comment_box/">Comments</a></li>
                    <li><a class='external' href="doc.php">Download</a></li>
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
	        <div class="col-lg-12 col-md-12 content-item" style="padding-bottom:20px"> 
		        <?php 
			        if($_SESSION['userSession'] == true){
				        echo '<a class="external" href="/drugs/signup-email-verification/logout.php" style="float:right;padding-left:10px">Logout</a><span style="float:right;padding-left: 20px;">Welcome '.$row['userName'].'!</span>';
				    }else{
					    echo "<a class='external' href='/drugs/signup-email-verification/index.php' style='float:right;padding-left:10px'>Login</a>";
				    }
			        
			    ?>
			    <form action="search.php" method="GET" style="float:right;">
			        <input type="text" name="query" />
			        <input type="submit" value="Search" />
			    </form>		        
	        </div>
           <div class="col-lg-6 col-md-6 content-item">           
               <img src="images/addict.jpg" alt="Image" class="tm-image">
           </div>
           <div class="col-lg-6 col-md-6 content-item content-item-1 background">
               <h2 class="main-title text-center dark-blue-text">What is drug abuse?</h2>
               <p>Drug abuse is the recurrent use of illegal drugs, or the misuse of prescription or over-the-counter drugs with negative consequences. These consequences may involve </p>  
               <ul class="dark-blue-text">
                <li>Problems at work, school, home or in interpersonal relationships</li>
                <li>Problems with the law</li>
                <li>Physical risks that come with using drugs in dangerous situations</li>
               </ul>             
               <p>(University of Maryland Medical Center, 2013)</p>
<!--                <button type="button" class="btn btn-big dark-blue-bordered-btn">Big Button</button>
               <button type="button" class="btn btn-big dark-blue-btn">Download</button> -->
           </div>
       </section>

</div>

<?php include("include/footer.php"); ?>
</body>
</html>