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

$currentDate = date("Y-m-d");

$projectProductsArray = $project->selectProjectProducts($projectId);
$todaysWorkingHours = $project->selectWorkingHours($currentDate, $_SESSION['user_id'], $projectId);
$totalWorkingHours = $project->selectTotalWorkingHours($_SESSION['user_id'], $projectId);


if (isset($_POST['new-product-submit'])) {
    $feedbackMessages = $project->insertNewProduct(
		$user->cleanInput( $_POST['new-prod-name']), 
		$user->cleanInput( $_POST['new-prod-price']), 
		$user->cleanInput( $_POST['new-prod-number']),
		$projectId
	);

	if($feedbackMessages !== 1) {
		foreach($feedbackMessages as $message) {
			echo $message;
		}
    }
}

if (isset($_POST['edit-product-submit'])) {
    $feedbackMessages = $project->updateProduct(
		$user->cleanInput( $_POST['edit-prod-name']), 
		$user->cleanInput( $_POST['edit-prod-price']), 
		$user->cleanInput( $_POST['edit-prod-number']),
		$_POST['edit-prod-id']
	);

	if($feedbackMessages !== 1) {
		foreach($feedbackMessages as $message) {
			echo $message;
		}
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

	if($feedbackMessages !== 1) {
		foreach($feedbackMessages as $message) {
			echo $message;
		}
    }
}

?>


<div class="container">

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Projekt</h1>

		<a class="btn btn-primary mb-2" href="editproject.php?project_id=<?php echo $projectId ?>">Redigera</a>

		<h2 class="h4 my-3">Bil</h2>
		<div class="row">
			<p class="h6" id="car-data">
				<span id="car-brand"><?php echo $projectDataArray['car_brand'] ?></span> 
				<span id="car-model"><?php echo $projectDataArray['car_model'] ?></span> 
				<span class="ms-4" id="car-license"><?php echo $projectDataArray['car_license'] ?></span>
			</p>
		</div>

		<h2 class="h4 mt-4 mb-3">Kund</h2>
		<div class="row">
			<p class="h6" id="customer-data">
				<?php echo "{$projectDataArray['customer_fname']} {$projectDataArray['customer_lname']}" ?>
				<?php echo "<span class='ms-4'> {$projectDataArray['customer_phone']} </span>"?>
				<?php echo "<span class='ms-4'> {$projectDataArray['customer_email']} </span>"?>
				<?php echo "<span class='ms-4'> {$projectDataArray['customer_address']} {$projectDataArray['customer_zip']} {$projectDataArray['customer_area']} </span>"?>
			</p>
		</div>

		<h2 class="h4 mt-5 mb-2 fw-bold">Om projektet</h2>

		<form method="POST" action="update-status.php">
            <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
            <select class="form-select mt-4" name="status_id" aria-label="Project Status" onchange="this.form.submit()">
                <option value="1" <?php echo $projectDataArray['status_id_fk'] == 1 ? 'selected' : ''; ?>>I kö</option>
                <option value="2" <?php echo $projectDataArray['status_id_fk'] == 2 ? 'selected' : ''; ?>>Pågående</option>
                <option value="3" <?php echo $projectDataArray['status_id_fk'] == 3 ? 'selected' : ''; ?>>Pausad</option>
                <option value="4" <?php echo $projectDataArray['status_id_fk'] == 4 ? 'selected' : ''; ?>>Klar för fakturering</option>
                <option value="5" <?php echo $projectDataArray['status_id_fk'] == 5 ? 'selected' : ''; ?>>Fakturerad</option>
                <option value="6" <?php echo $projectDataArray['status_id_fk'] == 6 ? 'selected' : ''; ?>>Betalad</option>
                <option value="7" <?php echo $projectDataArray['status_id_fk'] == 7 ? 'selected' : ''; ?>>Avbokad</option>
            </select>
        </form>

		<h3 class="h5 mt-4 mb-3">Felbeskrivning</h3>
		<p><?php echo "{$projectDataArray['defect_desc']}"?></p>
		<h3 class="h5 mt-4 mb-3">Arbetsbeskrivning</h3>
		<p><?php echo "{$projectDataArray['work_desc']}"?></p>

		<div class="row">
			<h3 class="h5 my-3">Produkter</h3>
				<div class="col-8">
					<?php
					echo "<ul class='list-group'>";

					foreach ($projectProductsArray as $product) {
						echo "<button class='list-group-item list-group-item-action d-flex align-items-center rounded my-1 border shadow-sm' data-bs-toggle='modal' data-bs-target='#editProductModal' value='" . $product['product_id'] . "' onclick='selectProductData(this.value)'>"
							. $product['name'] 
							. " <span class='ms-3'>" 
							. number_format($product['price'], 2, ',', ' ') 
							. " €</span>
						</button>";
					}
			
					echo "</ul>";
					?>
					<button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#newProductModal" onclick="selectProductData()">
						Lägg till
					</button>
				</div>
		</div>

		<div class="row">
			<div class="col">
				<p class="h5 my-3">Timmar:<span class="ms-4 fw-normal"><?php echo $totalWorkingHours['total_hours']; ?></span></p>
			</div>
			<div class="col text-center">
				<button type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#workingHoursModal">
					Lägg till
				</button>
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
					<input type="text" class="form-control" id="work-hours" name="work-hours" value="<?php if(!$todaysWorkingHours) { echo ""; } else {echo $todaysWorkingHours['h_amount']; } ?>" required><br>


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