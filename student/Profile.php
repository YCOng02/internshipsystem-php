<?php
$pageTitle = 'Profile';
include 'studentHeader.php';

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

<div class="container rounded bg-white mt-0 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px"
                    src="https://internship-bucket-23.s3.amazonaws.com/user-portrait.jpg">
                <span class="font-weight-bold">
                    <?php echo $studName; ?>
                </span>
                <span class="text-black-50">
                    <?php echo $studEmail; ?>
                </span>
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
                        <input type="text" class="form-control" placeholder="first name"
                            value="<?php echo $studName; ?>" readonly>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Student ID</label>
                        <input type="text" class="form-control" placeholder="first name"
                            value="<?php echo $studName; ?>" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Email Address</label>
                        <input type="text" class="form-control" placeholder="first name"
                            value="<?php echo $studName; ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">IC No. </label>
                        <input type="text" class="form-control" placeholder="first name"
                            value="<?php echo $studName; ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">Gender</label>
                        <input type="text" class="form-control" placeholder="first name"
                            value="<?php echo $studName; ?>" readonly>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">Phone No. </label>
                        <input type="text" class="form-control" placeholder="first name"
                            value="<?php echo $studName; ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">Qualification</label>
                        <input type="text" class="form-control"