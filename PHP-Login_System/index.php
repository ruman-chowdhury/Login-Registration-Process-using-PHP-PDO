<?php 
	include "inc/header.php";
	include "lib/User.php";

	Session::checkSession();
		
?>

					
		<!-- body contents -->
		<div class="container content_container">

<?php
	$loginMsg = Session::get("loginMsg");
	if (isset($loginMsg)){
		echo $loginMsg;
	}
	Session::set("loginMsg", NULL);
?>			
			
			<div class="card">
				<div class="card-header bg-light">
						<span class="float-left"> 
							<h2> User <strong>List</strong> </h2>
						</span>
						
						<span class="float-right"> 
							<h4>Welcome!
							<strong>

<?php
	$name = Session::get("name");
	if (isset($name)) {
		echo "<span style='color:salmon'>".$name."</span>";
	}
?>

							</strong>
							<h4>
						</span>
					
				</div><!-- card header -->

				<div class="card-body custom_card_body">
					<table class="table table-borderless">
						<tr>
							<th>Serial</th>
							<th>Name</th>
							<th>Username</th>
							<th>Email</th>
							<th>Action</th>
						</tr>
						
<?php
	$userObj = new User();
	$userData = $userObj->getUserData();

	if ($userData){
		$i = 0;
		foreach ($userData as $values){
			$i++;

?>
						<tr>
							<td> <?php echo $i;?> </td>
							<td> <?php echo $values['Name'];?> </td>
							<td> <?php echo $values['Username'];?></td>
							<td> <?php echo $values['Email'];?> </td>
							<td>
								<a class="btn btn-info" href="profile.php?id= <?php echo $values['Id'];?> ">View</a>
							</td>
						</tr>


<?php } }else{ ?>						
	
	<tr>
		<td> <h2 style='color:red'>Data not found!</h2> </td>
	</tr>
						
<?php } ?>
					</table>
				</div>

			</div> <!-- card -->

		</div> <!-- body contents -->


<!-- including footer file -->
<?php include "inc/footer_normal.php"?>
