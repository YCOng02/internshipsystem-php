<?php
$pageTitle = 'Internship Details';
include 'studentHeader.php';
?>

    <div class="main" style="height:100%;">

    <form id="form1" style="min-height:100vh;" runat="server">
            <div class="container row justify-content-md-center mx-auto">
                <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                    <a href="PreInternship.php" class="nav-link col-4 text-black text-center"
                        style="border-color: #FFFBD6">
                        Pre-Internship Forms
                    </a>
                    <a href="Progress.php" class="nav-link active col-4 text-white border-0 text-center"
                        style="background-color: #dc143c">
                        Progress Report
                    </a>
                    <a href="InternshipDetails.php" class="nav-link col-4 text-black text-center"
                        style="border-color: #FFFBD6">
                        Internship Details
                    </a>
                </div>
            </div>


            </br>
            </br>
            <div style="overflow-x: scroll;" class="container row justify-content-md-center mx-auto">
                <div class="container" style="height:55vh;">
                    <table id="SubmissionGV" class="table w-100 my-1 table-bordered table-responsive table-hover">
                        <tr style="background-color: lightgrey;">
                            <th>Report Type</th>
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <th>Submit Report</th>
                        </tr>

                        <?php
                        // Define the studentID (you need to retrieve this based on the logged-in student)
                        //$studID = 2205950; // Replace with the actual student ID
                        
                        // Create a connection
                        require 'connect.php';

                        // Check for connection errors
                        if ($con->connect_error) {
                            throw new Exception("Connection failed: " . $con->connect_error);
                        } else {
                            $sql = "SELECT * FROM internship WHERE studID=$studID";


                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Retrieve session information using sessionID (foreign key)
                                    $sessionSql = "SELECT startMonthYear, endMonthYear FROM session WHERE sessionID = " . $row['sessionID'];
                                    $sessionResult = $con->query($sessionSql);
                                    $startMonthYear = null;
                                    $endMonthYear = null;
                                    $startDate = "";
                                    $dueDate = "";
                                    $internshipStatus = $row['internshipStatus'];

                                    // Define the report fields
                                    $reportFields = array(
                                        'monthlyReport1' => 'Monthly Report 1',
                                        'monthlyReport2' => 'Monthly Report 2',
                                        'monthlyReport3' => 'Monthly Report 3',
                                        'evaluationReport' => 'Evaluation Report'
                                    );

                                    if ($sessionResult->num_rows > 0) {
                                        $sessionRow = $sessionResult->fetch_assoc();
                                        $startMonthYear = new DateTime($sessionRow['startMonthYear']);
                                        $endMonthYear = new DateTime($sessionRow['endMonthYear']);

                                        // Calculate the due date for Monthly Report 1 (1 month after startMonthYear)
                                        $dueDateMonthlyReport1 = clone $startMonthYear;
                                        $dueDateMonthlyReport1->modify('+1 month');
                                        $dueDateMonthlyReport1Str = $dueDateMonthlyReport1->format('Y-m-d');

                                        // Calculate the start date for Monthly Report 1
                                        $startDateMonthlyReport1 = clone $startMonthYear;
                                        $startDateMonthlyReport1Str = $startDateMonthlyReport1->format('Y-m-d');

                                        // Calculate the due date for Monthly Report 2 (2 months after startMonthYear)
                                        $dueDateMonthlyReport2 = clone $startMonthYear;
                                        $dueDateMonthlyReport2->modify('+2 months');
                                        $dueDateMonthlyReport2Str = $dueDateMonthlyReport2->format('Y-m-d');

                                        // Calculate the start date for Monthly Report 2
                                        $startDateMonthlyReport2 = clone $dueDateMonthlyReport1;
                                        $startDateMonthlyReport2->modify('+1 day'); // 1 day after the due date of Monthly Report 1
                                        $startDateMonthlyReport2Str = $startDateMonthlyReport2->format('Y-m-d');

                                        // Calculate the due date for Monthly Report 3 (3 months after startMonthYear)
                                        $dueDateMonthlyReport3 = clone $startMonthYear;
                                        $dueDateMonthlyReport3->modify('+3 months');
                                        $dueDateMonthlyReport3Str = $dueDateMonthlyReport3->format('Y-m-d');

                                        // Calculate the start date for Monthly Report 3
                                        $startDateMonthlyReport3 = clone $dueDateMonthlyReport2;
                                        $startDateMonthlyReport3->modify('+1 day'); // 1 day after the due date of Monthly Report 2
                                        $startDateMonthlyReport3Str = $startDateMonthlyReport3->format('Y-m-d');

                                        // Calculate the due date for Evaluation Report (last week before endMonthYear)
                                        $dueDateEvaluationReport = clone $endMonthYear;
                                        $dueDateEvaluationReport->modify('-1 week');
                                        $dueDateEvaluationReportStr = $dueDateEvaluationReport->format('Y-m-d');

                                        // Calculate the start date for Evaluation Report
                                        $startDateEvaluationReport = clone $endMonthYear;
                                        $startDateEvaluationReport->modify('-1 week'); // 1 week before endMonthYear
                                        $startDateEvaluationReportStr = $startDateEvaluationReport->format('Y-m-d');
                                    }


                                    // Loop through the report fields
                                    // Loop through the report fields
                                    foreach ($reportFields as $fieldName => $fieldLabel) {
                                        echo '<tr';
                                        echo ' style="display: none;"'; // Hide the row
                                        echo '>';
                                        echo '<td>';
                                        echo '<form action="removeReport.php" method="post">';
                                        echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                        echo '<input type="hidden" name="form_type" value="' . $fieldName . '" />';
                                        echo '<input type="submit" class="btn btn-secondary" value="Unsubmit" name="submit" />';
                                        echo '</form>';
                                        echo '</td>';
                                        echo '</tr>';

                                        echo '<tr>';
                                        echo '<td>' . $fieldLabel . '</td>';

                                        // Determine the appropriate due date based on the report type
                                        switch ($fieldName) {
                                            case 'monthlyReport1':
                                                $startDate = $startDateMonthlyReport1Str;
                                                $dueDate = $dueDateMonthlyReport1Str;
                                                break;
                                            case 'monthlyReport2':
                                                $startDate = $startDateMonthlyReport2Str;
                                                $dueDate = $dueDateMonthlyReport2Str;
                                                break;
                                            case 'monthlyReport3':
                                                $startDate = $startDateMonthlyReport3Str;
                                                $dueDate = $dueDateMonthlyReport3Str;
                                                break;
                                            case 'evaluationReport':
                                                $startDate = $startDateEvaluationReportStr;
                                                $dueDate = $dueDateEvaluationReportStr;
                                                break;
                                            default:
                                                $dueDate = "";
                                                break;
                                        }

                                        echo '<td>' . $startDate . '</td>';
                                        echo '<td>' . $dueDate . '</td>';
                                        echo '<td>';

                                        if (!empty($row[$fieldName]) || $row[$fieldName] !== null) {
                                            // Display link to view the submitted file
                                            echo '<label><b><a href="' . $row[$fieldName] . '" class="text-black" target="_blank">View File</a></b></label>';
                                            echo '<br>';
                                            // Display the "Unsubmit" button
                                            echo '<form action="removeReport.php" method="post">';
                                            echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                            echo '<input type="hidden" name="form_type" value="' . $fieldName . '" />';
                                            echo '<input type="submit" class="btn btn-secondary" value="Unsubmit" name="submit" />';
                                            echo '</form>';
                                        } else {
                                            // Check if the startDate and dueDate are within the current date
                                            $currentDate = new DateTime();

                                            if ($currentDate >= new DateTime($startDate) && $currentDate <= new DateTime($dueDate) && $internshipStatus !== 'Terminated') {
                                                // Check if the required forms are submitted
                                                if (
                                                    !empty($row['indemnity']) &&
                                                    !empty($row['parentAcknowledgement']) &&
                                                    !empty($row['companyAcceptance'])
                                                ) {
                                                    // Display file upload form
                                                    echo '<form action="submitReport.php" method="post" enctype="multipart/form-data">';
                                                    echo '<input type="file" name="pdf_file" accept=".pdf" />';
                                                    echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                                    echo '<input type="hidden" name="form_type" value="' . $fieldName . '" />';
                                                    echo '<input type="submit" class="btn btn-secondary" value="Upload" name="submit" />';
                                                    echo '</form>';
                                                } else {
                                                    // Required forms are not submitted, disable the "Submit" button
                                                    echo '<button type="button" class="btn btn-secondary" disabled>Submit Disabled</button>';
                                                }
                                            } else {
                                                // Start date and due date are not within the current date, disable the "Submit" button
                                                echo '<button type="button" class="btn btn-secondary" disabled>Submit Disabled</button>';
                                            }
                                        }
                                        echo '</td>';
                                        echo '</tr>';
                                    }



                                }
                            } else {
                                echo '<tr>';
                                echo '<td colspan="3" class="text-center">No forms found for this student.</td>';
                                echo '</tr>';
                            }

                            $con->close();
                        }
                        ?>
                    </table>
                </div>
            </div>
            </br>
            </br>
        </form>

        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    </div>

    <?php
    include 'studentFooter.php';
    ?>