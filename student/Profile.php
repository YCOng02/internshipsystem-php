<?php
session_start();

// Check if the session variables are set before accessing them
if (isset($_SESSION['studName']) && isset($_SESSION['studEmail'])) {
    $studName = $_SESSION['studName'];
    $studEmail = $_SESSION['studEmail'];
} else {
    // Handle the case where the session data is not set
    $studName = "Guest";
    $studEmail = "guest@example.com";
}
?>

<html lang="en">
<head>
    <title>Master Page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://gohchankeong-bucket.s3.amazonaws.com/logo.png" width="250" height="80" />
            </a>
            <div class="navbar-container">
                <div class="collapse navbar-collapse master" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="supervisor">Home  <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container rounded bg-white mt-0 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="https://gohchankeong-bucket.s3.amazonaws.com/user-portrait.jpg">
                    <span class="font-weight-bold"><?php echo $studName; ?></span>
                    <span class="text-black-50"><?php echo $studEmail; ?></span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                    <div class="row mt-3">
                        
                        <div class="col-md-12">
                            <label class="labels">Name</label>
                            <input type="text" class="form-control" placeholder="first name" value="<?php echo $studName; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Student ID</label>
                            <input type="text" class="form-control" placeholder="first name" value="<?php echo $studName; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Email Address</label>
                            <input type="text" class="form-control" placeholder="first name" value="<?php echo $studName; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">IC No. </label>
                            <input type="text" class="form-control" placeholder="first name" value="<?php echo $studName; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Gender</label>
                            <input type="text" class="form-control" placeholder="first name" value="<?php echo $studName; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Phone No. </label>
                            <input type="text" class="form-control" placeholder="first name" value="<?php echo $studName; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Qualification</label>
                            <input type="text" class="form-control"
