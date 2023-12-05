<?php
include("register_validate.php");
include("signup_connection.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>User registration Form</title>

    <style>
        body {
            background-image: url('AdobeStock_279423926_Preview.jpeg'); /* Replace 'your-background-image.jpg' with the path to your image */
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        } 
        p a{
            text-decoration:none;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        .error{
            color:red;
        }
    </style>
  </head>
  <body>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <h1 class="row justify-content-center">Sign Up</h1>
            <div class="col-md-6">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter your username" name="username">
                        <span class="error"><?php echo $usernameErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email">
                        <span class="error"><?php echo $emailErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password">
                        <span class="error"><?php echo $passwordErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword"
                            placeholder="Confirm your password" name="confirmpassword">
                            <span class="error"><?php echo $confirmpasswordErr; ?></span>
                    </div>

                    
                <div class='form-group'>
                <label for="file" class="form-label">Upload your file</label>
                <input type="file" class="form-control" aria-label="file" name="file">
                <span class="error"><?php echo $fileErr; ?></span>
                          
                </div>
            
                    <button type="submit" class="btn btn-primary mt-4">Register</button>
                </form>
                <p class="mt-3">Already have an account? <a href="signin.php">Sign In</a></p>
            </div>
        </div>
    </div>
  </body>
</html>