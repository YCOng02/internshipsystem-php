<?php
session_start();

// Check if the session variables are set before accessing them
if (isset($_SESSION['login_failed'])) {
    $login_failed = $_SESSION['login_failed'];
}
?>
<!DOCTYPE html>
<html>
<?php
$pageTitle = 'User Login';
include 'header.php';
?>

<div id="content" class="text-dark d-flex align-items-center justify-content-center loginPage">
    <div class="loginWindow bg-white rounded col-md-5 col-lg-6 col-sm-6">
        <div class="nav-link  rounded-2 active flex-grow-1 loginTab p-3 text-center">
            <h5>User Login</h5>
        </div>

        <form method="post" action="loginUser.php">
            <div class="container-fluid">

                <?php
                if (isset($_GET['error'])) {
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
                    <i 
                        style="width: 10%; margin-top: 30px"></i>
                </div>
                <div class="text-center">

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
