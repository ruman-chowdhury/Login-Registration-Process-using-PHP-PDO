<?php  
	include 'inc/header.php';
	include 'lib/Process.php'; 

	Session::checkLogout(); 
?>

<!-- get specific user by Id -->
<?php  
	if ($_GET['edit']){
		$id = $_GET['edit'];
	}

	$pros = new Process();
	$rowById = $pros->getEmployeeById($id);

?>

<!-- submit update form -->
<?php  
	if (isset($_SERVER['REQUEST_METHOD']) == "POST" && isset($_POST['update']) ){
		
		$updateResult = $pros->updateData($id,$_POST);

	}

?>

<!-- login form -->
<div class="container content_container">

	<div class="card">

		<div class="card-header ">
			<h3>
				User <strong>Profile</strong>
				<span class="float-right"><a class="btn btn-outline-dark" href="index.php">Back</a></span>
			</h3>
		</div>

<?php  
	if (isset($updateResult)){
		echo $updateResult;
	}

?>

		<div class="card-body bg-light">

			<form action="" method="POST" accept-charset="utf-8" class=" custom_form">

				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" name="name" class="form-control" id="name" value="<?php echo $rowById->Name;?>">
				</div>

				<div class="form-group">
					<label for="username">Username:</label>
					<input type="text" name="username" class="form-control" id="username" value="<?php echo $rowById->Username;?>">
				</div>

				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" name="email" class="form-control" id="email" value="<?php echo $rowById->Email;?>">
				</div>

<?php  
	//$sesid is actually that Id when user logged in
	$sesid = Session::get("id");
	if ($sesid == $id ){


?>				
				<div class="form-group">
					<button type="submit" name="update" class="btn btn-success">Update Profile</button>

					<a class="btn btn-outline-dark" href="changePass.php?id=<?php echo $rowById->Id;?>"> Change Password </a>
				</div>

<?php } ?>

			</form>

		</div>

	</div><!-- card -->	
	
	
</div><!-- container -->


<?php include 'inc/footer.php';?>