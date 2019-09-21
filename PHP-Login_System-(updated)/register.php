<?php  
	include 'inc/header.php';
	include 'lib/Process.php';
?>

<?php  
	$pros =  new Process();

	if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register']) ){
		$regResult = $pros->userRegistration($_POST);
	}

?>

<!-- login form -->
<div class="container content_container">

	<div class="card">

		<div class="card-header">
			<h3>User <strong>Registration</strong></h3>
		</div>

<?php  
	if (isset($regResult)){
		echo $regResult;
	}

?>
		<div class="card-body bg-light">

			<form action="" method="POST" accept-charset="utf-8" class="custom_form">

				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" name="name" class="form-control" id="name">
				</div>

				<div class="form-group">
					<label for="username">Username:</label>
					<input type="text" name="username" class="form-control" id="username">
				</div>

				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" name="email" class="form-control" id="email" placeholder="someone@gmail.com">
				</div>

				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" class="form-control" id="password">
				</div>
				
				<div class="form-group">
					<button type="submit" name="register" class="btn btn-success">Submit</button>

					<input type="reset" class="btn btn-outline-secondary" value="Cancel">

				</div>

			</form>

		</div><!-- card body -->

	</div><!-- card -->	
	
	
</div><!-- container -->


<?php include 'inc/footer.php'; ?>