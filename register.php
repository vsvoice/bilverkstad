<?php	
include_once 'includes/header.php';

if(isset($_POST['register-submit'])) {
	$feedbackMessages = $user->checkUserRegisterInput($_POST['uname'], $_POST['umail'], $_POST['upass'], $_POST['upassrepeat']);

    if($feedbackMessages === 1) {
        $user->register($_POST['uname'], $_POST['umail'], $_POST['upass']);
    } else {
		echo "<div class='container'>";
		foreach($feedbackMessages as $message) {
			echo "<div class='alert alert-danger text-center' role='alert'>";
			echo 	$message;
			echo "</div>";
		}
		echo "</div>";
    }
}
?>


<div class="container">
	<div class="mw-500 mx-auto">
		<h1 class="my-5">Sign up Form</h1>
		<form action="" method="post" class="">
			<label class="form-label" for="uname">Username</label><br>
			<input class="form-control" type="text" name="uname" id="uname" required="required"><br>

			<label class="form-label" for="umail">Email</label><br>
			<input class="form-control" type="email" name="umail" id="umail" required="required"><br>

			<label class="form-label" for="upass">Password</label><br>
			<input class="form-control 2" type="password" name="upass" id="upass" required="required"><br>

			<label class="form-label" for="upass-repeat">Repeat Password</label><br>
			<input class="form-control " type="password" name="upassrepeat" id="upassrepeat" required="required"><br>

			<input class="btn btn-primary py-2 px-4" type="submit" name="register-submit" value="Sign up">
		</form>
		<p class="text-center mt-4">Already have an account? <a href="index.php">Log in</a></p>
	</div>
</div>

<?php
include_once 'includes/footer.php';
?>