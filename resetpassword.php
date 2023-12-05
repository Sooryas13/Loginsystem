<?php
session_start();
include("signup_connection.php");
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = test_input($_POST["current_password"]);
    $new_password = test_input($_POST["new_password"]);
    $confirm_password = test_input($_POST["confirm_password"]);
    
    // Retrieve the user's current password from the database
    $stmt = $conn->prepare("SELECT password FROM signup_users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $stmt->bind_result($db_password);
    if ($stmt->fetch() && password_verify($current_password, $db_password)) {
        // Free the result set before executing another query
        $stmt->free_result();
        // Current password is correct, update the password
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE signup_users SET password = ? WHERE username = ?");
            $update_stmt->bind_param("ss", $hashed_password, $_SESSION["username"]);
            if ($update_stmt->execute()) {
                $success_message = "Password updated successfully.";
            } else {
                echo "Error updating password: " . $update_stmt->error;
            }
            $update_stmt->close();
        } else {
            $error_message = "New passwords do not match.";
        }
    } else {
        $error_message = "Current password is incorrect.";
    }
    $stmt->close();
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES); // Sanitize output
    return $data;
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

    <title>Password Update</title>

    <style>
        .form-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="row justify-content-center">Reset Password</h1>
            <div class="col-md-4 form-box">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" placeholder="Enter your current password" name="current_password">
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" placeholder="Enter your new password" name="new_password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm your new password" name="confirm_password">
                    </div>
                    <?php if (isset($error_message)) : ?>
                        <div class="error-message">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($success_message)) : ?>
                        <div class="success-message">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary mt-4">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Pop--->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>