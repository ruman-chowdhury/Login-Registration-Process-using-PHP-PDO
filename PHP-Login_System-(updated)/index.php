<?php  
	include 'inc/header.php';
	include 'lib/Process.php';

	Session::checkLogout(); //if logged in,it wont call
?>

<!-- fetch all data -->
<?php  
	$pros = new Process();
	$rows = $pros->selectData();

?>

<!-- delete specific data -->
<?php  
	if (isset($_GET['del'])){
		$id = $_GET['del'];
	
		$pros->deleteData($id);
	}

?>
				
		<!-- body contents -->
		<div class="container content_container">

<?php  
	$Msg = Session::get("loginMsg");
	if (isset($Msg)){
		echo $Msg;
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
								<strong class="text-warning"> 

<?php  
	$name = Session::get("name");
	if (isset($name)){
		echo $name;
	}
?>

								<i class="far fa-smile text-info"></i>
								</strong>
							</h4>
						</span>
				
				</div> <!-- card-header -->

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
	if ($rows){
		$i = 0;
		foreach ($rows as $value){
		$i++;	

?>						

						<tr>
							<td> <?php echo $i;?> </td>
							<td> <?php echo $value->Name;?> </td>
							<td> <?php echo $value->Username;?> </td>
							<td> <?php echo $value->Email;?> </td>
							<td>
								<a class="btn btn-outline-secondary btn-sm" href="profile.php?edit=<?php echo $value->Id;?>">Edit</a>
								
								<a class="btn btn-danger btn-sm" href="index.php?del=<?php echo $value->Id;?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
							</td>
						</tr>

		<?php } ?>
<?php }else{ ?>
						
					</table>

	<p class="text-secondary text-center error_msg">Data not Found!</p> 	
<?php } ?>					
				</div>

			</div> <!-- card -->

		</div> <!-- body contents -->


<?php include 'inc/footer_index.php';?>