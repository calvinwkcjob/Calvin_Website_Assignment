
<?php
session_start();
require_once 'sql/base.php';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <script>
	    $(document).ready(function() {
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
                    <li><a class='external' href="/drugs/">Home</a></li>
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
 <div class='col-lg-12 col-md-12 content-item'><h2 class='main-title text-center dark-blue-text' style='font-size:56px;'>Center Details</h2></div>
<?php
    $query = $_GET['query']; 
    // gets value sent over search form
     
    $min_length = 3;
    // you can set minimum length of the query if you want
     
    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
         
        $query = htmlspecialchars($query); 
        // changes characters used in html to their equivalents, for example: < to &gt;
         
        $query = mysql_real_escape_string($query);
        // makes sure nobody uses SQL injection
         
        $raw_results = mysql_query("SELECT * FROM center
            WHERE (`name` LIKE '%".$query."%') OR (`detail` LIKE '%".$query."%')") or die(mysql_error());
             
        // * means that it selects all fields, you can also write: `id`, `title`, `text`
        // articles is the name of our table
         
        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
         
        if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
             
            while($results = mysql_fetch_array($raw_results)){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop

                echo "<div class='searchitem'><p><h3>".$results['name']."</h3>".$results['detail']."</p>";
	                	if($_SESSION['userSession'] == true && $row['userEmail'] == "calvin@hyphen.hk"){
		                	echo "";
	                	}else if($_SESSION['userSession'] == true && $row['userEmail'] != "calvin@hyphen.hk"){
		                	echo "<a href='javascript:void(0)' onclick='fav.add(\"".$results['name']."\")'>Add to my favourite</a>";
	                	}else{
		                	echo "";
	                	}                
                
                // posts results gotten from database(title and text) you can also show id ($results['id'])
            }
             
        }
        else{ // if there is no matching rows do following
            echo "No results";
        }
         
    }
    else{ // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }
?>
        </section>
    </div>
<?php include("include/footer.php"); ?>
</body>
</html>