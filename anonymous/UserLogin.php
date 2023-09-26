<?php
session_start();

// Check if the session variables are set before accessing them
if (isset($_SESSION['login_status'])) {
    $login_status = $_SESSION['login_status'];
} else {
    // Handle the case where the session data is not set
    $login_status = "anonymous";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>
<body style="min-height:100vh" class="bg-bright">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="SupervisorHome.php">
                <img src="../image/logo.png" width="250" height="80" />
            </a>
            <div class="navbar-container">
                <div class="collapse navbar-collapse master" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="../Supervisor/SupervisorHome.php">Home <span
                                    class="sr-only">(current)</span></a> -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div id="content" class="text-dark d-flex align-items-center justify-content-center loginPage">
        <div class="loginWindow bg-white rounded col-md-5 col-lg-6 col-sm-6">
            <div class="nav-link active flex-grow-1 loginTab p-3 text-center">User Login</div>

            <form method="post" action="loginUser.php">
                <div class="container-fluid">
                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-user" style="width: 10%; margin-top: 30px"></i>

                        <?php if ($login_status != "successful"): ?>
                            <div class="text-danger"><?php echo "Wrong input"; ?></div>
                        <?php endif; ?>

                        
                        <div class="form-floating mb-3" style="width: 60%;" id="float">
                            <input type="email" name="txtEmail" class="form-control userInput" placeholder=" " required>
                            <label for="txtEmail">Email</label>
                        </div>
                        <i style="width: 10%; margin-top: 30px"></i>
                    </div>
                    <div class="row mt-2 justify-content-center">
                        <i class="fa-solid fa-lock" style="width: 10%; margin-top: 30px"></i>
                        <div class="form-floating mb-3 " style="width: 60%;" id="float2">
                            <input type="password" name="txtPassword" class="form-control userInput" placeholder=" " required>
                            <label for="txtPassword">Password</label>
                        </div>
                        <i id="passwordVisibility" class="fa-solid fa-eye-slash" onclick="togglePasswordVisibility()" style="width: 10%; margin-top: 30px"></i>
                    </div>
                    <div class="text-center">
                        <?php
                        if ( $login_status != "successful") {
                            echo 'Wrong';
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
