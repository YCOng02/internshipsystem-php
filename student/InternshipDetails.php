<!DOCTYPE html>
<html>
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
<body style="min-height:100vh" class="bg-bright">

    <form id="form1" runat="server">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="../image/logo.png" width="250" height="80" />
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

        <div class="container row justify-content-md-center mx-auto">
            <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                <button id="btnPre" class="nav-link col-4 text-black" style="border-color: #FFFBD6"
                onclick="redirectToPreInternship()">
                    Pre-Internship Forms
                </button>
                <button id="btnProgress" class="nav-link col-4 text-black" style="border-color: #FFFBD6"
                    onclick="redirectToProgress()">
                    Progress Report
                </button>
                <button id="btnDetails" class="nav-link active col-4 text-white border-0" style="background-color: #dc143c">
                    Internship Details
                </button>
            </div>
        </div>


        <script type="text/javascript">
            function redirectToPreInternship() {
                // Redirect to the "Progress.php" page when the button is clicked
                window.location.href = "PreInternship.php";
            }

            function redirectToProgress() {
                // Redirect to the "Progress.php" page when the button is clicked
                window.location.href = "Progress.php";
            }
        </script>


        <div style="overflow-x: scroll;" class="container row justify-content-md-center mx-auto">
            <div class="container">
                
            <div class="container">
                <table id="SubmissionGV" class="table w-100 my-1 table-bordered table-responsive table-hover">
                <?php
                    // Connect to your database (similar to what you've done in previous code)
                    $con = new mysqli('localhost', 'root', '', 'internship');

                    // Check for connection errors
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }

                    // Define the studentID (you need to retrieve this based on the logged-in student)
                    $studID = 2205950; // Replace with the actual student ID

                    // SQL query to retrieve internship details
                    $internshipSql = "SELECT 
                        internship.internshipID, 
                        internship.studID, 
                        internship.internshipStatus, 
                        internship.sessionID, 
                        session.startMonthYear, 
                        session.endMonthYear, 
                        session.qualification, 
                        staff.staffName AS supervisorName
                    FROM internship
                    INNER JOIN session ON internship.sessionID = session.sessionID
                    INNER JOIN supervisor ON session.sessionID = supervisor.sessionID
                    INNER JOIN staff ON supervisor.staffID = staff.staffID
                    WHERE internship.studID = $studID";


                    $internshipResult = $con->query($internshipSql);

                    if ($internshipResult->num_rows > 0) {
                        // Output the retrieved internship details
                        while ($row = $internshipResult->fetch_assoc()) {
                            echo "<h1>Internship Details</h1>";
                            echo "Internship ID: " . $row["internshipID"] . "<br>";
                            echo "Student ID: " . $row["studID"] . "<br>";
                            echo "Internship Status: " . $row["internshipStatus"] . "<br>";
                            echo "Session ID: " . $row["sessionID"] . "<br>";
                            echo "Start Month/Year: " . $row["startMonthYear"] . "<br>";
                            echo "End Month/Year: " . $row["endMonthYear"] . "<br>";
                            echo "Qualification: " . $row["qualification"] . "<br>";
                            echo "Supervisor: " . $row["supervisorName"] . "<br>";
                        }
                    } else {
                        echo "No internship details found for this student.";
                    }

                    // SQL query to retrieve report names and grades from the internship table
                    $reportSql = "SELECT * FROM internship WHERE studID = $studID";

                    $reportResult = $con->query($reportSql);

                    if ($reportResult->num_rows > 0) {
                        
                        // Output the retrieved report names and grades in a separate table
                        echo "<h1>Report Grades</h1>";
                        echo '<table class="report-table" border="1">
                                <tr>
                                    <th>Report Name</th>
                                    <th>Grade</th>
                                </tr>';
                    
                        $reportFields = array(
                            'monthlyReport1' => 'Monthly Report 1',
                            'monthlyReport2' => 'Monthly Report 2',
                            'monthlyReport3' => 'Monthly Report 3',
                            'evaluationReport' => 'Evaluation Report'
                        );
                    
                        while ($row = $reportResult->fetch_assoc()) {
                            foreach ($reportFields as $fieldName => $fieldLabel) {
                                $grade = $row[$fieldName . 'Grade'];
                    
                                echo "<tr>
                                        <td>$fieldLabel</td>
                                        <td>$grade</td>
                                    </tr>";
                            }
                            $finalGrade = $row['finalGrade'];
                        }
                    
                        // Add the finalGrade to the report table as the last row
                        echo "<tr>
                                <td><b>Final Grade</b></td>
                                <td><b> $finalGrade </b></td>
                            </tr>";
                    
                        echo '</table>';
                    } else {
                        echo "No report grades found for this student.";
                    }


                    // Close the database connection
                    $con->close();
                    ?>

                </table>
                

         
            </div>
        </div>

        <footer class="bg-light text-black pt-5 pb-4">
            <div class="container text-center text-md-left">
                <hr class="mb-4">
                <div class="align-items-center">
                    <div class="col-md-12 col-lg-12 text-center">
                        <p>Copyright © 2023 All Rights Reserved by:
                            <strong>2023 - TAR UMT FOCS ITP</strong>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </form>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Your custom JavaScript -->
    <script>
        $(document).ready(function () {
            $('.list-item').click(function () {
                $(this).find('.dropdown').toggle();
            });
        });
    </script>
</body>
</html>
