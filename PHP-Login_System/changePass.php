<?php 
	include "inc/header.php";
	include "lib/User.php";

	Session::checkSession();

?>

<!-- receive id,send from index -->
<?php
	
	if (isset($_GET['id'])){
		$userId = (int)$_GET['id'];

		$sesId = Session::get("id");
		if ($sesId != $userId){
			header("Location: index.php");
		}

	}

	$userObj = new User();

	if ( ($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['updatePassword']) ){
		
		$updatePass = $userObj->updatePassword($userId,$_POST);

	}	

?>

<!-- login form -->
<div class="container content_container">

<?php
	if (isset($updatePass)) {
		echo $updatePass;
	}

?>

	<div class="card">

		<div class="card-header ">
			<h3>
				Change <strong>Password</strong>
				<span class="float-right"><a class="btn btn-outline-dark" href="profile.php?id=<?php echo $userId;?>">Back</a></span>
			</h3>
		</div>


		<div class="card-body bg-light">


			<form action="" method="POST" accept-charset="utf-8" class=" custom_form">

				<div class="form-group">
					<label for="old_pass">Old Password:</label>
					<input type="password" name="old_password" class="form-control" id="old_pass">
				</div>

				<div class="form-group">
					<label for="new_pass">New Password:</label>
					<input type="password" name="new_password" class="form-control" id="new_pass">
				</div>

			
				<button type="submit" name="updatePassword" class="btn btn-success">Update Password</button>

			</form>

		</div>

	</div><!-- card -->	
	
	
</div><!-- container -->

<?php include "inc/footer.php"?>