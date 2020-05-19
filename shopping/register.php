<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Regjistrohu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <style type="text/css">
    body{
      background: -webkit-linear-gradient(bottom, #0250c5, #d43f8d);
      background-repeat: no-repeat;
      width: 100%;
      height: 100%;
      top: 0;
  left: 0;
  background-size: cover;
  background-position: center;
  font: 14px sans-serif;
  }
        .wrapper{ width: 350px; padding: 20px; }
        #wrap-register100{
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

        .form-control{
          padding: 3px 20px;
          font-family:sans-serif;
          font-size: 1.2em;
          width: 350px;
          height: 60px;

        }

        .btn-primary{
          background: #c4168d;
          padding: 3px 20px;
          font-size: 1.3em;
          width: 350px;
          height: 60px;

        }
    </style>
</head>
<body>
    <div class="wrapper" id="wrap-register100"><br><br><br>
        <h2 align="center">REGJISTROHU</h2>
        <p align="center">Ju lutemi plotësoni këtë formular për të krijuar një llogari.</p><br><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                <input type="text" name="username" class="form-control" placeholder="Perdoruesi" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                <input type="password" name="password" class="form-control" placeholder="Fjalekalimi" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

                <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmo Fjalekalimin" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="REGJISTROHU">

            </div>
            <p style="margin-top:60px">Tashme keni nje llogari? <a href="login.php" style="color:purple;style:none;">Kyçuni ketu</a>.</p>
        </form>
    </div>
</body>
</html>
