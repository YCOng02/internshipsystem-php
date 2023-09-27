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
<body style="min-height:100vh;" class="bg-bright">

    <form id="form1" style="min-height:100vh;" runat="server">
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

        <div class="container row justify-content-md-center mx-auto">
            <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                <a href="PreInternship.php" class="nav-link col-4 text-black text-center" style="border-color: #FFFBD6">
                    Pre-Internship Forms
                </a>
                <a href="Progress.php" class="nav-link col-4 text-black text-center" style="border-color: #FFFBD6">
                    Progress Report
                </a>
                <a href="InternshipDetails.php" class="nav-link active col-4 text-white border-0 text-center" style="background-color: #dc143c">
                    Internship Details
                </a>
            </div>
        </div>

        
        <div style="overflow-x: scroll; height:60vh;" class="container row justify-content-md-center mx-auto">   
            <div class="container">
            
                <?php
                    require 'connect.php';
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
                        echo '</br>';
                        echo '</br>';
                        echo '<div style="display: flex; justify-content: center;">';
                        echo '<table style="width: 50%;" border="1">';
                        echo '<tr style="background-color: lightgray; color: black; text-align: center; font-size: 25px; font-weight: bold;">';
                        echo '<th style="width: 30%; "></th>';
                        echo '<th style="width: 70%;text-align: left;">Internship Details</th>';
                        echo '</tr>';
                        
                        while ($row = $internshipResult->fetch_assoc()) {
                            echo "<tr><td>Internship ID:</td><td>" . $row["internshipID"] . "</td></tr>";
                            echo "<tr><td>Student ID:</td><td>" . $row["studID"] . "</td></tr>";
                            echo "<tr><td>Internship Status:</td><td>" . $row["internshipStatus"] . "</td></tr>";
                            echo "<tr><td>Session ID:</td><td>" . $row["sessionID"] . "</td></tr>";
                            echo "<tr><td>Start Month/Year:</td><td>" . $row["startMonthYear"] . "</td></tr>";
                            echo "<tr><td>End Month/Year:</td><td>" . $row["endMonthYear"] . "</td></tr>";
                            echo "<tr><td>Qualification:</td><td>" . $row["qualification"] . "</td></tr>";
                            echo "<tr><td>Supervisor:</td><td>" . $row["supervisorName"] . "</td></tr>";
                        }
                    
                        echo '</table>';
                        echo '</div>'; // Close the centered div
                    } else {
                        echo "No internship details found for this student.";
                    }



                    // SQL query to retrieve report names and grades from the internship table
                    $reportSql = "SELECT * FROM internship WHERE studID = $studID";

                    $reportResult = $con->query($reportSql);

                    if ($reportResult->num_rows > 0) {
                    
                        // Output the retrieved report names and grades in a separate table
                        echo '<br>';
                        echo '<br>';
                        echo '<div style="display: flex; justify-content: center;">';
                        echo '<table style="width: 50%;" border="1">';
                        echo '<tr style="background-color: lightgray; color: black; text-align: center; font-size: 25px; font-weight: bold;">';
                        echo '<th style="width: 70%; text-align: center;">Report</th>';
                        echo '<th style="width: 30%; text-align: left;">Grades</th>';
                        echo '</tr>';
                
                        $reportFields = array(
                            'monthlyReport1' => 'Monthly Report 1',
                            'monthlyReport2' => 'Monthly Report 2',
                            'monthlyReport3' => 'Monthly Report 3',
                            'evaluationReport' => 'Evaluation Report'
                        );
                
                        while ($row = $reportResult->fetch_assoc()) {
                            foreach ($reportFields as $fieldName => $fieldLabel) {
                                $grade = $row[$fieldName . 'Grade'];
                                // Check if the grade is null and display as "Ungraded"
                                if ($grade === null) {
                                    $grade = "Ungraded";
                                }
                
                                echo "<tr>
                                        <td>$fieldLabel</td>
                                        <td>$grade</td>
                                    </tr>";
                            }
                            $finalGrade = $row['finalGrade'];
                        }
                
                        // Add the finalGrade to the report table as the last row
                        // Check if the finalGrade is null and display as "Ungraded"
                        if ($finalGrade === null) {
                            $finalGrade = "Ungraded";
                        }
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
            </div>
        </div>
        </div>

        </br>
        </br>

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

    
    
</body>
</html>