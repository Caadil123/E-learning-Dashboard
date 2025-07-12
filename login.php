<?php
include 'includes/session.php';
include 'includes/functions.php';
if(isset($_SESSION['userId']) && $_SESSION['isLogin']){
    header("location: ./");
 }
 if (isset($_POST['btnLogin'])) {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password']));
    
    // Query the database for the user
    $user = read_where('users', "username='$username' and password='$password'");

    // print_r($user);

    // Check if the query returned any results
    if (!empty($user) && $user[0]['username'] == $username && $user[0]['password'] == $password) {
        // If user found, set session variables and redirect
        $_SESSION['userId'] = $user[0]['id'];
        $_SESSION['username'] = $user[0]['name'];
        $_SESSION['role_id'] = $user[0]['role_id'];
        $_SESSION['isLogin'] = true;
        header("location: ./");
        exit(); // Always exit after a header redirect
    } else {
        // If no user found, set the error message
        $error = "Invalid username or password";
    }
}
 

?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OnlineEdu - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- Left Side Image -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="bg-image rounded-top rounded-bottom overflow-hidden" style="background-image: url('login image/young-man-student-with-notebooks-showing-thumb-up-approval-smiling-satisfied-blue-studio-background.jpg'); background-size: cover; background-position: center; height: 100%; ">
                        </div>
                    </div>

                    <!-- Right Side Form -->
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form class="user" id="userform" action="#" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user"
                                        name="username" id="username" aria-describedby="emailHelp"
                                        placeholder="Enter Email Address...">
                                    <div class="error-message" id="username-error"></div>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user"
                                        name="password" id="password" placeholder="Password">
                                    <div class="error-message" id="password-error"></div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <button name="btnLogin" type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <?php if (isset($error)) {?>
                            <div class='text-danger mt-2'><?= $error ?></div>
                            <?php } ?>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="register.html">Create an Account!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        document.getElementById('userform').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const username = document.getElementById('username').value;
        // console.log(Cat_Name);
        if (username.trim() === '') {
            isValid = false;
            document.getElementById('username-error').textContent = 'User name is required';
        }
        const password = document.getElementById('password').value;
        // console.log(Cat_desc);
        if (password.trim() === '') {
            isValid = false;
            document.getElementById('password-error').textContent = 'password is required';
        }

        if (!isValid) {
            event.preventDefault();
        }

        });
    </script>

<style>
    .error-message {
        color: red;
        font-size: 0.875em;
        margin-top: 5px;
    }
</style>

</body>

</html>