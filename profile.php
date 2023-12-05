<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the sign-in page if not logged in
    header("Location: signin.php");
    exit();
}

// Retrieve user details from the session
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$profile_image = $_SESSION["profile_image"];


// Check if the user clicked the sign-out button
if (isset($_POST["signout"])) {
    // Destroy the session
    session_destroy();
    // Redirect to the sign-in page after logout
    header("Location: signin.php");
    exit();
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .profile-image {
            border-radius: 50%;
            width: 250px; 
            height: 250px; 
            object-fit: cover;
            margin: auto;
            display: block;
            margin-bottom: 20px;
            margin-top:20px;
        }
        .container{
            background-image:url("pexels-veeterzy-303383.jpg");
            background-size:cover;
            height:600px;
        }
        h1,p{
            color:white;
        }
        p a{
            color:white;
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
    <form method="post" action="">
        <img src="<?php echo $profile_image; ?>" class="mt-5 profile-image" alt="Profile Image">
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <p>Email: <?php echo $email; ?></p>
        <button type="submit" class="btn btn-primary" name="signout">Sign Out</button>
    </form>
    <p><a href="resetpassword.php">Reset Password?</a></p>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>