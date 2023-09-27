<!DOCTYPE html>
<html>
<?php
session_start();
$pageTitle = 'Staff Login';
include 'header.php';
?>

<body style="min-height:100vh" class="bg-bright">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="SupervisorHome.php">
                <img src="https://my-internship-content.s3.amazonaws.com/logo.png" width="250" height="80" />
            </a>
            <div class="navbar-container">
                <div class="collapse navbar-collapse master" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div id="content" class="text-dark d-flex align-items-center justify-content-center loginPage">
        <div class="loginWindow bg-white rounded col-md-5 col-lg-6 col-sm-6">
            <div class="nav-link active flex-grow-1 loginTab p-3 text-center">Staff Login</div>

            <form method="post" action="loginStaff.php">
                <div class="container-fluid">


                    <?php
                    if (isset($_SESSION['login_failed'])) {
                        echo '<div class="text-danger text-center">Invalid login email or password.</div>';
                    }
                    ?>

                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-user" style="width: 10%; margin-top: 30px"></i>

                        <div class="form-floating mb-3" style="width: 60%;" id="float">
                            <input type="email" name="txtEmail" class="form-control userInput" placeholder=" " required>
                            <label for="txtEmail">Email</label>
                        </div>
                        <i style="width: 10%; margin-top: 30px"></i>
                    </div>
                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-lock" style="width: 10%; margin-top: 30px"></i>
                        <div class="form-floating mb-3 " style="width: 60%;" id="float2">
                            <input type="password" name="txtPassword" class="form-control userInput" placeholder=" "
                                required>
                            <label for="txtPassword">Password</label>
                        </div>
                        <i id="passwordVisibility" class="fa-solid fa-eye-slash" onclick="togglePasswordVisibility()"
                            style="width: 10%; margin-top: 30px"></i>
                    </div>
                    <div class="text-center">
                        <?php
                        if (isset($loginError) && !empty($loginError)) {
                            echo '<div class="text-danger">' . $loginError . '</div>';
                        }
                        ?>
                    </div>
                    <div class="text-center">
                        <button class="btn-default w-50 mt-3" type="submit" name="btnLogin">Login</button>
                    </div>
                </div>
            </form>

            <div class="text-center">
                <div class="row text-center mb-4">
                    <a class="mt-2 loginLink" href="Register.php">Register</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementsByName('txtPassword')[0];
            var iconPasswordVisibility = document.getElementById('passwordVisibility');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                iconPasswordVisibility.classList.remove("fa-eye-slash");
                iconPasswordVisibility.classList.add("fa-eye");
            } else {
                passwordInput