<?php  
	$filepath = realpath(dirname(__FILE__));
	include_once $filepath.'/../lib/Session.php';

	Session::init();
?>

<?php  
	if (isset($_GET['action']) && $_GET['action'] == "logout"){
		Session::destroy();

		header("Location:home.php");
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
	<link href="https://fonts.googleapis.com/css?family=Charm|Merriweather|Montserrat|Sacramento|Ubuntu|Monoton" rel="stylesheet">

</head>
<body>
	<div class="container-fluid">

		<!---navbar section--->
		<nav class="navbar navbar-light bg-light navbar-expand-md fixed-top">
			
			<a class="navbar-brand text-info" href="">Login System</a>

			<!-- Toggler/collapsibe Button -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>	

			<div class="collapse navbar-collapse" id="collapsibleNavbar">	
				<ul class="navbar-nav ml-auto">

<?php
	$userLogin = Session::get("login");
	$id = Session::get("id");  
	$username = Session::get("username");
	
	if ($userLogin == true){
	
?>					
					<li class="nav-item">
						<a class="nav-link active" href="index.php">Home</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="profile.php?edit=<?php echo $id;?>">Profile</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="home.php?action=logout">Logout(<?php echo $username;?>)</a>
					</li>

<?php }else{ ?>					
					
					<li class="nav-item">
						<a class="nav-link active" href="home.php">Home</a>
					</li>

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