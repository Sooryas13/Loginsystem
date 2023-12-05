<?php
session_start();
include("signup_connection.php");

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: signin.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $currentPassword = test_input($_POST["password"]);
    $newPassword = test_input($_POST["newpassword"]);
    $confirmPassword = test_input($_POST["cpassword"]);

    // Verify the current password
    $stmt = $conn->prepare("SELECT password FROM signup_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_password);

    if ($stmt->fetch() && password_verify($currentPassword, $db_password)) {
        // Check if the new password and confirm password match
        if ($newPassword === $confirmPassword) {
            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $stmt = $conn->prepare("UPDATE signup_users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $hashedNewPassword, $username);

            if ($stmt->execute()) {
                echo "Password reset successful!";
            } else {
                echo "Error updating password: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "New password and confirm password do not match!";
        }
    } else {
        echo "Invalid current password!";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>forgot password</title>
  </head>
  <body>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<div class="container mt-5">
<div class="row justify-content-center">
    <h1 class="row justify-content-center">Reset your password</h1>
<div class="col-md-6">
  <form method="post">
        <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" placeholder="Enter your username" name="username">
        </div>

        <div class="form-group">
            <label for="password">Current Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" id="newpassword" placeholder="Enter your password" name="newpassword">
        </div>

        <div class="form-group">
            <label for="password">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" placeholder="Enter your password" name="cpassword">
        </div>

        
        <button type="submit" class="btn btn-primary mt-4">Reset Password</button>
  </form>
</div>
</div>
</div>
  </body>
</html>