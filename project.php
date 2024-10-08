<?php
include_once 'includes/header.php';

$projectId = $_GET["project_id"];
$projectDataArray = $project->selectSingleProject($projectId);
$projectProductsArray = $project->selectProjectProducts($projectId);
var_dump($projectDataArray);
//var_dump($projectProductsArray);

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

		<h2 class="h4 mt-4 mb-2">Om projektet</h2>

		<label for="project-status" class="h5 my-3">Status</label>
		<select id="project-status" name="project-status" class="form-select" aria-label="">
			<option value="1">I kö</option>
			<option value="2">Pågående</option>
			<option value="3">Pausad</option>
			<option value="3">Avbokad</option>
			<option value="3">Klar för fakturering</option>
		</select>

		<h3 class="h5 my-3">Felbeskrivning</h3>
		<p><?php echo "{$projectDataArray[0]['defect_desc']}"?></p>
		<h3 class="h5 my-3">Arbetsbeskrivning</h3>
		<p><?php echo "{$projectDataArray[0]['work_desc']}"?></p>

		<div class="row">
			<h3 class="h5 my-3">Produkter</h3>
				<div class="col">
					<ul class="list-group">
						<li class="list-group-item">An item</li>
						<li class="list-group-item">A second item</li>
						<li class="list-group-item">A third item</li>
						<li class="list-group-item">A fourth item</li>
						<li class="list-group-item">And a fifth one</li>
					</ul>
					<a class="btn btn-success my-2">Lägg till</a>
				</div>
		</div>

		<div class="row">
			<div class="col">
				<p class="h5 my-3">Timmar:<span class="ms-4 fw-normal">34h 30min</span></p>
			</div>
			<div class="col text-center">
				<a class="btn btn-success my-2">Lägg till</a>
			</div>
		</div>

	</div>
</div>

<?php
include_once 'includes/footer.php';
?>