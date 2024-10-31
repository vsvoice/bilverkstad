<?php
include_once 'includes/header.php';


?>


<div class="container">
	<div class="mw-500 mx-auto">
		
		<h1 class="my-5">Bilar</h1>

		<a class="btn btn-primary mb-2" href="newcar.php" role="button">Ny bil</a>

		<div class="mt-3">
			<label for="search" class="form-label" class="h5">Sök bil</label>
			<input class="form-control" type="text" name="search" id="search" onkeyup="searchCars(this.value)"><br>
		</div>

		<table class='table table-striped'>
			<thead>
				<tr>
					<th scope='col'>Märke</th>
					<th scope='col'>Modell</th>
					<th scope='col'>Reg.nr.</th>
					<th scope='col'></th>
				</tr>
			</thead>
			<tbody id="car-field">
			</tbody>
		</table>

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
</script>

<?php
include_once 'includes/footer.php';
?>