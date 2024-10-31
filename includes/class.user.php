<?php

class User {

    private $username;
    private $role;
    private $pdo;
    private $errorMessages = [];
    private $errorState = 0;


    function __construct($pdo) {
        $this->role = 4;
        $this->username = "RandomGuest123";
        $this->pdo = $pdo;
    }

    public function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function checkUserRegisterInput($uname, $umail, $upass, $upassrepeat) {
        // START Check if user-entered username or email exists in the database
        if(isset($_POST['register-submit'])) {
            $this->errorState = 0;
            $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uname OR u_email = :email');
            $stmt_checkUsername->bindParam(':uname', $uname, PDO::PARAM_STR);
            $stmt_checkUsername->bindParam(':email', $umail, PDO::PARAM_STR);
            $stmt_checkUsername->execute();

            // Check if query returns any result
            if($stmt_checkUsername->rowCount() > 0) {
                array_push($this->errorMessages, "Användarnamn eller e-postadress är upptagen! ");
                $this->errorState = 1;
            }
        }
        else {
            $stmt_checkUserEmail = $this->pdo->prepare('SELECT * FROM table_users WHERE u_email = :email');
            $stmt_checkUserEmail->bindParam(':email', $umail, PDO::PARAM_STR);
            $stmt_checkUserEmail->execute();

            // Check if query returns any result
            if($stmt_checkUserEmail->rowCount() > 0) {
                array_push($this->errorMessages, "E-postadressen är upptagen! ");
                $this->errorState = 1;
            }
        }
        // END Check if user-entered username or email exists in the database

        // START Check if user-entered passwords match each other, and are at least 8 characters long
        if($upass !== $upassrepeat) {
            array_push($this->errorMessages, "Lösenorden matchar inte! ");
            $this->errorState = 1;
        }
        else {
            if (strlen($upass) < 8) {
                array_push($this->errorMessages, "Lösenordet är för kort! ");
                $this->errorState = 1;
            }
        }
        // END Check if user-entered passwords match each other, and are at least 8 characters long

        // START Check if user-entered email is a "real" address
        if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorMessages, "E-postadressen är inte i rätt format! ");
            $this->errorState = 1;
        }
        // END Check if user-entered email is a "real" address

        if ($this->errorState == 1) {
            return $this->errorMessages;
        } else {
            return 1;    
        }
    }


    public function register($uname, $umail, $upass, $fname, $lname) {
        $hashedPassword = password_hash($upass, PASSWORD_DEFAULT);
        $uname = $this->cleanInput($uname);
        $fname = $this->cleanInput($fname);
        $lname = $this->cleanInput($lname);

        if(password_verify($upass, $hashedPassword)) {
            $stmt_insertNewUser = $this->pdo->prepare('INSERT INTO table_users (u_name, u_password, u_email, u_role_fk, u_status, u_fname, u_lname) 
            VALUES 
            (:uname, :upass, :umail, 1, 1, :fname, :lname)');
            $stmt_insertNewUser->bindParam(':uname', $uname, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':upass', $hashedPassword, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':umail', $umail, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt_insertNewUser->bindParam(':lname', $lname, PDO::PARAM_STR);
        }
        
        if($stmt_insertNewUser->execute()) {
            return 1;
        } else {
            array_push($this->errorMessages, "Lyckades inte registrera användaren! Kontakta support!");
            return $this->errorMessages;
        }

    }

    public function login($unamemail, $upass) {
        
        $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uname OR u_email = :email');
        $stmt_checkUsername->bindParam(':uname', $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->bindParam(':email', $unamemail, PDO::PARAM_STR);
        $stmt_checkUsername->execute();

        // Check if query returns a result
        if($stmt_checkUsername->rowCount() === 0) {
            array_push($this->errorMessages, "Username or email does not exist! ");
            return $this->errorMessages;
            
        }
        // Save user data to an array
        $userData = $stmt_checkUsername->fetch();

        if(password_verify($upass, $userData['u_password'])) {
            $_SESSION['user_id'] = $userData['u_id'];
            $_SESSION['user_name'] = $userData['u_name'];
            $_SESSION['user_email'] = $userData['u_email'];
            $_SESSION['user_role'] = $userData['u_role_fk'];

            header("Location: home.php");
            exit();
        } else {
            array_push($this->errorMessages, "Password is incorrect! ");
            return $this->errorMessages;
        }
    }

    public function checkLoginStatus() {
        if(isset($_SESSION['user_id'])) {
            return TRUE;
        } else {
            header("Location: index.php");  
            exit();
        }
    }



    public function checkUserRole($requiredValue) {
        /*$stmt_checkUserRole = $this->pdo->prepare(
        'SELECT u_role_fk, r_level
        FROM table_users
        INNER JOIN table_roles ON table_users.u_role_fk = table_roles.r_id
        WHERE u_id = :id');
        $stmt_checkUserRole->bindParam(':id', $userRoleValue, PDO::PARAM_INT);
        $stmt_checkUserRole->execute();*/
        
        $stmt_checkUserRole = $this->pdo->prepare(
            'SELECT r_level FROM table_roles WHERE r_id = :rid');
        $stmt_checkUserRole->bindParam(':rid', $_SESSION['user_role'], PDO::PARAM_INT);
        $stmt_checkUserRole->execute();

        $userRoleData = $stmt_checkUserRole->fetch();

        if ($userRoleData['r_level'] >= $requiredValue) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function editUserInfo($umail, $upassold, $upassnew, $uid, $role, $status) {
        
        // Get password of current user
        $stmt_getUserPassword = $this->pdo->prepare('SELECT u_password FROM table_users WHERE u_id = :uid');
        $stmt_getUserPassword->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt_getUserPassword->execute();
        $oldPassword = $stmt_getUserPassword->fetch();
        
        if(isset($_POST['edit-user-submit'])) {
            // Check if entered password is correct
            if(!password_verify($upassold, $oldPassword['u_password'])) {
                return "The password is invalid";
            }
        }
        
        $hashedPassword = password_hash($upassnew, PASSWORD_DEFAULT);
        // Update in the database 
        $stmt_editUserInfo = $this->pdo->prepare('
        UPDATE table_users
        SET u_email = :umail, u_password = :upassnew, u_role_fk = :role, u_status = :status
        WHERE u_id = :uid');
        $stmt_editUserInfo->bindParam(':umail', $umail, PDO::PARAM_STR);
        $stmt_editUserInfo->bindParam(':upassnew', $hashedPassword, PDO::PARAM_STR);
        $stmt_editUserInfo->bindParam(':role', $role, PDO::PARAM_INT);
        $stmt_editUserInfo->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt_editUserInfo->bindParam(':uid', $uid, PDO::PARAM_INT);
        
        if($stmt_editUserInfo->execute() && $uid == $_SESSION['user_id']) {
            $_SESSION['user_email'] = $umail;
        };
    }

    public function searchUsers($input) {
        // Replace all whitespace characters with % wildcards
        $input = preg_replace('/\s+/', '%', $input);

        $inputJoker = "%".$input."%";
        $stmt_searchUsers = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name LIKE :uname OR u_email LIKE :email OR u_fname LIKE :fname OR u_lname LIKE :lname OR CONCAT(u_fname, u_lname) LIKE :fullname');
        $stmt_searchUsers->bindParam(':uname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':email', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':fname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':lname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->bindParam(':fullname', $inputJoker, PDO::PARAM_STR);
        $stmt_searchUsers->execute();
        $usersList = $stmt_searchUsers->fetchAll();
        
        return $usersList;
    }

    public function populateUserField($usersArray) {
        foreach ($usersArray as $user) {
            echo "
            <tr>
                <td>{$user['u_name']}</td>
                <td>{$user['u_email']}</td>
                <td><a class='btn btn-primary' href='admin-account.php?uid={$user['u_id']}'>Redigera</a><br></td>
            </tr>";
        }
    }

    public function getUserInfo($uid) {
        $stmt_selectUserData = $this->pdo->prepare('SELECT * FROM table_users WHERE u_id = :uid');
        $stmt_selectUserData->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stmt_selectUserData->execute();
        $userInfo = $stmt_selectUserData->fetch();
        return $userInfo;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    public function deleteUser($uid) {
        $stmt_deleteUser = $this->pdo->prepare('DELETE FROM table_users WHERE u_id = :uid');
        $stmt_deleteUser->bindParam(':uid', $uid, PDO::PARAM_INT);

        if($stmt_deleteUser->execute()) {
            return "User deleted successfully";
        } else {
            return "Something went wrong... Please try again or contact support.";
        }
    }

    public function getAllWorkingHours(string $fromDate, string $toDate) {
        $stmt_selectWorkingHours = $this->pdo->prepare('SELECT 
                u.u_id,
                u.u_fname,
                u.u_lname,
                SUM(h.h_amount) AS total_hours
            FROM 
                table_hours h
            JOIN 
                table_users u ON h.u_id_fk = u.u_id
            WHERE 
                h.h_date BETWEEN :fromDate AND :toDate
                AND u.u_status = 1
                AND u.u_role_fk = 1
            GROUP BY 
                u.u_id, u.u_fname, u.u_lname;');
        $stmt_selectWorkingHours->bindParam(':fromDate', $fromDate, PDO::PARAM_STR);
        $stmt_selectWorkingHours->bindParam(':toDate', $toDate, PDO::PARAM_STR);
        $stmt_selectWorkingHours->execute();
        $workingHours = $stmt_selectWorkingHours->fetchAll();
        return $workingHours;
    }

    public function populateWorkingHoursField($hoursArray) {
        foreach ($hoursArray as $user) {
            echo "<div class='row list-group-item d-flex py-3'>
                    <div class='col'>
                        {$user['u_fname']} {$user['u_lname']}
                    </div>
                    <div class='col'>
                        {$user['total_hours']}
                    </div>
                </div>";
        }
    }

}

?>