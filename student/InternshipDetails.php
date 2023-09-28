<?php
$pageTitle = 'Internship Details';
include 'studentHeader.php';
?>

    <form id="form1" style="min-height:100vh;" runat="server">
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


    </br>
    </br>

</form>
</div>

<?php
include 'studentFooter.php';
?>