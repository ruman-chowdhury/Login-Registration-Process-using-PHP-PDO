<?php  
	include 'inc/header.php';
	include 'lib/Process.php'; 
?>

<?php  
	$pros = new Process();
	$rows = $pros->selectData();

?>			
		<!-- body contents -->
		<div class="container content_container">

			
			<div class="card">
				<div class="card-header bg-light">
						<span class="float-left"> 
							<h2> User <strong>List</strong> </h2>
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
								<a class="btn btn-info btn-sm" href="view.php?id=<?php echo $value->Id;?>">View</a>
								
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