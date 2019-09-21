<?php 
	include "inc/header.php";
	include "lib/User.php";

	Session::checkSession();

?>

<!-- receive id,send from index -->
<?php
	
	if (isset($_GET['id'])){
		$userId = (int)$_GET['id'];

	}

	$userObj = new User();

	if ( ($_SERVER['REQUEST_METHOD'] == "POST") && isset($_POST['update']) ){
		
		$userUpdate = $userObj->userUpdate($userId,$_POST);

	}	

?>

<!-- login form -->
<div class="container content_container">

<?php
	if (isset($userUpdate)) {
		echo $userUpdate;
	}

?>

	<div class="card">

		<div class="card-header ">
			<h3>
				User <strong>Profile</strong>
			</h3>
		</div>


		<div class="card-body bg-light">


<?php
	$userData = $userObj->getUserById($userId);

	if ($userData){
		

?>

			<form action="" method="POST" accept-charset="utf-8" class=" custom_form">

				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" name="name" class="form-control" id="name" value="<?php echo $userData->Name;?> ">
				</div>

				<div class="form-group">
					<label for="username">Username:</label>
					<input type="text" name="username" class="form-control" id="username" value="<?php echo $userData->Username;?>">
				</div>

				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" name="email" class="form-control" id="email" value="<?php echo $userData->Email;?>">
				</div>


<?php
	$sesId = Session::get("id");
	if ($sesId == $userId){
		
?>
				
				<button type="submit" name="update" class="btn btn-success">Update</button>
				<a class="btn btn-outline-dark" href="changePass.php?id=<?php echo $userId;?>"> Change Password </a>

<?php } ?>

			</form>

<?php } ?>

		</div>

	</div><!-- card -->	
	
	
</div><!-- container -->

<?php include "inc/footer.php"?>