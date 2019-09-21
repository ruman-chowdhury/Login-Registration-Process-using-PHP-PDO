<?php
	$filepath = realpath(dirname(__FILE__));
	include_once $filepath.'/../lib/Session.php';
	Session::init();
?>

<?php
	if ( isset($_GET['action']) && $_GET['action']=="logout" ){
		Session::destroy();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login system</title>

	<!-- boortstrap css -->
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>

	<!--font awesome-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<!--Google font-->
	<link href="https://fonts.googleapis.com/css?family=Charm|Merriweather|Montserrat|Sacramento|Ubuntu" rel="stylesheet">

</head>
<body>
	<div class="container-fluid">

		<!---navbar section--->
		<nav class="navbar bg-dark navbar-dark navbar-expand-md fixed-top">
			
			<a class="navbar-brand" href="">Login System</a>

			<!-- Toggler/collapsibe Button -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>	

			<div class="collapse navbar-collapse" id="collapsibleNavbar">	
				<ul class="navbar-nav ml-auto">

					
<?php
	$id = Session::get("id");
	$userlogin = Session::get("login");

	if ($userlogin == true){

?>		
					
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="profile.php?id=<?php echo $id;?>">Profile</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="?action=logout">Logout</a>
					</li>


<?php } else{ ?>	
					
					<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="register.php">Register</a>
					</li>

<?php } ?>	


				</ul>
			</div>	
			
		</nav><!--nav section-->

