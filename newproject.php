<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
	// Prevent accountants from accessing page
    if($user->checkUserRole(50) && !$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

$customersArray = $customer->selectAllCustomers();
$carsArray = $car->selectAllCars();

if (isset($_POST['new-project-submit'])) {
    $newProjectFeedback = $project->insertNewProject(
		$_POST['project-car'], 
		$_POST['project-customer'], 
		$user->cleanInput($_POST['defect-desc']),
		$user->cleanInput($_POST['work-desc'])
	);
	if(!is_array($newProjectFeedback)) {
		header("Location: project.php?project_id=" . $newProjectFeedback . "&create-success=1");
		exit();
	} else {
		echo "<div class='container'>";
		foreach($newProjectFeedback as $message) {
			echo "<div class='alert alert-danger text-center' role='alert'>";
			echo 	$message;
			echo "</div>";
		}
		echo "</div>";
    }
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
			<p class="fst-italic">* obligatoriska fält</p>
			<div class="card rounded-4 text-start shadow-sm p-4 mb-4">
				<h2 class="h4 mb-0">Bil *</h2>

				<button type="button" class="btn btn-primary my-3 me-auto" data-bs-toggle="modal" data-bs-target="#carModal">
					Bläddra bland bilar
				</button>

				<input type="hidden" id="project-car" name="project-car" required="required">

				<div id="car-data">
					<span class="fst-italic">Ingen bil har valts</span>
				</div>
			</div>

			<div class="card rounded-4 text-start shadow-sm p-4 mb-5">
				<h2 class="h4 mb-0">Kund *</h2>

				<button type="button" class="btn btn-primary my-3 me-auto" data-bs-toggle="modal" data-bs-target="#customerModal">
					Bläddra bland kunder
				</button>

				<input type="hidden" id="project-customer" name="project-customer" required="required">

				<div id="customer-data">
					<span class="fst-italic">Ingen kund har valts</span>
				</div>
			</div>

			<div class="card rounded-4 text-start shadow-sm p-4">
				<h2 class="h4 mb-2">Om projektet</h2>

				<label class="h5 mt-4 mb-3" for="defect-desc">Felbeskrivning *</label>
				<textarea class="form-control mb-2" id="defect-desc" name="defect-desc" rows="3" required="required"></textarea>
				
				<label class="h5 my-3" for="defect-desc">Arbetsbeskrivning</label>
				<textarea class="form-control" id="work-desc" name="work-desc" rows="3"></textarea>
			</div>

			<input type="submit" class="btn btn-primary mt-4" name="new-project-submit" value="Skapa nytt projekt">
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
	// Check if both car and customer are selected when submitted
	document.getElementById("project-form").addEventListener("submit", function(event) {
		const projectCar = document.getElementById("project-car").value;
		const projectCustomer = document.getElementById("project-customer").value;
		
		// Check if the hidden value is empty
		if (!projectCar || !projectCustomer) {
			alert("Ange både bil och kund till projektet och försök igen.");
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