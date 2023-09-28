<!DOCTYPE html>
<html>
<?php
session_start();
$pageTitle = 'Home';
include 'staffHeader.php';

// Check if the session variables are set before accessing them
if (isset($_SESSION['staffID'])) {
    $staffID = $_SESSION['staffID'];
} else {
    // Handle the case where the session data is not set
    $staffID = "empty session";
}

if (isset($_GET['StudID'])) {
    $studID = $_GET['StudID'];
}

// Create a connection
require '../student/connect.php';

// Check for connection errors
if ($con->connect_error) {
    throw new Exception("Connection failed: " . $con->connect_error);
} else {
    //generate the record in the table
    $sql = "SELECT * FROM student Stud, internship I, session Ses 
            WHERE Stud.studID = I.studID
            AND I.sessionID = Ses.sessionID
            AND Stud.studID = " . $studID;

    $result = $con->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Access the values directly from the $row variable
        $ID = $row['studID'];
        $IC = $row['studIC'];
        $Name = $row['studName'];
        $email = $row['studEmail'];
        $gender = $row['studGender'];
        $phone = $row['studPhoneNo'];
        $qualification = $row['studQualification'];
        $sessionID = $row['sessionID'];
        $internshipID = $row['internshipID'];
        $indemnity = $row['indemnity'];
        $indemnityStatus = $row['indemnityStatus'];
        $parentAcknowledgement = $row['parentAcknowledgement'];
        $parentAcknowledgementStatus = $row['parentAcknowledgementStatus'];
        $companyAcceptance = $row['companyAcceptance'];
        $companyAcceptanceStatus = $row['companyAcceptanceStatus'];
        $monthlyReport1 = $row['monthlyReport1'];
        $monthlyReport1Grade = $row['monthlyReport1Grade'];
        $monthlyReport2 = $row['monthlyReport2'];
        $monthlyReport2Grade = $row['monthlyReport2Grade'];
        $monthlyReport3 = $row['monthlyReport3'];
        $monthlyReport3Grade = $row['monthlyReport3Grade'];
        $evaluationReport = $row['evaluationReport'];
        $evaluationReportGrade = $row['evaluationReportGrade'];
        $finalGrade = $row['finalGrade'];
        $internshipStatus = $row['internshipStatus'];

    }

    $con->close();
}
?>

