<?php
session_start();
require_once 'sql/base.php';
include_once('sql/youtube.php');
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/templatemo-style.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
  <script>
    $(function() {
      $( "#accordion" ).accordion({
          heightStyle: "content"
        });
    });
  </script>
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
                <a class="navbar-brand" href="/drugs/">Drugs</a>
            </div>
            <nav class="main-menu">
                <ul>
                    <li><a class="external" href="/drugs/">Home</a></li>
                    <li><a class='external' href="info.php">Drugs Details</a></li>
                    <li><a class='external' href="center.php">Drugs Center</a></li>
                    <li><a class='external' href="/drugs/comment_box/">Comments</a></li>
                    <li><a class='external' href="doc.php">Download</a></li>
                    <li><a class='external current' href="youtube.php">Youtube</a></li>
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
		        <div class="col-lg-12 col-md-12 content-item"><h2 class="main-title text-center dark-blue-text" style="font-size:56px;">Youtube Video</h2></div>	        
	        <div class="col-lg-12 col-md-12 content-item" style="padding-bottom:20px">


          <?php

          if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                  // echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["type"]. "<br>";

                  echo "<iframe width='100%' height='560' src='https://www.youtube.com/embed/".$row['link']."' frameborder='0' allowfullscreen></iframe>";
                  
              }
          } else {
              echo "0 results";
          }

          mysqli_close($conn);
          ?>
	        </div>
      </section>


</div>

<?php include("include/footer.php"); ?>
</body>
</html>