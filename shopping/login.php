<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: checkout.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: checkout.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kyçu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<style media="screen">
  body{
    background: -webkit-linear-gradient(bottom, #0250c5, #d43f8d);
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    top: 0;
left: 0;
background-size: cover;
background-position: center;

}

#wrap-login100{
  align-items: center;
  align-content: center;
  justify-content: center;
  background: white;
  margin-top: 20px;
  margin-bottom: 20px;
  margin-left: 44em;
  min-height: 51.2em;
  width: 400px;

}
.btn-primary{
  background: #c4168d;
  font-size: 1.3em;
  width: 350px;
  height: 60px;

}
.form-control{
  padding: 3px 20px;
  font-family:sans-serif;
  font-size: 1.2em;
  width: 350px;
  height: 60px;
  margin-left: 7px;
}

</style>
<body>

    <div class="wrapper align-items-center text-center" id="wrap-login100"><br><br><br><br><br>
        <h2 style="font-weight:bold;">KYÇU</h2><br><br>
        <p style="font-family:serif;font-size:1.2em;">Ju lutemi shkruani të dhënat për tu kyçur. </p><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" >
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" >

                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Perdoruesi">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                <input type="password" name="password" class="form-control" placeholder="Fjalekalimi">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div><br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="KYÇU">
            </div><br>
            <p style="margin-top: 40px; ">Nuk keni një llogari? <a href="register.php" style="color:purple;style:none;">Regjistrohu tani</a>.</p>
        </form>
    </div>
</body>
</html>
