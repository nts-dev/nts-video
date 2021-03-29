<?php

use session\auth\AuthenticationServiceImpl;

include('api/session/Commons.php');

$service = new AuthenticationServiceImpl();

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userId = $_POST["trainee"];
    // Validate username
    if (empty(trim($_POST["trainee"])))
        $username_err = "Please enter a username.";
    elseif (empty(trim($_POST["identifier"])))
        $password_err = "Please enter a password.";
    else {
        $authenticated = $service->authenticateClient(
            filter_input(INPUT_POST, 'trainee', FILTER_SANITIZE_NUMBER_INT),
            filter_input(INPUT_POST, 'identifier', FILTER_SANITIZE_STRING)
        );
        if ($authenticated)
            header("location: home.php?eid=" . $userId);

        else
            $login_err = "Error";
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
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="wrapper col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
    <h2>Sign In</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group text-left">
            <label>Username</label>
            <input type="text" name="trainee"
                   class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                   value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group text-left">
            <label>Password</label>
            <input type="password" name="identifier"
                   class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                   value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <span class="invalid-feedback"><?php echo $login_err; ?></span>
        </div>
    </form>
</div>
</body>
</html>

