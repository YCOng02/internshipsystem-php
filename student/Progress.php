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
                <a href="PreInternship.php" class="nav-link col-4 text-black text-center" style="border-color: #FFFBD6">
                    Pre-Internship Forms
                </a>
                <a href="Progress.php" class="nav-link active col-4 text-white border-0 text-center" style="background-color: #dc143c">
                    Progress Report
                </a>
                <a href="InternshipDetails.php" class="nav-link col-4 text-black text-center" style="border-color: #FFFBD6">
                    Internship Details
                </a>
            </div>
        </div>

        
        </br>
        </br>
        <div style="overflow-x: scroll;" class="container row justify-content-md-center mx-auto">
            <div class="container">
                <table id="SubmissionGV" class="table w-100 my-1 table-bordered table-responsive table-hover">
                    <tr style="background-color: lightgrey;">
                        <th>Report Type</th>
                        <th>Due Date</th>
                        <th>Submit Report</th>
                    </tr>

                    <?php
                    // Define the studentID (you need to retrieve this based on the logged-in student)
                    $studID = 2205950; // Replace with the actual student ID

                    // Create a connection
                    $con = new mysqli('localhost', 'root', '', 'internship');

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
                                $dueDate = "";

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

                                    // Calculate the due date for Monthly Report 2 (2 months after startMonthYear)
                                    $dueDateMonthlyReport2 = clone $startMonthYear;
                                    $dueDateMonthlyReport2->modify('+2 months');
                                    $dueDateMonthlyReport2Str = $dueDateMonthlyReport2->format('Y-m-d');

                                    // Calculate the due date for Monthly Report 3 (3 months after startMonthYear)
                                    $dueDateMonthlyReport3 = clone $startMonthYear;
                                    $dueDateMonthlyReport3->modify('+3 months');
                                    $dueDateMonthlyReport3Str = $dueDateMonthlyReport3->format('Y-m-d');

                                    // Calculate the due date for Evaluation Report (last week before endMonthYear)
                                    $dueDateEvaluationReport = clone $endMonthYear;
                                    $dueDateEvaluationReport->modify('-1 week');
                                    $dueDateEvaluationReportStr = $dueDateEvaluationReport->format('Y-m-d');
                                }
                                
                                // Loop through the report fields
                                foreach ($reportFields as $fieldName => $fieldLabel) {
                                    echo '<tr';
                                    echo ' style="display: none;"'; // Hide the row
                                    echo '>';
                                    echo '<td>';
                                    echo '<form action="removeReport.php" method="post">';
                                    echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                    echo '<input type="hidden" name="form_type" value="' . $fieldName . '" />';
                                    echo '<input type="submit" value="Unsubmit" name="submit" />';
                                    echo '</form>';
                                    echo '</td>';
                                    echo '</tr>';

                                    echo '<tr>';
                                    echo '<td>' . $fieldLabel . '</td>';
                                    // Determine the appropriate due date based on the report type
                                    switch ($fieldName) {
                                        case 'monthlyReport1':
                                            $dueDate = $dueDateMonthlyReport1Str;
                                            break;
                                        case 'monthlyReport2':
                                            $dueDate = $dueDateMonthlyReport2Str;
                                            break;
                                        case 'monthlyReport3':
                                            $dueDate = $dueDateMonthlyReport3Str;
                                            break;
                                        case 'evaluationReport':
                                            $dueDate = $dueDateEvaluationReportStr;
                                            break;
                                        default:
                                            $dueDate = ""; 
                                            break;
                                    }
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
                                        echo '<input type="submit" value="Unsubmit" name="submit" />';
                                        echo '</form>';
                                    } else {
                                        // Check if the due date has passed
                                        $dueDateTimestamp = strtotime($dueDate);
                                        $currentDateTimestamp = strtotime(date('Y-m-d'));
                                        if ($dueDateTimestamp < $currentDateTimestamp) {
                                            // Due date has passed and the form is not submitted, disable the "Submit" button
                                            echo '<button type="button" class="btn btn-secondary" disabled>Submit Disabled</button>';
                                        } else {
                                            // Display file upload form
                                            echo '<form action="submitReport.php" method="post" enctype="multipart/form-data">';
                                            echo '<input type="file" name="pdf_file" accept=".pdf" />';
                                            echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                            echo '<input type="hidden" name="form_type" value="' . $fieldName . '" />';
                                            echo '<input type="submit" value="Upload" name="submit" />';
                                            echo '</form>';
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
