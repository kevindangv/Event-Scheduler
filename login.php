<?php
/* Kevin Dang kd9me - Jennifer Huynh jph5au */

// Include config file
include "connect-db.php";

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
$num_attempts = 0;

if(isset($_GET['attempt'])){
  echo "Number of Login Attempts = " . $_GET['attempt'] . "<br/>";
  $number_attempt = intval($_GET['attempt']);
if ($number_attempt >= 3)
  echo "Please contact the admin <br/>";
} else {
  $number_attempt = 0;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty($_POST["username"])){
        $username_err = "Please enter username.";
    } else{
        $username = $_POST["username"];
    }

    // Check if password is empty
    if(empty($_POST["password"])){
        $password_err = "Please enter your password.";
    } else{
        $password = $_POST["password"];
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $username_form = $_POST["username"];

        $query = "SELECT id, username, password FROM users WHERE username = '$username_form'";

        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();

        foreach($results as $result) {
            $fetched_password = $result['password'];
        }

        if(count($results) == 1) {
            if(password_verify($password, $fetched_password)){

                echo "hello2121";

                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;

                header("location: index.php");
            }
            else{
                $num_attempts = intval($_POST['attempt']) +1;
                $login_err = "Invalid username or password.";
            }
        }
        else {
            echo "Error. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill this form to login.</p>

        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="hidden" name="attempt" value=<?php echo $num_attempts ?> >
                <input type="submit" class="btn btn-primary" value="Login" <?php if ($num_attempts >= 3) { ?> disabled <?php } ?>>
            </div>
            <p>Don't have an account? <a href="register.php">Sign up here</a>.</p>
        </form>
    </div>
</body>
</html>
