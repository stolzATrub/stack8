<?php
//Session handler
session_start();
$isLoggedIn = false;
if(isset($_SESSION["uid"]) && isset($_SESSION["CREATED"]))
{
    if( (time() - $_SESSION["CREATED"]) > 3600 )
    {
        //Session too old
        session_unset();
        session_destroy();
    }
    else
    {
        $isLoggedIn = true;
    }
}
if(!$isLoggedIn)
{
	header("Location: login.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Stack8</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="howto.php">Manual</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="community.php">Shared Programs</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">My Stack</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
	<div class="d-flex flex-row p-2 justify-content-center">
		<div class="card">
  		<div class="card-block text-center">
			<h3>Welcome back</h3><br>
			All of your public and private programs are organized right here!
  		</div>
		</div>
	</div>
	
	<div class="d-flex flew-row p-2 justify-content-center" >
        <div class="col-sm-6">
        	<div class="card">
  			<h3 class="card-header text-center">Your public programs</h3>
  			<div class="card-block" style="max-height:300px;overflow:auto;">
  			
			<ul class="list-group">
        	<?php
            //DB data,
        	$dbserver = "localhost";
        	$dbuser = "stackUser";
        	$dbpassword = "xxxx";
        	$dbname = "stack8";

        	// Create connection
        	$db = new mysqli($dbserver, $dbuser, $dbpassword, $dbname);

        	if ($db->connect_error)
        	{
            	echo "Error with DB conection";
            	die();
        	}

            //get all public programs, print list
        	$list = $db->query("SELECT pname,phash,public FROM Programs WHERE uid=".$_SESSION["uid"]);

        	if($list->num_rows > 0 )
        	{
            	while($row = $list->fetch_assoc())
            	{
                	if(intval($row["public"],10) === 1)
                	{
                    	echo "<a href=\"index.php?phash=".$row["phash"]."\" class=\"list-group-item list-group-item-action text-center d-inline-block \">".$row["pname"]."</a>";
                	}
            	}
        	}

        	$db->close();
        	?>

        	</ul>

			
			</div>
			</div>
		</div>
        <div class="col-sm-6">
        	<div class="card">
            <h3 class="card-header text-center">Your private programs</h3>
            <div class="card-block">

			<ul class="list-group">
            <?php
            //DB data
            $dbserver = "localhost";
            $dbuser = "stackUser";
            $dbpassword = "xxxx";
            $dbname = "stack8";

            // Create connection
            $db = new mysqli($dbserver, $dbuser, $dbpassword, $dbname);

            if ($db->connect_error)
            {
                echo "Error with DB conection";
                die();
            }

            //get all private programs, print list
            $list = $db->query("SELECT pname,phash,public FROM Programs WHERE uid=".$_SESSION["uid"]);

            if($list->num_rows > 0 )
            {
                while($row = $list->fetch_assoc())
                {
                    if(intval($row["public"],10) === 0)
                    {
                        echo "<a href=\"index.php?phash=".$row["phash"]."\" class=\"list-group-item list-group-item-action text-center d-inline-block \">".$row["pname"]."</a>";
                    }
                }
            }

            $db->close();
            ?>

            </ul>

            </div>
            </div>
		</div>
    </div>
	
	 <div class="d-flex flex-row p-2 justify-content-center">
        <div class="card">
        <div class="card-block text-center">
            <form action="logout.php">
			 <button type="submit" class="btn btn-danger">Logout</button>
			</form>
        </div>
        </div>
    </div>


</div>

<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</body>
</html>
