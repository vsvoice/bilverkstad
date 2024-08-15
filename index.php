<?php
include_once 'includes/header.php';

if(isset($_POST['user-login'])) {
 $errorMessages = $user->login($_POST['uname'], $_POST['upass']);

}
?>


<div class="container">

	<?php
	if(isset($_GET['newuser'])) {
		echo "<div class='alert alert-success text-center' role='alert'>
			You have successfully signed up. Please login using the form below.
		</div>";
	}

	if(isset($errorMessages)) {
		
		echo "<div class='alert alert-danger text-center' role='alert'>";
		foreach($errorMessages as $message) {
			echo $message;
		}
		echo "</div>";$message;
	}
	?>

	<div class="mw-500 mx-auto">
		<h1 class="my-5">Login Form</h1>
		<form action="" method="post">

			<label class="form-label" for="uname">Username or Email</label><br>
			<input class="form-control" type="text" name="uname" id="uname"><br>

			<label class="form-label" for="upass">Password</label><br>
			<input class="form-control" type="password" name="upass" id="upass"><br>

			<input class="btn btn-primary py-2 px-4" type="submit" name="user-login" value="Login">
			
		</form>
		<p class="text-center mt-4">Don't have an account? <a href="index.php">Sign up</a></p>
	</div>
</div>

<?php
include_once 'includes/footer.php';
?>