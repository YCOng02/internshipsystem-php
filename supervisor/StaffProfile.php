<?php
session_start();

// Check if the session variables are set before accessing them
if (isset($_SESSION['staffID'])) {
    $staffID = $_SESSION['staffID'];
    //$staffID = "ST0001";
} else {
    // Handle the case where the session data is not set
    $staffID = "empty session";
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

<?php

require '../student/connect.php';

// Check for connection errors
if ($con->connect_error) {
    throw new Exception("Connection failed: " . $con->connect_error);
} else {
    //generate the record in the table
    $sql = "SELECT * FROM staff WHERE staffID = '" . $staffID . "'; ";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $staffName = $row['staffName'];
        $staffEmail = $row['staffEmail'];
        $staffIC = $row['staffIC'];
        $staffGender = $row['staffGender'];
        $staffPhoneNo = $row['staffPhoneNo'];
    }
    $con->close();
}
?>

<script type="text/javascript">
    function editInfo() {
        var inputName = document.getElementById("lblName");
        var inputID = document.getElementById("lblID");
        var inputIC = document.getElementById("lblIC");
        var inputEmail = document.getElementById("lblEmail");
        var inputGender = document.getElementById("lblGender");
        var inputPhoneNo = document.getElementById("lblPhoneNo");
        var editBtn = document.getElementById("btnEdit");
        var cancelBtn = document.getElementById("btnCancel");
        var saveBtn = document.getElementById("btnSave");

        inputName.removeAttribute("readonly");
        inputName.focus();
        inputEmail.removeAttribute("readonly")
        inputPhoneNo.removeAttribute("readonly");
        editBtn.style.display = 'none';
        cancelBtn.style.display = 'inline-block';
        saveBtn.style.display = 'inline-block';

    }

    function saveInfo() {
        var staffID = document.getElementById("lblID").value;
        var staffName = document.getElementById("lblName").value;
        var staffPhoneNo = document.getElementById("lblPhoneNo").value;

        var testing = document.getElementById("result");
        testing.value = staffName;

        $.ajax({
            type: "POST",
            url: "updateStaffProfile.php",
            data: {
                action: "ProfileUpdate",
                id: staffID,
                name: staffName,
                phone: staffPhoneNo
            }, success: function (response) {
                // Display the response from the server
                $("#result").html(response);
            }
        });
        location.reload();
    }

    function cancelSavingInfo() {
        var inputName = document.getElementById("lblName");
        var inputID = document.getElementById("lblID");
        var inputIC = document.getElementById("lblIC");
        var inputEmail = document.getElementById("lblEmail");
        var inputGender = document.getElementById("lblGender");
        var inputPhoneNo = document.getElementById("lblPhoneNo");
        var editBtn = document.getElementById("btnEdit");
        var cancelBtn = document.getElementById("btnCancel");
        var saveBtn = document.getElementById("btnSave");

        inputName.setAttribute("readOnly", "true");
        inputEmail.setAttribute("readOnly", "true");
        inputPhoneNo.setAttribute("readOnly", "true");

        inputName.value = "<?php echo $staffName; ?>";
        inputEmail.value = "<?php echo $staffEmail; ?>";
        inputPhoneNo.value = "<?php echo $staffPhoneNo; ?>";

        cancelBtn.style.display = 'none';
        editBtn.style.display = 'inline-block';
        saveBtn.style.display = 'none';
    }

</script>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://internship-bucket-23.s3.amazonaws.com/logo.png" width="250" height="80" />
            </a>
            <div class="navbar-container">
                <div class="collapse navbar-collapse master" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="supervisor">Home <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container rounded bg-white mt-0 mb-5">

        <input type="text" id="result">
        <div id="result">sda</div>

        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px"
                        src="https://internship-bucket-23.s3.amazonaws.com/user-portrait.jpg">
                    <span class="font-weight-bold">
                        <?php echo $staffName; ?>
                    </span>
                    <span class="text-black-50">
                        <?php echo $staffEmail; ?>
                    </span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">

                    <div class="row">
                        <div class="justify-content-start col-10">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="justify-content-end align-items-end col-2">
                            <button id="btnEdit" onclick="editInfo()">Edit</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Name</label>
                            <input id="lblName" type="text" class="form-control" placeholder="Name"
                                value="<?php echo $staffName; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Staff ID</label>
                            <input id="lblID" type="text" class="form-control" placeholder="ID"
                                value="<?php echo $staffID; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Email Address</label>
                            <input id="lblEmail" type="text" class="form-control" placeholder="Email"
                                value="<?php echo $staffEmail; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">IC No. </label>
                            <input id="lblIC" type="text" class="form-control" placeholder="IC Name"
                                value="<?php echo $staffIC; ?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Gender</label>
                            <input id="lblGender" type="text" class="form-control" placeholder="Gender"
                                value="<?php echo $staffGender; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Phone No. </label>
                            <input id="lblPhoneNo" type="text" class="form-control" placeholder="first name"
                                value="<?php echo $staffPhoneNo; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mt-2 justify-content-end">
                        <div class="col-md-12 ">
                            <button style="display: none; width: 70px;" class="mx-auto" id="btnCancel"
                                onclick="cancelSavingInfo()">Cancel</button>
                            <button style="display: none; width: 70px;" class="mx-auto" id="btnSave"
                                onclick="saveInfo()">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>