<div class="container">

    <div class="row my-2 mx-auto">
        <div style="width:600px;" class="border border-dark my-1 mx-auto col-md-4 col-lg-12">
            <div class="justify-content-md-center">
                <hr style="color:black;" />
                <h2 class="text-black text-center">Student Details</h2>
                <hr style="color:black;" />

                <div class="m-2 row">
                    <div class="col-2">
                        <label><b>Name</b></label>
                    </div>
                    <div class="col-9">
                        <label id="lblName">
                            <?= $Name; ?>
                        </label>
                    </div>
                </div>

                <div class="m-2 row">
                    <div class="col-2">
                        <label><b>ID</b></label>
                    </div>
                    <div class="col-4">
                        <label id="lblID">
                            <?= $ID; ?>
                        </label>
                    </div>
                    <div class="col-2">
                        <label><b>IC</b></label>
                    </div>
                    <div class="col-4">
                        <label id="lblIC">
                            <?= $IC; ?>
                        </label>
                    </div>
                </div>

                <div class="m-2 row">
                    <div class="col-2">
                        <label><b>Gender</b></label>
                    </div>
                    <div class="col-4">
                        <label id="lblGender">
                            <?= $gender; ?>
                        </label>
                    </div>
                    <div class="col-2">
                        <label><b>Phone</b></label>
                    </div>
                    <div class="col-4">
                        <label id="lblPhoneNo">
                            <?= $phone; ?>
                        </label>
                    </div>
                </div>

                <div class="m-2 row">
                    <div class="col-2">
                        <label><b>Email</b></label>
                    </div>
                    <div class="col-4 text-right">
                        <label id="lblEmail">
                            <?= $email; ?>
                        </label>
                    </div>
                </div>

                <hr style="color:black;" />
                <h2 class="text-black text-center">Internship Details</h2>
                <hr style="color:black;" />

                <div class="m-2 row">
                    <div class="col-3">
                        <label><b>Internship</b></label>
                    </div>
                    <div class="col-3">
                        <label id=" lblInternshipID" data-internship-id="<?= $internshipID ?>">
                            <?= $internshipID ?>
                        </label>
                    </div>
                    <div class="col-3">
                        <label><b>Session</b></label>
                    </div>
                    <div class="col-3">
                        <label id=" lblSession">
                            <?= $sessionID ?>
                        </label>
                    </div>
                </div>

                <div class="m-2 row">
                    <div class="col-3">
                        <label><b>Qualification</b></label>
                    </div>
                    <div class="col-3 ">
                        <label id="lblQualification">
                            <?= $qualification ?>
                        </label>
                    </div>
                    <div class="col-3">
                        <label><b>Status</b></label>
                    </div>
                    <div class="col-3 ">
                        <label id="lblInternshipStatus">
                            <?= $internshipStatus ?>
                        </label>
                    </div>
                </div>


                <div class="m-2 row justify-content-center">

                    <?php
                    if ($internshipStatus == "In Progress") {
                        echo ' <button class="border border-black w-50" id="btnTerminate" type="button"
                            onclick="Terminate()">Terminate</button>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div style="width:600px;" class="justify-content-md-center border border-dark my-1 mx-auto col-md-4 col-lg-12">
            <hr style="color:black;" />
            <h2 class="text-black text-center">Pre-Internship Submission</h2>
            <hr style="color:black;" />

            <div class="m-2 row">
                <div class="col-8">
                    <?php

                    if (str_contains($indemnity, ".pdf")) {
                        echo '<label><b><a href="' . $indemnity . '" class="text-black" id="lblIndemnity" target="_blank">
                           Indemnity </a></b> </label>';
                    } else {
                        echo '<label><b><a href="#lblIndemnity" class="text-black" id="lblIndemnity">
                            Indemnity </a></b> </label>';
                    }
                    ?>

                </div>
                <div class="col-4 justify-content-end">
                    <?php
                    if ($indemnityStatus == "Missing") {
                        echo '<label id="lblIndemnityStatus" class="w-100 mb-2"> ----- </label>';
                    } else if ($indemnityStatus != "Pending") {
                        echo '<label id="lblIndemnityStatus" class="w-100"> ' . $indemnityStatus . ' </label>';
                    } else {
                        echo '<button id="btnAcceptIndemnity" type="button" onclick="updateStatus(\'indemnityStatus\', \'Accepted\')">Accept</button> ';
                        echo '<button id="btnRejectIndemnity" type="button" onclick="updateStatus(\'indemnityStatus\', \'Rejected\')">Reject</button>';
                    }
                    ?>
                </div>
            </div>

            <div class="m-2 row">
                <div class="col-8">
                    <?php
                    if (str_contains($parentAcknowledgement, ".pdf")) {
                        echo ' <label><b><a href="' . $parentAcknowledgement . '" class="text-black" id="lblAcknowledgement"
                          target="_blank"> Parent Acknowledgement</a></b></label>';
                    } else {
                        echo ' <label><b><a href="#lblAcknowledgement" class="text-black" id="lblAcknowledgement"> 
                        Parent Acknowledgement</a></b></label>';
                    }
                    ?>

                </div>
                <div class="col-4 justify-content-end">
                    <?php
                    if ($parentAcknowledgementStatus == "Missing") {
                        echo '<label id="lblAcknowledgementStatus" class="w-100 mb-2"> ----- </label>';
                    } else if ($parentAcknowledgementStatus != "Pending") {
                        echo '<label id="lblAcknowledgementStatus" class="w-100">
                                ' . $parentAcknowledgementStatus . '</label>';
                    } else {
                        echo '<button id="btnAcceptAcknowledgement" type="button" onclick="updateStatus(\'parentAcknowledgementStatus\', \'Accepted\')">Accept</button> ';
                        echo '<button id="btnRejectAcknowledgement" type="button" onclick="updateStatus(\'parentAcknowledgementStatus\', \'Rejected\')">Reject</button> ';
                    }
                    ?>
                </div>
            </div>

            <div class="m-2 row">
                <div class="col-8">
                    <?php
                    if (str_contains($companyAcceptance, ".pdf")) {
                        echo '<label><b><a href="' . $companyAcceptance . '" class="text-black" id="lblCompanyAcceptance" target="_blank"> Company Acceptance </a></b></label>';
                    } else {
                        echo '<label><b><a href="#lblCompanyAcceptance" class="text-black" id="lblCompanyAcceptance" > Company Acceptance </a></b></label>';
                    }
                    ?>
                </div>
                <div class="col-4 justify-content-end">

                    <?php
                    if ($companyAcceptanceStatus == "Missing") {
                        echo '<label id="lblAcceptance" class="w-100 mb-2"> ----- </label>';
                    } else if ($companyAcceptanceStatus != "Pending") {
                        echo '<label id="lblAcceptance"> ' . $companyAcceptanceStatus . ' </label>';
                    } else {
                        echo '<button id="btnAcceptCompanyAcceptance" type="button" onclick="updateStatus(\'companyAcceptanceStatus\', \'Accepted\')">Accept </button> ';
                        echo '<button id="btnRejectCompanyAcceptance" type="button" onclick="updateStatus(\'companyAcceptanceStatus\', \'Rejected\')">Reject </button>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div class="row my-2 mx-auto">
        <div style="width:700px;"
            class="justify-content-md-center border border-dark my-1 mx-auto col-sm-6 col-md-6 col-lg-12">
            <hr style="color:black;" />
            <h2 class="text-black text-center">Internship Report Submission</h2>
            <hr style="color:black;" />

            <div class="m-2 row">
                <div class="col-6">
                    <?php
                    if (str_contains($monthlyReport1, ".pdf")) {
                        echo ' <label><b><a href="' . $monthlyReport1 . '" class="text-black" id="lblFirstMonthlyRport"
                            target="_blank"> First Monthly Report</a></b></label>';
                    } else {
                        echo ' <label><b><a href="#lblFirstMonthlyRport" class="text-black" id="lblFirstMonthlyRport"
                            > First Monthly Report</a></b></label>';
                    }
                    ?>
                </div>
                <div class="col-6 justify-content-center">
                    <?php
                    if ($monthlyReport1Grade == null) {
                        echo '<input  id="enterMonthlyReport1Grade" type="number"  style="-webkit-appearance: none; max="100" min="0" class="w-25"> /100 &nbsp;&nbsp;&nbsp;';
                        echo '<button id="btnGradeFirst" type="button" onclick="Graded(\'monthlyReport1Grade\')" >Grade</button>';
                    } else
                        echo '<label id="lblFirstMonthGrade" class="w-100 mx-auto ">
                             ' . $monthlyReport1Grade . ' / 100 </label>';
                    ?>
                </div>
            </div>

            <div class="m-2 row">
                <div class="col-6">
                    <?php
                    if (str_contains($monthlyReport2, ".pdf")) {
                        echo ' <label><b><a href="' . $monthlyReport2 . '" class="text-black" id="lblSecondMonthlyRport"
                            target="_blank"> Second Monthly Report</a></b></label>';
                    } else {
                        echo ' <label><b><a href="#lblSecondMonthlyRport" class="text-black" id="lblSecondMonthlyRport"
                            > Second Monthly Report</a></b></label>';
                    }
                    ?>
                </div>
                <div class="col-6 justify-content-center">
                    <?php
                    if ($monthlyReport2Grade == null) {
                        echo '<input id="enterMonthlyReport2Grade" type="number" max="100" min="0" class="w-25">/100 &nbsp;&nbsp;&nbsp;';
                        echo '<button id="btnGradeSecond" type="button" onclick="Graded(\'monthlyReport2Grade\')">Grade</button>';
                    } else
                        echo '<label id="lblSecondMonthGrade" class="w-100 mx-auto ">
                             ' . $monthlyReport2Grade . ' / 100 </label>';
                    ?>
                </div>
            </div>

            <div class="m-2 row">
                <div class="col-6">
                    <?php
                    if (str_contains($monthlyReport3, ".pdf")) {
                        echo ' <label><b><a href=' . $monthlyReport3 . '" class="text-black" id="lblThridMonthlyRport"
                            target="_blank"> Thrid Monthly Report</a></b></label>';
                    } else {
                        echo ' <label><b><a href="#lblThridMonthlyRport" class="text-black" id="lblThridMonthlyRport"
                            > Thrid Monthly Report</a></b></label>';
                    }
                    ?>
                </div>
                <div class="col-6 justify-content-center">
                    <?php
                    if ($monthlyReport3Grade == null) {
                        echo '<input  id="enterMonthlyReport3Grade" type="number" max="100" min="0" class="w-25">/100 &nbsp;&nbsp;&nbsp;';
                        echo '<button id="btnGradeThrid" type="button" onclick="Graded(\'monthlyReport3Grade\')">Grade</button>';
                    } else
                        echo '<label id="lblThridMonthGrade" class="w-100 mx-auto ">
                             ' . $monthlyReport3Grade . ' / 100 </label>';
                    ?>
                </div>
            </div>

            <div class="m-2 row">
                <div class="col-6">
                    <?php
                    if (str_contains($evaluationReport, ".pdf")) {
                        echo ' <label><b><a href="' . $evaluationReport . '" class="text-black" id="lblEvalMonthlyRport"
                            target="_blank"> Evaluation Report</a></b></label>';
                    } else {
                        echo ' <label><b><a href="#lblEvalMonthlyRport" class="text-black" id="lblEvalMonthlyRport"
                            >  Evaluation Report</a></b></label>';
                    }
                    ?>
                </div>
                <div class="col-6 justify-content-center">
                    <?php
                    if ($evaluationReportGrade == null) {
                        echo '<input  id="enterEvaluationReportGrade" type="number" max="100" min="0" class="w-25">/100 &nbsp;&nbsp;&nbsp;';
                        echo '<button id="btnGradeEvaluation" type="button" onclick="Graded(\'evaluationReportGrade\')">Grade</button>';
                    } else
                        echo '<label id="lblEvaluationGrade" class="w-100 mx-auto ">
                             ' . $evaluationReportGrade . ' / 100 </label>';
                    ?>
                </div>
            </div>

            <div class="m-2 row">
                <div class="col-6">
                    <label><b>Final Grade</b></label>
                </div>
                <div class="col-6">
                    <label id="lblFinal">
                        <?= $finalGrade ?> / 100
                    </label>
                </div>
            </div>
        </div>
        <div style="width:1000px;" class="mx-auto col-md-8 col-lg-12">
        </div>
    </div>
</div>
<script type="text/javascript">
    function updateStatus(column, updatedStatus) {
        var internshipID = "<?php echo $internshipID; ?>";

        $.ajax({
            type: "POST",
            url: "updateStudentInternshipDetail.php",
            data: {
                action: "updateDatabase",
                columnName: column,
                status: updatedStatus,
                id: internshipID
            }, success: function (response) {
                // Display the response from the server
                $("#result").html(response);
            }
        });
        location.reload();
    }

    function Terminate() {
        var internshipID = "<?php echo $internshipID; ?>";

        if (confirm("Are you sure you want to terminate this student?")) {
            $.ajax({
                type: "POST",
                url: "updateStudentInternshipDetail.php",
                data: {
                    action: "terminate",
                    id: internshipID
                }, success: function (response) {
                    // Display the response from the server
                    $("#result").html(response);
                }
            });
            window.location.href = "/supervisor/SupervisorHome.php";
            return true;
        } else {
            return false;
        }
    }

    function calFinalMark(firstReport, secondReport, thirdReport, evalReport) {
        if (firstReport != null && secondReport != null && thirdReport != null && evalReport != null)
            return parseInt(firstReport) * 0.2 + parseInt(secondReport) * 0.2 + parseInt(thirdReport) * 0.2 + parseInt(evalReport) * 0.4;
        else
            return null;
    }

    function Graded(column) {

        var response = "function call";
        $("#result").html(response);
        var internshipID = "<?php echo $internshipID; ?>";
        var firstReport = "<?php echo $monthlyReport1Grade ?>";
        var secondReport = "<?php echo $monthlyReport2Grade ?>";
        var thirdReport = "<?php echo $monthlyReport3Grade ?>";
        var evalReport = "<?php echo $evaluationReportGrade ?>";
        var final = null;
        var marks;

        switch (column) {
            case "monthlyReport1Grade":
                marks = document.getElementById("enterMonthlyReport1Grade").value;
                final = calFinalMark(marks, secondReport, thirdReport, evalReport);
                break;
            case "monthlyReport2Grade":
                marks = document.getElementById("enterMonthlyReport2Grade").value;
                final = calFinalMark(firstReport, marks, thirdReport, evalReport);
                break;
            case "monthlyReport3Grade":
                marks = document.getElementById("enterMonthlyReport3Grade").value;
                final = calFinalMark(firstReport, secondReport, marks, evalReport);
                break;
            case "evaluationReportGrade":
                marks = document.getElementById("enterEvaluationReportGrade").value;
                final = calFinalMark(firstReport, secondReport, thirdReport, marks);
                break;
            default:
                final = null;
                break;
        }

        if (marks <= 100 && marks >= 0) {
            if (confirm("The Marks for" + column + " will be set as " + parseInt(marks) + ". \n are you sure?")) {
                $.ajax({
                    type: "POST",
                    url: "updateStudentInternshipDetail.php",
                    data: {
                        action: "Graded",
                        columnName: column,
                        reportMark: marks,
                        finalMark: final,
                        id: internshipID
                    }, success: function (response) {
                        // Display the response from the server
                        $("#result").html(response);
                    }
                });


                switch (column) {
                    case "monthlyReport1Grade":
                        var inputfield = document.getElementById("enterMonthlyReport1Grade");
                        inputfield.value = marks;
                        break;
                    case "monthlyReport2Grade":
                        var inputfield = document.getElementById("enterMonthlyReport2Grade");
                        inputfield.value = marks;
                        break;
                    case "monthlyReport3Grade":
                        var inputfield = document.getElementById("enterMonthlyReport3Grade").value;
                        inputfield.value = marks;
                        break;
                    case "evaluationReportGrade":
                        var inputfield = document.getElementById("enterEvaluationReportGrade").value;
                        inputfield.value = marks;
                        break;
                    default:
                        final = null;
                        break;
                }

                location.reload();
            }
        }
    }
</script>
<?php
include 'staffFooter.php';
?>