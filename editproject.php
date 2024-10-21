<?php
include_once 'includes/header.php';

// Initialize the Project class
$projectClass = new Project($pdo);

// Get project_id from URL
if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    
    // Fetch project data
    $project = $projectClass->getProjectById($project_id);
    
    if (!$project) {
        echo "Project not found!";
        exit;
    }
} else {
    echo "No project selected!";
    exit;
}

// Handle form submission to update project
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form values
    $car_model = $_POST['car_model'];
    $reg_number = $_POST['reg_number'];
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];
    $fault_description = $_POST['fault_description'];
    $work_description = $_POST['work_description'];

    // Update the project in the database
    $success = $projectClass->updateProject($project_id, $car_model, $reg_number, $fault_description, $work_description);

    if ($success) {
        echo "Project updated successfully!";
        // Optionally, redirect or show a success message
    } else {
        echo "Failed to update the project!";
    }
}
?>

			<div class="container">
				<div class="mw-500 mx-auto">
					<h1 class="my-5">Redigera Projekt</h1>
					
					<!-- Project details form -->
					<form method="POST" action="project.php?project_id=<?php echo $project_id; ?>">
						<h2 class="h4 my-3">Bil</h2>

						<div class="row">
						<div class="col">
							<h3 class="h6">Märke+Modell</h3>
							<input type="text" class="form-control" value="<?php echo $project['car_brand'] . ' ' . $project['car_model']; ?>" name="car_model" readonly />
						</div>
						<div class="col">
							<h3 class="h6">Registernummer</h3>
							<input type="text" class="form-control" value="<?php echo $project['car_license']; ?>" name="reg_number" readonly />
						</div>
					</div>

					<h2 class="h4 my-3">Kund</h2>
					<div class="row">
						<div class="col">
							<h3 class="h6">Namn</h3>
							<input type="text" class="form-control" value="<?php echo $project['customer_fname'] . ' ' . $project['customer_lname']; ?>" name="customer_name" readonly />
						</div>
						<div class="col">
							<h3 class="h6">Telefonnummer</h3>
							<input type="text" class="form-control" value="<?php echo $project['customer_phone']; ?>" name="customer_phone" readonly />
						</div>
						<div class="col">
							<h3 class="h6">Epost</h3>
							<input type="email" class="form-control" value="<?php echo $project['customer_email']; ?>" name="customer_email" readonly />
						</div>
						<div class="col mb-3">
							<h3 class="h6">Adress, Postnummer, Ort</h3>
							<input type="text" class="form-control" value="<?php echo $project['customer_address'] . ', ' . $project['customer_zip'] . ' ' . $project['customer_area']; ?>" name="customer_address" readonly />
						</div>
					</div>

            <h2 class="h2 mt-3 mb-2">Om projektet</h2>

            <label class="h4 my-3">Felbeskrivning</label>
            <textarea class="form-control" name="fault_description"><?php echo $project['defect_desc']; ?></textarea>

            <label class="h4 my-3">Arbetsbeskrivning</label>
            <textarea class="form-control" name="work_description"><?php echo $project['work_desc']; ?></textarea>

            <input type="submit" class="btn btn-primary my-3" value="Redigera">
        </form>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>
