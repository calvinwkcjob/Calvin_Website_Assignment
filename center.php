<?php
session_start();
// include_once('sql/base.php');
$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "drugs"; // the name of the database that you are going to use for this project
$dbuser = "drugs"; // the username that you created, or were given, to access your database
$dbpass = "drugs"; // the password that you created, or were given, to access your database

mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
require_once 'signup-email-verification/class.user.php';
$user_home = new USER();


$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC); 
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

          $sql = "SELECT id, name, address, detail, tel, fax, email, website FROM center";
          $result = mysqli_query($conn, $sql);
          $result1 = mysqli_query($conn, $sql);  
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/templatemo-style.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css?v=2.1.5" media="screen" />
    <style>
    #gmap_canvas{
        width:100%;
        height:30em;
    }
     
    #map-label,
    #address-examples{
        margin:1em 0;
    }
    </style>    
  <script type="text/javascript">
    $(document).ready(function() {
      /*
       *  Simple image gallery. Uses default settings
       */

      $('.fancybox').fancybox({
          'width':800,
          'height':1200,
          'autoSize' : false


      });

      /*
       *  Different effects
       */

      // Change title type, overlay closing speed
      $(".fancybox-effects-a").fancybox({
        helpers: {
          title : {
            type : 'outside'
          },
          overlay : {
            speedOut : 0
          }
        }
      });

      // Disable opening and closing animations, change title type
      $(".fancybox-effects-b").fancybox({
        openEffect  : 'none',
        closeEffect : 'none',

        helpers : {
          title : {
            type : 'over'
          }
        }
      });
    fav = {
        add: function(did){
        var myData = {"dname": did};
        $.ajax({
            url: "favourite-api.php",
            type:"POST",
            contentType: "application/json; charset=utf-8",
            data:  JSON.stringify(myData),
            success: function(msg){ 
                if(msg=="true"){
                alert("Added to Favourite List!");
                location.reload();
                }else{
                    alert("Cannot add to favourite list. Maybe you have added?");
                }
            }
         });
        }
    }	

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
                <a class="navbar-brand" href="#">Drugs</a>
            </div>
            <nav class="main-menu">
                <ul>
                    <li><a class="external" href="/drugs/">Home</a></li>
                    <li><a class='external' href="info.php">Drugs Details</a></li>
                    <li><a class='external current' href="center.php">Drugs Center</a></li>
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

	      <div class="col-lg-12 col-md-12 content-item"><h2 class="main-title text-center dark-blue-text" style="font-size:56px;">Drugs Center</h2></div>
          <ul style="float: left;">
            
			<?php 
			          if (mysqli_num_rows($result) > 0) {
			              // output data of each row
			              while($row = mysqli_fetch_assoc($result)) {
			                  // echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["type"]. "<br>";
			                  echo "<li><a class='fancybox' href='#inline".$row["id"]."' title=". $row["name"].">". $row["name"]."</a></li>";
			              }
			          }	
				mysqli_close($conn);
				
			?>            
          </ul>
          
			<?php 
			          if (mysqli_num_rows($result1) > 0) {
			              // output data of each row
			              while($row = mysqli_fetch_assoc($result1)) {
			                  // echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["type"]. "<br>";
			                  echo "<div id='inline".$row["id"]."' style='display: none;'>";
			                  echo "<h3>".$row["name"]."</h3>";
			                  echo "<a href='javascript:void(0)' onclick='fav.add(\"".$row["name"]."\")'>Add to my favourite</a>";
			                  echo "<p>Serving District</p>";
			                  echo "<p>".$row["detail"]."</p>";
			                  echo "<p>Address:". $row["address"]."</p>";
			                  echo "<p>Tel. No.:". $row["tel"]."</p>";
			                  echo "<p>Fax. No.:". $row["fax"]."</p>";
			                  echo "<p>Email:". $row["email"]."</p>";
			                  echo "<p><a class='external' href='". $row["website"]."' target='_blank'>Website</a></p>";
			                  echo "<div style='overflow:hidden;width:500px;height:500px;resize:none;max-width:100%;'><div id='embed-map-display' style='height:100%; width:100%;max-width:100%;'><iframe style='height:100%;width:100%;border:0;' frameborder='0' src='https://www.google.com/maps/embed/v1/place?q=". $row["address"]."&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU'></iframe></div><a class='google-maps-code' href='https://www.hostingreviews.website/compare/dreamhost-vs-bluehost' id='grab-map-info'>dreamhost vs bluehost</a><style>#embed-map-display .text-marker{max-width:none!important;background:none!important;}img{max-width:none}</style></div><script src='https://www.hostingreviews.website/google-maps-authorization.js?id=277bad87-2e62-0036-ee85-dcd54df13e78&c=google-maps-code&u=1460432845' defer='defer' async='async'></script>";
			                  echo "</div>";
			              }
			          }	
				mysqli_close($conn);
				
			?>            
            
          
       </section>
    </div>
<?php include("include/footer.php"); ?>
</body>
</html>