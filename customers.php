<?php
include_once 'includes/header.php';


?>


<div class="container">
	<div class="mw-500 mx-auto">
		
		<h1 class="my-5">Kunder</h1>

		<a class="btn btn-primary mb-2" href="newcustomer.php" role="button">Ny kund</a>

		<div class="mt-3">
			<label for="search" class="form-label" class="h5">Sök kund</label>
			<input class="form-control" type="text" name="search" id="search" onkeyup="searchCustomers(this.value)"><br>
		</div>

		<table class='table table-striped'>
			<thead>
				<tr>
					<th scope='col'>Namn</th>
					<th scope='col'>Telefon</th>
					<th scope='col'>E-post</th>
					<th scope='col'>Adress</th>
					<th scope='col'></th>
				</tr>
			</thead>
			<tbody id="customer-field">
			</tbody>
		</table>

		<div class="col my-3">
			<h2 class="h4">Namn</h2>
		</div>
		<div class="col my-3">
			<h2 class="h4">Telefon</h2>
		</div>
		<div class="col my-3">
			<h2 class="h4">E-post</h2>
		</div>
		<div class="col my-3">
			<h2 class="h4">Adress</h2>
		</div>
	</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Code to run when the DOM is ready
        searchCustomers(" ");
    });

    function searchCustomers(str) {
    if (str.length == 0) {
        str = " ";
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("customer-field").innerHTML = this.responseText;
    }
    };
    xmlhttp.open("GET", "ajax/search_customers.php?q=" + str, true);
    xmlhttp.send();
    }
</script>

<?php
include_once 'includes/footer.php';
?>