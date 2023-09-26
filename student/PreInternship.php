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

<body class="bg-bright">

    <form id="form1" runat="server">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="https://my-internship-content.s3.amazonaws.com/logo.png" width="250" height="80" />
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
                <a href="PreInternship.php" class="nav-link active col-4 text-white border-0 text-center" style="background-color: #dc143c">
                    Pre-Internship Forms
                </a>
                <a href="Progress.php" class="nav-link col-4 text-black text-center" style="border-color: #FFFBD6">
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
                        <th>Form Type</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Submit PDF</th> 
                    </tr>

                    <?php
                    // Define the studentID (you need to retrieve this based on the logged-in student)
                    $studID = 2205950; // Replace with the actual student ID

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
                                $sessionSql = "SELECT startMonthYear FROM session WHERE sessionID = " . $row['sessionID'];
                                $sessionResult = $con->query($sessionSql);
                                $dueDate = "";

                                $indemnity = $row['indemnity'];
                                $parentAcknowledgement = $row['parentAcknowledgement'];
                                $companyAcceptance = $row['companyAcceptance'];

                                if ($sessionResult->num_rows > 0) {
                                    $sessionRow = $sessionResult->fetch_assoc();
                                    // Calculate the due date by subtracting one month from startMonthYear
                                    $startMonthYear = new DateTime($sessionRow['startMonthYear']);
                                    $dueDate = $startMonthYear->modify('+1 month')->format('Y-m-d');
                                }
                                // Check if the due date is in the past
                                $dueDateTimestamp = strtotime($dueDate);
                                $currentDateTimestamp = strtotime(date('Y-m-d'));

                                echo '<br>';
                                echo '<tr';
                                echo ' style="display: none;"'; // Hide the row 
                                echo '>';
                                echo '<td>';
                                // Display the "Unsubmit" button
                                echo '<form action="removePDF.php" method="post">';
                                echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                echo '<input type="hidden" name="form_type" value="indemnity" />';
                                echo '<input type="submit" class="btn btn-secondary" value="Unsubmit" name="submit" />';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                                

                                echo '</td>';
                                echo '</tr>';
                                
                                echo '<tr>';
                                echo '<td>Indemnity</td>';
                                echo '<td>' . $row['indemnityStatus'] . '</td>';
                                echo '<td>' . $dueDate . '</td>';
                                echo '<td>';

                                if ($row['indemnity'] !== '' && ($row['indemnityStatus'] === 'Pending' || $row['indemnityStatus'] === 'Submitted')) {
                                    // Display link to view the submitted file
                                    echo '<label><b><a href="' . $row['indemnity'] . '" class="text-black" target="_blank">View File</a></b></label>';
                                    echo '<br>';
                                    // Display the "Unsubmit" button
                                    echo '<form action="removePDF.php" method="post">';
                                    echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                    echo '<input type="hidden" name="form_type" value="indemnity" />';
                                    echo '<input type="submit" class="btn btn-secondary" value="Unsubmit" name="submit" />';
                                    echo '</form>';
                                } else {
                                    // Check if the due date has passed and the status is "Missing"
                                    if ($dueDateTimestamp < $currentDateTimestamp && $row['indemnityStatus'] === 'Missing') {
                                        // Due date has passed and the form is not submitted, disable the "Submit" button
                                        echo '<button type="button" class="btn btn-secondary" disabled>Submit Disabled</button>';
                                    } else {
                                        // Display file upload form
                                        echo '<form action="submitPDF.php" method="post" enctype="multipart/form-data">';
                                        echo '<input type="file" name="pdf_file" accept=".pdf" />';
                                        echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                        echo '<input type="hidden" name="form_type" value="indemnity" />';
                                        echo '<input type="submit" class="btn btn-secondary" value="Upload" name="submit" />';
                                        echo '</form>';
                                    }
                                }
                                

                                echo '</td>';
                                echo '</tr>';


                                
                                echo '<tr';
                                echo ' style="display: none;"'; // Hide the row 
                                echo '>';
                                echo '<td>';
                                // Display the "Unsubmit" button
                                echo '<form action="removePDF.php" method="post">';
                                echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                echo '<input type="hidden" name="form_type" value="parentAcknowledgement" />';
                                echo '<input type="submit" class="btn btn-secondary" value="Unsubmit" name="submit" />';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';

                                // Parent Acknowledgement form
                                echo '<tr>';
                                echo '<td>Parent Acknowledgement</td>';
                                echo '<td>' . $row['parentAcknowledgementStatus'] . '</td>';
                                echo '<td>' . $dueDate . '</td>';
                                echo '<td>';

                                if ($row['parentAcknowledgement'] !== '' && ($row['parentAcknowledgementStatus'] === 'Pending' || $row['parentAcknowledgementStatus'] === 'Submitted')) {
                                    // Display link to view the submitted file
                                    echo '<label><b><a href="' . $row['parentAcknowledgement'] . '" class="text-black" target="_blank">View File</a></b></label>';
                                    echo '<br>';
                                    // Display the "Unsubmit" button
                                    echo '<form action="removePDF.php" method="post">';
                                    echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                    echo '<input type="hidden" name="form_type" value="parentAcknowledgement" />';
                                    echo '<input type="submit" class="btn btn-secondary" value="Unsubmit" name="submit" />';
                                    echo '</form>';
                                } else {
                                    // Check if the due date has passed and the status is "Missing"
                                    if ($dueDateTimestamp < $currentDateTimestamp && $row['parentAcknowledgementStatus'] === 'Missing') {
                                        // Due date has passed and the form is not submitted, disable the "Submit" button
                                        echo '<button type="button" class="btn btn-secondary" disabled>Submit Disabled</button>';
                                    } else {
                                        // Display file upload form
                                        echo '<form action="submitPDF.php" method="post" enctype="multipart/form-data">';
                                        echo '<input type="file" name="pdf_file" accept=".pdf" />';
                                        echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                        echo '<input type="hidden" name="form_type" value="parentAcknowledgement" />';
                                        echo '<input type="submit" class="btn btn-secondary" value="Upload" name="submit" />';
                                        echo '</form>';
                                    }
                                }
                                

                                echo '</td>';
                                echo '</tr>';

                                // Company Acceptance form
                                echo '<tr>';
                                echo '<td>Company Acceptance</td>';
                                echo '<td>' . $row['companyAcceptanceStatus'] . '</td>';
                                echo '<td>' . $dueDate . '</td>';
                                echo '<td>';

                                if ($row['companyAcceptance'] !== '' && ($row['companyAcceptanceStatus'] === 'Pending')) {
                                    // Display link to view the submitted file
                                    echo '<label><b><a href="' . $row['companyAcceptance'] . '" class="text-black" target="_blank">View File</a></b></label>';
                                    echo '<br>';
                                    // Display the "Unsubmit" button
                                    echo '<form action="removePDF.php" method="post">';
                                    echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                    echo '<input type="hidden" name="form_type" value="companyAcceptance" />';
                                    echo '<input type="submit" class="btn btn-secondary" value="Unsubmit" name="submit" />';
                                    echo '</form>';
                                } else {
                                    if ($dueDateTimestamp < $currentDateTimestamp && $row['companyAcceptanceStatus'] === 'Missing') {
                                        // Due date has passed and the form is not submitted, disable the "Submit" button
                                        echo '<button type="button" class="btn btn-secondary" disabled>Submit Disabled</button>';
                                    } else {
                                        // Display file upload form
                                        echo '<form action="submitPDF.php" method="post" enctype="multipart/form-data">';
                                        echo '<input type="file" name="pdf_file" accept=".pdf" />';
                                        echo '<input type="hidden" name="student_id" value="' . $studID . '" />';
                                        echo '<input type="hidden" name="form_type" value="companyAcceptance" />';
                                        echo '<input type="submit" class="btn btn-secondary" value="Upload" name="submit" />';
                                        echo '</form>';
                                    }
                                }
                                

                                echo '</td>';
                                echo '</tr>';

                                
                            }
                        } else {
                            echo '<tr>';
                            echo '<td colspan="4" class="text-center">No forms found for this student.</td>';
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
    
</body>
</html>
