<?php
/* Kevin Dang kd9me - Jennifer Huynh jph5au */

// Include config file
include "connect-db.php";

global $db;

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement

        $param_username = $_POST["username"];

        $query = "SELECT id FROM users WHERE username = '$param_username'";

        $statement = $db->prepare($query);

        $statement->execute();

        $results = $statement->fetchAll();

        if(count($results) == 1) {
            $username_err = "This username is already taken. Please enter a new one.";
        }
        else {
            $username = ($_POST["username"]);
        }
    }

    // Validate password
    if(empty($_POST["password"])){
        $password_err = "Please enter a password. (5 character minimum)";
    } elseif(strlen(($_POST["password"])) < 5){
        $password_err = "Password must have atleast 5 characters.";
    } else{
        $password = ($_POST["password"]);
    }

    // Validate confirm password
    if(empty($_POST["confirm_password"])){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = $_POST["confirm_password"];
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $query = "INSERT INTO users (userName, passWord) VALUES (:username, :password)";

        $statement = $db->prepare($query);

        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        $statement->bindValue(':username', $param_username);
        $statement->bindValue(':password', $param_password);

        $statement->execute();

        header("location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Register an Account</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Enter password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>
