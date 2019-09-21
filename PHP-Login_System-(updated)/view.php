<?php  
	include 'inc/header.php';
	include 'lib/Process.php';
?>

<?php  
	if ($_GET['id']){
		$id = $_GET['id'];
	}

	$pros = new Process();
	$rowById = $pros->getEmployeeById($id);

?>
		<!-- body contents -->
		<div class="container content_container">

			
			<div class="card">
				<div class="card-header ">
					<h3>
						User <strong>Details</strong>
						<span class="float-right"><a class="btn btn-outline-dark" href="home.php">Back</a></span>
					</h3>
				</div>

				<div class="card-body custom_view">
					
					<span>
						
						<strong>

							<h4>
								<strong><?php echo "Registration Serial: ";?></strong>
								<?php echo $rowById->Id ."<br>";?>
							</h4>

							<h4>
								<strong><?php echo "Full Name: ";?></strong>
								<?php echo $rowById->Name ."<br>";?>
							</h4>			
									

							<h4>
								<strong><?php echo "Username: ";?></strong>
								<?php echo $rowById->Username ."<br>";?>
							</h4>	

							<h4>
								<strong><?php echo "E-mail: ";?></strong>
								<?php echo $rowById->Email ."<br>";?>
							</h4>	

						</strong>

					</span>

				</div>

			</div> <!-- card -->

		</div> <!-- body contents -->


<?php include 'inc/footer_index.php';?>