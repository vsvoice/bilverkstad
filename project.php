<?php
include_once 'includes/header.php';

$user->checkLoginStatus();

// Get project_id from URL
if (isset($_GET['project_id'])) {
    $projectId = (int)$_GET['project_id'];
    
    // Fetch project data
    $projectDataArray = $project->selectSingleProject($projectId);
    
    if (!$projectDataArray) {
        echo "Projektet hittades inte!";
        exit;
    }
} 
else {
	echo "Inget projekt har valts!";
	exit;
}

if (isset($_GET['create-success'])) {
	echo "<div class='container'>
			<div class='alert alert-success text-center' role='alert'>
				Projektet har skapats.
			</div>
		</div>";
}

if (isset($_GET['edit-success'])) {
	echo "<div class='container'>
			<div class='alert alert-success text-center' role='alert'>
				Ändringarna har sparats.
			</div>
		</div>";
}

$statusesData = $project->selectAllStatusData();
$currentDate = date("Y-m-d");

$projectProductsArray = $project->selectProjectProducts($projectId);
$todaysWorkingHours = $project->selectWorkingHours($currentDate, $_SESSION['user_id'], $projectId);

//var_dump($todaysWorkingHours);
$totalWorkingHours = $project->selectTotalWorkingHours($_SESSION['user_id'], $projectId);


