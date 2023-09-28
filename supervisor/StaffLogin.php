<!DOCTYPE html>
<html>
<?php
session_start();
?>

<head>
    <title>Staff Login</title>
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
                <img src="https://gohchankeong-bucket.s3.amazonaws.com/logo.png" width="250" height="80" />
            </a>
            <div class="navbar-container">
                <div class="collapse navbar-collapse master" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../anonymous/UserLogin.php">Student Login <span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../supervisor/StaffLogin.php">Staff Login<span
                                    class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>

    <div id="content" class="text-dark d-flex align-items-center justify-content-center loginPage">
        <div class="loginWindow bg-white rounded col-md-5 col-lg-6 col-sm-6">
            <div class="nav-link  rounded-2 active flex-grow-1 loginTab p-3 text-center">
                <h5>Staff Login</h5>
            </div>

            <form method="post" action="loginStaff.php">
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
</body>