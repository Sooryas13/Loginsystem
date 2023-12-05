<?php
include("signup_connection.php");
// Define variables and set to empty values
$usernameErr = $emailErr = $passwordErr = $confirmpasswordErr = $fileErr = "";
$username = $email = $password = $confirmpassword = $file = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = "C:/xampp/htdocs/login_system/files/"; // Specify your upload directory
    // Specify your upload directory
    $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);
    $allowedExtensions = ['jpg', 'jpeg', 'png','svg'];


    // Validate username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    // } else {
    //     $username = test_input($_POST["username"]);
    //     // Check if name only contains letters and whitespace
    //     if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
    //         $usernameErr = "Only letters and white space allowed";
    //     }
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            // Check if the email already exists in the database
            $stmt = $conn->prepare("SELECT email FROM signup_users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $emailErr = "Email already exists. Please use a different email.";
            }

            $stmt->close();
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            $passwordErr = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }
    }

    // Validate confirmpassword
    if (empty($_POST["confirmpassword"])) {
        $confirmpasswordErr = "Confirm Password is required";
    } else {
        $confirmpassword = test_input($_POST["confirmpassword"]);
        // Check if passwords match
        if ($confirmpassword !== $password) {
            $confirmpasswordErr = "Passwords do not match";
        }
    }

     // Validate File Upload
     if (isset($_FILES["file"]["name"]) && !empty($_FILES["file"]["name"])) {
        $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);
        $fileExtension = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Check if the file extension is allowed
        if (!in_array($fileExtension, $allowedExtensions)) {
            $fileErr = "Only JPG, JPEG, SVG and PNG files are allowed.";
        } elseif (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
            // File upload successful, save the file URL
            $file = "http://localhost/login_system/files/" . basename($_FILES["file"]["name"]);
            // Replace with your domain
        } else {
            $fileErr = "File upload failed!";
        }
    } else {
        $fileErr = "File is required";
    }

     // If there are no validation errors, insert data into the database
     if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmpasswordErr) && empty($fileErr)) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password for security
        // $file = $_FILES["file"]["name"];

        // Using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO signup_users (username, email, password, profile_image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $file);

        if ($stmt->execute()) {
            header("Location:signin.php");
            exit();
            // echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }




}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
