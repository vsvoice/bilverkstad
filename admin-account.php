<?php
include_once 'includes/header.php';

if ($user->checkLoginStatus()) {
    if(!$user->checkUserRole(200)) {
        header("Location: home.php");
    }
}

$userInfoArray = $user->getUserInfo($_GET['uid']);
$roleArray = $pdo->query("SELECT * FROM table_roles")->fetchAll();

if (isset($_POST['admin-edit-user-submit'])) {
    $uStatus = isset($_POST['is-disabled']) ? 0 : 1;
    $feedback = $user->checkUserRegisterInput(
        $_POST['uname'], 
        $_POST['umail'], 
        $_POST['upassnew'], 
        $_POST['upassrepeat'], 
        $_GET['uid'] // Pass the user ID here
    );

    if ($feedback === 1) {
        $editFeedback = $user->editUserInfo(
            $_POST['umail'], 
            $_POST['upassold'], 
            $_POST['upassnew'], 
            $_GET['uid'], 
            $_POST['urole'], 
            $_POST['ufname'], 
            $_POST['ulname'], 
            $uStatus
        );
    } else {
        foreach ($feedback as $message) {
            echo $message;
        }
    }
}

?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-md-6">
        <h1 class="text-center mb-4">Admin - Edit User</h1>

        <form action="" method="post" class="bg-light p-4 rounded shadow-sm">

            <div class="mb-3">
                <label for="ufname" class="form-label">Förnamn</label>
                <input type="text" class="form-control" name="ufname" id="ufname" value="<?php echo $userInfoArray['u_fname'] ?>">
            </div>
        
            <div class="mb-3">
                <label for="ulname" class="form-label">Efternamn</label>
                <input type="text" class="form-control" name="ulname" id="ulname" value="<?php echo $userInfoArray['u_lname'] ?>" >
            </div>    

            <div class="mb-3">
                <label for="uname" class="form-label">Username</label>
                <input type="text" class="form-control" name="uname" id="uname" value="<?php echo $userInfoArray['u_name'] ?>" readonly required>
            </div>

            <div class="mb-3">
                <label for="umail" class="form-label">Email</label>
                <input type="email" class="form-control" name="umail" id="umail" value="<?php echo $userInfoArray['u_email'] ?>" required>
            </div>

            <input type="hidden" name="upassold" id="upassold" value="asdfs123" readonly required>

            <div class="mb-3">
                <label for="upassnew" class="form-label">New Password</label>
                <input type="password" class="form-control" name="upassnew" id="upassnew" required>
            </div>

            <div class="mb-3">
                <label for="upassrepeat" class="form-label">Repeat Password</label>
                <input type="password" class="form-control" name="upassrepeat" id="upassrepeat" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">User Role</label>
                <select class="form-select" name="urole" id="role">
                    <?php
                        foreach ($roleArray as $role) {
                            $selected = $role['r_id'] === $userInfoArray['u_role_fk'] ? "selected" : "";
                            echo "<option {$selected} value='{$role['r_id']}'>{$role['r_name']}</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="is-disabled" name="is-disabled" value="1" <?php if($userInfoArray['u_status'] === 0){echo "checked";} ?>>
                <label class="form-check-label" for="is-disabled">Disable Account</label>
            </div>

            <div class="d-grid">
                <input type="submit" class="btn btn-primary" name="admin-edit-user-submit" value="Update">
            </div>
            
        </form>

        <div class="text-center mt-4">
            <a class="btn btn-danger" href="confirm-delete.php?uid=<?php echo $_GET['uid']; ?>">Delete This User</a>
        </div>
    </div>
</div>

<?php
include_once 'includes/footer.php';
?>
