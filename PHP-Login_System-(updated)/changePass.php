<?php  
	include 'inc/header.php';
	include 'lib/Process.php';

	Session::checkLogout(); 
?>

<!-- get specific user by Id -->
<?php  
	if ($_GET['id']){
		$id = $_GET['id'];
	}

?>

<?php  
	$pros =  new Process();

	if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updatePassword']) ){
		$updatePass = $pros->updatePassword($id,$_POST);
	}

?>


<!-- login form -->
<div class="container content_container">

	<div class="card">

		<div class="card-header bg-light">
			<h3>Change <strong>Password</strong></h3>
		</div>
		
<?php  
	if (isset($updatePass)){
		echo $updatePass;
	}
?>
		<div class="card-body">

			<form action="" method="POST" accept-charset="utf-8" class="custom_form">

				<div class="form-group">
					<label for="old_pass"><strong> Current Password: </strong></label>
					<input type="password" name="old_password" class="form-control" id="old_pass" placeholder="old password">
				</div>

				<div class="form-group">
					<label for="new_pass"><strong> New Password: </strong></label>
					<input type="password" name="new_password" class="form-control" id="new_pass" placeholder="new password">
				</div>
				
				<div class="form-group">
					<button type="submit" name="updatePassword" class="btn btn-success">Update Password</button>

					<a href="profile.php?edit=<?php echo $id;?>" class="btn btn-outline-secondary" type="submit" name="cancel">Cancel</a>

				</div>

			</form>

		</div><!-- card body -->

	</div><!-- card -->	
	
	

<?php include 'inc/footer.php'; ?>