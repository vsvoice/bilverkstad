<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

$userInfoArray = $user->getUserInfo($_GET['uid']);
$roleArray = $pdo->query("SELECT * FROM table_roles")->fetchAll();

if(isset($_POST['admin-edit-user-submit'])) {

    if(isset($_POST['is-disabled'])) {
        $uStatus=0;
    }
    else {
        $uStatus=1;
    }
	$feedback = $user->checkUserRegisterInput($_POST['uname'], $_POST['umail'], $_POST['upassnew'], $_POST['upassrepeat']);

    if($feedback === 1) {
        $editFeedback = $user->editUserInfo($_POST['umail'], $_POST['upassold'], $_POST['upassnew'], $_GET['uid'], $_POST['urole'], $uStatus);
    } else {
		foreach($feedback as $message) {
			echo $message;
		}
    }
}
?>

<div class="container">

<h1>Admin - Edit User</h1>

<form action="" method="post">

    <label for="uname">Username</label><br>
    <input class="mb-2" type="text" name="uname" id="uname" value="<?php echo $userInfoArray['u_name'] ?>" required="required" readonly><br>

    <label for="umail">Email</label><br>
    <input class="mb-2" type="email" name="umail" id="umail" value="<?php echo $userInfoArray['u_email'] ?>" required="required"><br>

    <input class="mb-2" type="hidden" name="upassold" id="upassold" required="required" value="asdfs123" readonly>

    <label for="upassnew">New Password</label><br>
    <input class="mb-2" type="password" name="upassnew" id="upassnew" required="required"><br>

    <label for="upassrepeat">Repeat Password</label><br>
    <input class="mb-2" type="password" name="upassrepeat" id="upassrepeat" required="required"><br>

    <label for="role">User Role</label><br>
    <select class="mb-3" name="urole" id="role">
    <?php
        foreach ($roleArray as $role) {
            if($role['r_id'] === $userInfoArray['u_role_fk']) {
                $selected = " selected";
            } else {
                $selected = " ";
            }
            echo "<option{$selected} value='{$role['r_id']}'>{$role['r_name']}</option>";
        }
    ?>
    </select><br>

    <input type="checkbox" id="is-disabled" name="is-disabled" value="1" <?php if($userInfoArray['u_status'] === 0){echo "checked";} ?> >
    <label class="mb-3" for="is-disabled">Disable Account</label><br>


    <input type="submit" name="admin-edit-user-submit" value="Update">
    
</form>

<a class="btn btn-danger mt-5" href="confirm-delete.php?uid=<?php echo $_GET['uid']; ?>">Delete This User</a>

</div>

<?php
include_once 'includes/footer.php';
?>