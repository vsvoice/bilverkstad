<?php
include_once 'includes/header.php';

// Get project_id from URL
if (isset($_GET['project_id'])) {
    $projectId = (int)$_GET['project_id'];
    
    // Fetch project data
    $projectDataArray = $project->selectSingleProject($projectId);
    
    if (!$projectDataArray) {
        echo "Project not found!";
        exit;
    }
} 
else {
	echo "No project selected!";
	exit;
}

var_dump($projectDataArray);

$customersArray = $customer->selectAllCustomers();
$carsArray = $car->selectAllCars();

// Handle form submission to update project
if (isset($_POST['edit-project-submit'])) {
    $feedbackMessages = $project->updateProject(
		$projectId,
		(int)$_POST['project-car'], 
		(int)$_POST['project-customer'], 
		$user->cleanInput($_POST['defect-desc']),
		$user->cleanInput($_POST['work-desc'])
	);
	if($feedbackMessages === 1) {
		header("Location: project.php?project_id=" . $projectId);
		exit();
	} else {
		echo "<div class='container'>";
		foreach($feedbackMessages as $message) {
			echo "<div class='alert alert-danger text-center' role='alert'>";
			echo 	$message;
			echo "</div>";
		}
		echo "</div>";
    }
}
?>

<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Redigera projekt</h1>

		<form id="project-form" action="" method="post">
			<h2 class="h4 mt-3">Bil *</h2>

			<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#carModal">
				Bläddra bland bilar
			</button>

			<input type="hidden" id="project-car" name="project-car" value="<?php echo $projectDataArray['car_id_fk'] ?>" required="required">

			<div class="row">
				<p class="h6" id="car-data">
					<span id="car-brand"><?php echo $projectDataArray['car_brand'] ?></span> 
					<span id="car-model"><?php echo $projectDataArray['car_model'] ?></span> 
					<span class="ms-4" id="car-license"><?php echo $projectDataArray['car_license'] ?></span>
				</p>
			</div>


			<h2 class="h4 mt-4">Kund *</h2>

			<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#customerModal">
				Bläddra bland kunder
			</button>

			<input type="hidden" id="project-customer" name="project-customer" value="<?php echo $projectDataArray['customer_id_fk'] ?>" required="required">

			<div class="row">
				<p class="h6" id="customer-data">
					<?php echo "{$projectDataArray['customer_fname']} {$projectDataArray['customer_lname']}" ?>
					<?php echo "<span class='ms-4'> {$projectDataArray['customer_phone']} </span>"?>
					<?php echo "<span class='ms-4'> {$projectDataArray['customer_email']} </span>"?>
					<?php echo "<span class='ms-4'> {$projectDataArray['customer_address']} {$projectDataArray['customer_zip']} {$projectDataArray['customer_area']} </span>"?>
				</p>
			</div>

			<h2 class="h4 mt-4 mb-2">Om projektet</h2>

			<label class="h5 my-3" for="defect-desc">Felbeskrivning *</label>
			<textarea class="form-control" id="defect-desc" name="defect-desc" required="required"><?php echo $projectDataArray['defect_desc']; ?></textarea>
			
			<label class="h5 my-3" for="defect-desc">Arbetsbeskrivning</label>
			<textarea class="form-control" id="work-desc" name="work-desc"><?php echo $projectDataArray['work_desc']; ?></textarea>

			<input type="submit" class="btn btn-primary my-3" name="edit-project-submit" value="Spara ändringar">
		</form>
	</div>
</div>


<div class="modal fade" id="carModal" tabindex="-1" aria-labelledby="carModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="carModalLabel">Välj bil</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-0">
				<?php
					$car->populateCarField($carsArray);
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tillbaka</button>
				<a class="btn btn-primary" href="newcar.php" role="button">Ny bil</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="customerModalLabel">Välj kund</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-0">
				<?php
					$customer->populateCustomerField($customersArray);
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tillbaka</button>
				<a class="btn btn-primary" href="newcustomer.php" role="button">Ny kund</a>
			</div>
		</div>
	</div>
</div>

<script>

	function selectProjectCustomer(customerId) {
		const selectedCustomer = document.getElementById("project-customer");
		selectedCustomer.value = customerId;

		if (customerId == undefined || customerId == null || customerId == "") {
        	return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("customer-data").innerHTML = this.responseText;
				}
        	};
        xmlhttp.open("GET", "ajax/select_customer_from_modal.php?id=" + customerId, true);
        xmlhttp.send();
    	}
	}

	function selectProjectCar(carId) {
		const selectedCar = document.getElementById("project-car");
		selectedCar.value = carId;

		if (carId == undefined || carId == null || carId == "") {
        	return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("car-data").innerHTML = this.responseText;
				}
        	};
        xmlhttp.open("GET", "ajax/select_car_from_modal.php?id=" + carId, true);
        xmlhttp.send();
    	}
	}
</script>

<?php
include_once 'includes/footer.php';
?>
