<?php
include_once 'includes/header.php';

if(isset($_SESSION['project-car'])) {unset($_SESSION['projectcar']); } 
if(isset($_SESSION['project-customer'])) {unset($_SESSION['projectcustomer']); }

$customersArray = $customer->selectAllCustomers();
$carsArray = $car->selectAllCars();

if (isset($_POST['new-project-submit'])) {
    $feedbackMessages = $project->insertNewProject(
		$_POST['project-car'], 
		$_POST['project-customer'], 
		$user->cleanInput($_POST['defect-desc']),
		$user->cleanInput($_POST['work-desc'])
	);
}

/*if (isset($_GET['car']) && $_GET['car'] === 'getCarDataById') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Get the ID from the request
        $car->getCarDataById($id);
    } else {
        echo json_encode(['error' => 'No ID provided']);
    }
}*/

?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Nytt projekt</h1>

		<form id="project-form" action="" method="post">
			<h2 class="h4 mt-3">Bil *</h2>

			<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#carModal">
				Bläddra bland bilar
			</button>

			<input type="hidden" id="project-car" name="project-car" required="required">

			<div class="row">
				<p class="h6" id="car-data"><span id="car-brand">Märke</span> <span id="car-model">Modell</span> <span class="ms-4" id="car-license">Registernummer</span></p>
			</div>


			<h2 class="h4 mt-4">Kund *</h2>

			<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#customerModal">
				Bläddra bland kunder
			</button>

			<input type="hidden" id="project-customer" name="project-customer" required="required">

			<div class="row">
				<p class="h6" id="customer-data">Namn
					<span class="ms-4">Telefonnummer</span>
					<span class="ms-4">E-post</span>
					<span class="ms-4">Adress Postnummer Ort</span>
				</p>
			</div>

			<h2 class="h4 mt-4 mb-2">Om projektet</h2>

			<label class="h5 my-3" for="defect-desc">Felbeskrivning *</label>
			<textarea class="form-control" id="defect-desc" name="defect-desc" required="required"></textarea>
			
			<label class="h5 my-3" for="defect-desc">Arbetsbeskrivning</label>
			<textarea class="form-control" id="work-desc" name="work-desc"></textarea>

			<input type="submit" class="btn btn-primary my-3" name="new-project-submit" value="Skapa nytt projekt">
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
	document.getElementById("project-form").addEventListener("submit", function(event) {
		const projectCar = document.getElementById("project-car").value;
		const projectCustomer = document.getElementById("project-customer").value;
		
		// Check if the hidden value is empty
		if (!projectCar || !projectCustomer) {
			alert("Ange både bil och kund för projektet och försök igen.");
			event.preventDefault(); // Prevent form submission
		}
	});

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