if (isset($_POST['new-product-submit'])) {
    $feedbackMessages = $project->insertNewProduct(
		$user->cleanInput( $_POST['new-prod-name']), 
		$user->cleanInput( $_POST['new-prod-price']), 
		$user->cleanInput( $_POST['new-prod-number']),
		$projectId
	);

	if($feedbackMessages === 1) {
		echo "<div class='container'>
				<div class='alert alert-success text-center' role='alert'>
					Produkten har lagts till i projektet.
				</div>
			</div>";
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

if (isset($_POST['edit-product-submit'])) {
    $feedbackMessages = $project->updateProduct(
		$user->cleanInput( $_POST['edit-prod-name']), 
		$user->cleanInput( $_POST['edit-prod-price']), 
		$user->cleanInput( $_POST['edit-prod-number']),
		$_POST['edit-prod-id']
	);

	if($feedbackMessages === 1) {
		echo "<div class='container'>
				<div class='alert alert-success text-center' role='alert'>
					Produkten har uppdaterats.
				</div>
			</div>";
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

if (isset($_POST['delete-product-submit'])) {
    $feedbackMessages = $project->deleteProduct($_POST['edit-prod-id']);

	if($feedbackMessages !== 1) {
		foreach($feedbackMessages as $message) {
			echo $message;
		}
    }
}

if (isset($_POST['work-hours-submit'])) {
    $feedbackMessages = $project->insertWorkingHours(
		$projectId,
		$_SESSION['user_id'],
		$user->cleanInput( $_POST['work-hours']),
		$user->cleanInput( $_POST['work-date'])
	);

	if($feedbackMessages === 1) {
		echo "<div class='container'>
				<div class='alert alert-success text-center' role='alert'>
					Arbetstiden har uppdaterats.
				</div>
			</div>";
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
		<a class="btn btn-secondary mb-5" href="home.php">Till startsidan</a><br>
		<a class="btn btn-primary mb-3" href="editproject.php?project_id=<?php echo $projectId ?>">Redigera projektet</a>
		<div class="card rounded-4 text-start shadow-sm p-4 mb-3">
			<h2 class="h4">Bil</h2>
			<div class="row">
				<p class="h6 lh-base mb-0" id="car-data">
					<span id="car-brand"><?php echo $projectDataArray['car_brand'] ?></span> 
					<span id="car-model"><?php echo $projectDataArray['car_model'] ?></span> 
					<span class="ms-4" id="car-license"><?php echo $projectDataArray['car_license'] ?></span>
				</p>
			</div>
		</div>

		<div class="card rounded-4 text-start shadow-sm p-4 my-3">
			<h2 class="h4">Kund</h2>
			<div class="row">
				<p class="h6 lh-base mb-0" id="customer-data">
					<?php echo "{$projectDataArray['customer_fname']} {$projectDataArray['customer_lname']}" ?>
					<?php echo "<span class='ms-4'> {$projectDataArray['customer_phone']} </span>"?>
					<?php echo "<span class='ms-4'> {$projectDataArray['customer_email']} </span>"?>
					<?php echo "<span class='ms-4'> {$projectDataArray['customer_address']} {$projectDataArray['customer_zip']} {$projectDataArray['customer_area']} </span>"?>
				</p>
			</div>
		</div>

		<div class="card rounded-4 text-start shadow-sm p-4 mt-5 mb-3">
			<h2 class="h4 mb-3 fw-bold">Om projektet</h2>

			<form method="POST" action="update-status.php">
				<input type="hidden" name="project_id" value="<?php echo $projectId; ?>">

				<label class="form-label h5 mt-3" for="status_id">Status</label>
				<select class="form-select mb-3" id="status_id" name="status_id" aria-label="Project Status" onchange="this.form.submit()">
					<?php
						foreach ($statusesData as $status) {
							if ($user->checkUserRole(10) && !$user->checkUserRole(50)) 
							{
								if ($status['s_id'] == 6 || $status['s_id'] == 7) 
								{
									echo "<option class='d-none' value='" . $status['s_id'] . "' " . ($projectDataArray['status_id_fk'] == $status['s_id'] ? 'selected' : '') . ">" . $status['s_name'] . "</option>";
								} else {
									echo "<option value='" . $status['s_id'] . "' " . ($projectDataArray['status_id_fk'] == $status['s_id'] ? 'selected' : '') . ">" . $status['s_name'] . "</option>";
								}
							} 
							else if ($user->checkUserRole(50) && !$user->checkUserRole(200)) 
							{
								if ($status['s_id'] == 1 || $status['s_id'] == 2 || $status['s_id'] == 3 || $status['s_id'] == 4) 
								{
									echo "<option class='d-none' value='" . $status['s_id'] . "' " . ($projectDataArray['status_id_fk'] == $status['s_id'] ? 'selected' : '') . ">" . $status['s_name'] . "</option>";
								} else {
									echo "<option value='" . $status['s_id'] . "' " . ($projectDataArray['status_id_fk'] == $status['s_id'] ? 'selected' : '') . ">" . $status['s_name'] . "</option>";
								}
							} 
							else {
								echo "<option value='" . $status['s_id'] . "' " . ($projectDataArray['status_id_fk'] == $status['s_id'] ? 'selected' : '') . ">" . $status['s_name'] . "</option>";
							}
						}
					?>
				</select>
			</form>

			<h3 class="h5 mt-4 mb-2">Felbeskrivning</h3>
			<p><?php echo "{$projectDataArray['defect_desc']}"?></p>
			<h3 class="h5 mt-4 mb-2">Arbetsbeskrivning</h3>
			<p><?php echo "{$projectDataArray['work_desc']}"?></p>


				<h3 class="h5 mt-4 mb-2">Produkter</h3>
					<div class="col-8 mb-4">
						<?php
						if (isset($projectProductsArray) && !empty($projectProductsArray)) {
							echo "<p class='mb-2 fst-italic'>Tryck på någon produkt för att redigera den.</p>";
							echo "<ul class='list-group my-2'>";

							foreach ($projectProductsArray as $product) {
								echo "<button class='list-group-item list-group-item-action d-flex align-items-center rounded px-4 py-3 my-1 border shadow-sm' data-bs-toggle='modal' data-bs-target='#editProductModal' value='" . $product['product_id'] . "' onclick='selectProductData(this.value)'>"
									. $product['name'] 
									. " <span class='ms-3'>" 
									. number_format($product['price'], 2, ',', ' ') 
									. " €</span>
								</button>";
							}
					
							echo "</ul>";
						}
						?>
						<button type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#newProductModal" onclick="selectProductData()">
							Lägg till produkt
						</button>
					</div>
					

					<div class="h5 mt-3 mb-3 <?php if ($user->checkUserRole(50)) { echo "d-none"; } ?>">
						Din arbetstid:
						<span class="ms-3 fw-normal">
						<?php 
						if (!empty($totalWorkingHours['user_hours'])) {
							echo $totalWorkingHours['user_hours']; 
						} else {
							echo "0";
						}
						?> h </span><br>
						<button type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#workingHoursModal">
							Lägg till arbetstid
						</button>
					</div>
					
					<div class="h5 mt-2">Arbetstid totalt för projektet:<span class="ms-3 fw-normal">
						<?php 
						if (!empty($totalWorkingHours['total_project_hours'])) {
							echo $totalWorkingHours['total_project_hours']; 
						} else {
							echo "0";
						}
						?> h</span>
					</div>
				</div>
					

		</div>
	</div>
</div>


<div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="newProductModalLabel">Lägg till produkt</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="project-form" action="" method="post">
				<div class="modal-body">

					<label for="new-prod-name" class="form-label">Produktnamn*</label>
					<input type="text" class="form-control" id="new-prod-name" name="new-prod-name" required><br>

					<label for="new-prod-price" class="form-label">Pris*</label>
					<input type="text" class="form-control" id="new-prod-price" name="new-prod-price" required><br>

					<label for="new-prod-number" class="form-label">Produktnummer*</label>
					<input type="text" class="form-control" id="new-prod-number" name="new-prod-number" required><br>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Avbryt</button>
					<input type="submit" name="new-product-submit" class="btn btn-primary" value="Lägg till">
				</div>
			</form>
		
		</div>
	</div>
</div>


<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="editProductModalLabel">Redigera produkt</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="project-form" action="" method="post">
				<div class="modal-body">

					<label for="edit-prod-name" class="form-label">Produktnamn*</label>
					<input type="text" class="form-control" id="edit-prod-name" name="edit-prod-name" required><br>

					<label for="edit-prod-price" class="form-label">Pris*</label>
					<input type="text" class="form-control" id="edit-prod-price" name="edit-prod-price" required><br>

					<label for="edit-prod-number" class="form-label">Produktnummer*</label>
					<input type="text" class="form-control" id="edit-prod-number" name="edit-prod-number" required><br>
					
					<input type="hidden" id="edit-prod-id" name="edit-prod-id" required="required">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Avbryt</button>
					<input type="submit" id="delete-product-submit" name="delete-product-submit" class="btn btn-danger me-4" onclick="return confirmDelete()" value="Radera">
					<input type="submit" name="edit-product-submit" class="btn btn-primary" value="Spara ändringar">
				</div>
			</form>
		
		</div>
	</div>
</div>


<div class="modal fade" id="workingHoursModal" tabindex="-1" aria-labelledby="workingHoursModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="workingHoursModalLabel">Lägg till arbetstid</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="work-hours-form" action="" method="post">
				<div class="modal-body">

					<label for="work-date" class="form-label">Datum</label>
					<input type="date" class="form-control" id="work-date" name="work-date" value="<?php echo $currentDate; ?>" required><br>

					<label for="work-hours" class="form-label">Antal timmar</label>
					<input type="number" class="form-control" id="work-hours" name="work-hours" min="0" value="<?php if(!$todaysWorkingHours) { echo ""; } else {echo $todaysWorkingHours['h_amount']; } ?>" required><br>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Avbryt</button>
					<input type="submit" name="work-hours-submit" class="btn btn-primary" value="Lägg till">
				</div>
			</form>
		
		</div>
	</div>
</div>

<script>
	const workDate = document.getElementById("work-date");
	const workHours = document.getElementById("work-hours");

	workDate.addEventListener("change", function() {
		if (this.value.length == 0) {
			workHours.value = "";
			return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				workHours.value = this.responseText;
			}
			};

			const userId = '<?php echo $_SESSION["user_id"]; ?>';
            const projectId = '<?php echo $projectId; ?>';
            const selectedDate = this.value;

			xmlhttp.open("GET", "ajax/select_work_hours_by_date.php?pid=" + projectId + "&uid=" + userId + "&date=" + selectedDate, true);
			xmlhttp.send();
		}
    });

	function selectProductData(productId) {

		if (productId == undefined || productId == null || productId == "") {
        	return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var productData = JSON.parse(this.responseText);

					// Set the product data in input fields
                    document.getElementById("edit-prod-name").value = productData.name;
                    document.getElementById("edit-prod-price").value = productData.price;
                    document.getElementById("edit-prod-number").value = productData.number;
                    document.getElementById("edit-prod-id").value = productData.id;
				}
        	};
        xmlhttp.open("GET", "ajax/select_product.php?id=" + productId, true);
        xmlhttp.send();
    	}
	}

	const deleteButton = document.getElementById("delete-product-submit");

	function confirmDelete() {
		return confirm('Du är på väg att radera en produkt från projektet. Är du säker på att du vill fortsätta?');
	}
</script>

<?php
include_once 'includes/footer.php';
?>