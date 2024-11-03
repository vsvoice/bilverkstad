<?php
include_once 'includes/header.php';


?>


<div class="container">
	<div class="mw-500 mx-auto">
		
		<h1 class="my-5">Bilar</h1>

		<a class="btn btn-primary mb-2" href="newcar.php" role="button">Ny bil</a>

		<div class="mt-3">
			<label for="search" class="form-label" class="h5">Sök bland bilar (märke, modell, registernummer)</label>
			<input class="form-control" type="text" name="search" id="search" onkeyup="searchCars(this.value)"><br>
		</div>

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