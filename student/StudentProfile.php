<?php
$pageTitle = 'Profile';
include 'studentHeader.php';

require '../student/connect.php';

// Check for connection errors
if ($con->connect_error) {
    throw new Exception("Connection failed: " . $con->connect_error);
} else {
    //generate the record in the table
    $sql = "SELECT * FROM student WHERE studID = '" . $studID . "'; ";

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $studName = $row['studName'];
        $studEmail = $row['studEmail'];
        $studID = $row['studID'];
        $studIC = $row['studIC'];
        $studGender = $row['studGender'];
        $studPhoneNo = $row['studPhoneNo'];
        $studQualification = $row['studQualification'];
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
        var inputPhoneNo = document.getElementById("lblPhone");
        var inputQualification = document.getElementById("lblQualification");
        var editBtn = document.getElementById("btnEdit");
        var cancelBtn = document.getElementById("btnCancel");
        var saveBtn = document.getElementById("btnSave");

        inputName.removeAttribute("readonly");
        inputName.focus();
        inputPhoneNo.removeAttribute("readonly");
        editBtn.style.display = 'none';
        cancelBtn.style.display = 'inline-block';
        saveBtn.style.display = 'inline-block';
    }

    function saveInfo() {
        var staffID = document.getElementById("lblID").value;
        var staffName = document.getElementById("lblName").value;
        var staffPhoneNo = document.getElementById("lblPhone").value;

        $.ajax({
            type: "POST",
            url: "updateStudentProfile.php",
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
        var inputPhoneNo = document.getElementById("lblPhone");
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

                <div class="row">
                    <div class="justify-content-start col-10">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="justify-content-end align-items-end col-2">
                        <button id="editBtn" onclick="editInfo()">Edit</button>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Name</label>
                        <input type="text" class="form-control" placeholder="name" id="lblName" name="lblName"
                            value="<?php echo $studName; ?>" readonly>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Student ID</label>
                        <input type="text" class="form-control" placeholder="first name" id="lblID"
                            value="<?php echo $studID; ?>" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Email Address</label>
                        <input type="text" class="form-control" placeholder="first name" id="lblEmail"
                            value="<?php echo $studEmail; ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">IC No. </label>
                        <input type="text" class="form-control" placeholder="first name" id="lblIC"
                            value="<?php echo $studIC; ?>" readonly>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">Gender</label>
                        <input type="text" class="form-control" placeholder="first name" id="lblGender"
                            value="<?php echo $studGender; ?>" readonly>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">Phone No. </label>
                        <input type="text" class="form-control" placeholder="first name" id="lblPhone"
                            value="<?php echo $studPhoneNo; ?>" readonly>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label class="labels">Qualification </label>
                        <input type="text" class="form-control" placeholder="first name" id="lblQualification"
                            value="<?php echo $studQualification; ?>" readonly>
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


<?php
include 'studentFooter.php';

?>