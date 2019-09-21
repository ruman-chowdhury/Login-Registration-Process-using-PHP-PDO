<?php  
	include 'inc/header.php';
	include 'lib/Process.php';

	Session::checkLogin(); 
?>

<?php  
	$pros =  new Process();

	if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login']) ){
		$logResult = $pros->userLogin($_POST);
	}

?>


<!-- login form -->
<div class="container content_container">

	<div class="card">

		<div class="card-header bg-light">
			<h3>User <strong>Login</strong></h3>
		</div>
		
<?php  
	if (isset($logResult)){
		echo $logResult;
	}
?>
		<div class="card-body">

			<form action="" method="POST" accept-charset="utf-8" class="custom_form">

				<div class="form-group">
					<label for="email_user"><strong> E-mail/Username: </strong></label>
					<input type="text" name="usernameEmail" class="form-control" id="email_user" placeholder="username or email">
				</div>

				<div class="form-group">
					<label for="password"><strong> Password: </strong></label>
					<input type="password" name="password" class="form-control" id="password" placeholder="password">
				</div>
				
				<div class="form-group">
					<button type="submit" name="login" class="btn btn-success">Login</button>

					<a href="index.php?id=1" class="btn btn-outline-secondary" type="submit" name="cancel">Cancel</a>

				</div>

			</form>

		</div><!-- card body -->

	</div><!-- card -->	
	
	

<?php include 'inc/footer.php'; ?>