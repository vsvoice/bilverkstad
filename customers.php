<?php
include_once 'includes/header.php';


?>


<div class="container">
	<div class="mw-500 mx-auto">
		
		<h1 class="my-5">Kunder</h1>

		<a class="btn btn-primary mb-2" href="newcustomer.php" role="button">Ny kund</a>

		<div class="mt-3">
			<label for="search" class="form-label" class="h5">Sök bland kunder (namn, telefonnummer, e-post, address)</label>
			<input class="form-control" type="text" name="search" id="search" onkeyup="searchCustomers(this.value)"><br>
		</div>

		<table class='table table-striped table-hover'>
			<thead>
				<tr>
					<th scope='col'>Namn</th>
					<th scope='col'>Telefon</th>
					<th scope='col'>E-post</th>
					<th scope='col'>Adress</th>
				</tr>
			</thead>
			<tbody id="customer-field">
			</tbody>
		</table>

	</div>
</div>


<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="customerModalLabel">Projekt</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body p-1">
				<table class='table table-striped table-hover'>
					<thead>
						<tr>
							<th scope='col'>Bil</th>
							<th scope='col'>Status</th>
						</tr>
					</thead>
					<tbody id="customer-projects">
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
    }
    xmlhttp.open("GET", "ajax/search_customers.php?q=" + str, true);
    xmlhttp.send();
    }

	function selectCustomerProjects(customerId) {

		if (customerId == undefined || customerId == null || customerId == "") {
			console.log("No customerId");
			return;
		} else {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("customer-projects").innerHTML = this.responseText;
				}
			};
		xmlhttp.open("GET", "ajax/select_customer_projects.php?id=" + customerId, true);
		xmlhttp.send();
		}
	}
</script>

<?php
include_once 'includes/footer.php';
?>