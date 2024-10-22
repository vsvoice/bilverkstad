<?php
include_once 'includes/header.php';

$projectId = (int)$_GET["project_id"];
$currentDate = date("Y-m-d");

$projectDataArray = $project->selectSingleProject($projectId);
$projectProductsArray = $project->selectProjectProducts($projectId);
$todaysWorkingHours = $project->selectWorkingHours($currentDate, $_SESSION['user_id'], $projectId);
var_dump($currentDate);
var_dump($projectId);
var_dump($_SESSION['user_id']);
var_dump($todaysWorkingHours);
//var_dump($projectDataArray);
//var_dump($projectProductsArray);

if (isset($_POST['product-submit'])) {
    $feedbackMessages = $project->insertNewProduct(
		$user->cleanInput( $_POST['prod-name']), 
		$user->cleanInput( $_POST['prod-price']), 
		$user->cleanInput( $_POST['prod-number']),
		$projectId
	);

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

		<a class="btn btn-primary mb-2">Redigera</a>

		<h2 class="h4 my-3">Bil</h2>
		<div class="row">
			<p class="h6" id="car-data"><span id="car-brand"><?php echo $projectDataArray[0]['car_brand'] ?></span> <span id="car-model"><?php echo $projectDataArray[0]['car_model'] ?></span> <span class="ms-4" id="car-license"><?php echo $projectDataArray[0]['car_license'] ?></span></p>
		</div>

		<h2 class="h4 mt-4 mb-3">Kund</h2>
		<div class="row">
			<p class="h6" id="customer-data">
			<?php echo "{$projectDataArray[0]['customer_fname']} {$projectDataArray[0]['customer_lname']}" ?>
				<?php echo "<span class='ms-4'> {$projectDataArray[0]['customer_phone']} </span>"?>
				<?php echo "<span class='ms-4'> {$projectDataArray[0]['customer_email']} </span>"?>
				<?php echo "<span class='ms-4'> {$projectDataArray[0]['customer_address']} {$projectDataArray[0]['customer_zip']} {$projectDataArray[0]['customer_area']} </span>"?>
			</p>
		</div>

		<h2 class="h4 mt-5 mb-2 fw-bold">Om projektet</h2>

		<!--TODO: Status Change Feature -->
		<label for="project-status" class="h5 my-3">Status</label>
		<select id="project-status" name="project-status" class="form-select" aria-label="">
			<option value="1">I kö</option>
			<option value="2">Pågående</option>
			<option value="3">Pausad</option>
			<option value="3">Avbokad</option>
			<option value="3">Klar för fakturering</option>
		</select>

		<h3 class="h5 mt-4 mb-3">Felbeskrivning</h3>
		<p><?php echo "{$projectDataArray[0]['defect_desc']}"?></p>
		<h3 class="h5 mt-4 mb-3">Arbetsbeskrivning</h3>
		<p><?php echo "{$projectDataArray[0]['work_desc']}"?></p>

		<div class="row">
			<h3 class="h5 my-3">Produkter</h3>
				<div class="col">
					<!--<ul class="list-group">-->
						<?php
						echo "<ul class='list-group list-group-flush'>";

						foreach ($projectProductsArray as $product) {
							echo "<li class='list-group-item d-flex align-items-center'>"
								 . $product['name'] 
								 . " <span class='ms-3'>" 
								 . number_format($product['price'], 2, ',', ' ') 
								 . " €</span></li>";
						}
				
						echo "</ul>";
						?>
						<!--<li class="list-group-item d-flex align-items-center">An item <i class="ms-auto fs-5 fa-regular fa-trash-can"></i></li>
						<li class="list-group-item">A second item</li>
						<li class="list-group-item">A third item</li>
						<li class="list-group-item">A fourth item</li>
						<li class="list-group-item">And a fifth one</li>
					</ul>-->
					<button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#productModal">
						Lägg till
					</button>
				</div>
		</div>

		<div class="row">
			<div class="col">
				<p class="h5 my-3">Timmar:<span class="ms-4 fw-normal"><?php echo $todaysWorkingHours['total_hours']; ?></span></p>
			</div>
			<div class="col text-center">
				<button type="button" class="btn btn-success my-2" data-bs-toggle="modal" data-bs-target="#workingHoursModal">
					Lägg till
				</button>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="productModalLabel">Lägg till produkt</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="project-form" action="" method="post">
				<div class="modal-body">

					<label for="prod-name" class="form-label">Produktnamn*</label>
					<input type="text" class="form-control" id="prod-name" name="prod-name" required><br>

					<label for="prod-price" class="form-label">Pris*</label>
					<input type="text" class="form-control" id="prod-price" name="prod-price" required><br>

					<label for="prod-number" class="form-label">Produktnummer*</label>
					<input type="text" class="form-control" id="prod-number" name="prod-number" required><br>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Avbryt</button>
					<input type="submit" name="product-submit" class="btn btn-primary" value="Lägg till">
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
					<input type="text" class="form-control" id="work-hours" name="work-hours" value="<?php echo $todaysWorkingHours['h_amount']; ?>" required><br>


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
	const workHours = document.getElementById("work-hours")

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
</script>

<?php
include_once 'includes/footer.php';
?>