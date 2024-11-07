<?php
include_once 'includes/header.php';

$user->checkLoginStatus();
?>


<div class="container">
	<div class="mw-500 mx-auto">
		
		<h1 class="my-5">Bilar</h1>
		
		<?php
			// Prevent accountants from seeing the button
			if(!$user->checkUserRole(50) || $user->checkUserRole(200)) {
				echo '<a class="btn btn-primary mb-2" href="newcar.php" role="button">Ny bil</a>';
			}
		?>
		<div class="card rounded-4 text-start shadow-sm px-3 py-4 mt-2">
			<div class="mb-3">
				<label for="search" class="form-label" class="h5">Sök bland bilar (märke, modell eller registernummer)</label>
				<input class="form-control" type="text" name="search" id="search" onkeyup="searchCars(this.value)">
			</div>

			<p class="mt-4 mb-2 fst-italic">Tryck på valfri bil för att visa tillhörande projekt.</p>
			<div class="table-responsive">
				<table class='table table-striped table-hover'>
					<thead>
						<tr>
							<th scope='col'>Märke</th>
							<th scope='col'>Modell</th>
							<th scope='col'>Registernummer</th>
						</tr>
					</thead>
					<tbody id="car-field">
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="carModal" tabindex="-1" aria-labelledby="carModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="carModalLabel">Projekt</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-1">
				<table class='table table-striped table-hover'>
					<thead>
						<tr>
							<th scope='col'>Kund</th>
							<th scope='col'>Status</th>
						</tr>
					</thead>
					<tbody id="car-projects">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Tillbaka</button>
			</div>
		</div>
	</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Code to run when the DOM is ready
        searchCars(" ");
    });

    function searchCars(str) {
    if (str.length == 0) {
        str = " ";
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("car-field").innerHTML = this.responseText;
    }
    };
    xmlhttp.open("GET", "ajax/search_cars.php?q=" + str, true);
    xmlhttp.send();
    }

	function selectCarProjects(carId) {

		if (carId == undefined || carId == null || carId == "") {
			console.log("No carId");
			return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("car-projects").innerHTML = this.responseText;
				}
			};
		xmlhttp.open("GET", "ajax/select_car_projects.php?id=" + carId, true);
		xmlhttp.send();
		}
	}
</script>

<?php
include_once 'includes/footer.php';
?>