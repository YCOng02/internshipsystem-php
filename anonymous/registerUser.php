<?php
// Check if the form is submitted
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve user input
    $name = $_POST["txtName"];
    $studentID = $_POST["txtStudID"];
    $nric = $_POST["txtIC"];
    $email = $_POST["txtEmail"];
    $cfmPassword = $_POST["txtCfmPassword"];
    $phone = $_POST["txtPhone"];
    $gender = $_POST["gender"];
    $qualification = $_POST["qualification"];
    $internshipSession = $_POST["internship_session"];

    // Create a connection
    require '../student/connect.php';

    // Check if the connection was successful
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Hash the input password and truncate to varchar 100 (You should use $cfmPassword here instead of $password)
    $hashedPassword = substr(hash('sha256', $cfmPassword), 0, 50);

    // Sanitize user input (to prevent SQL injection, use prepared statements in production) ****************************
    $email = mysqli_real_escape_string($con, $email);

    // Prepare and execute an INSERT statement for the STUDENT table
    $studentInsertQuery = "INSERT INTO student (studName, studID, studIC, studEmail, studGender, studPhoneNo, studPassword, studQualification) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $studentStmt = $con->prepare($studentInsertQuery);
    $studentStmt->bind_param("ssssssss", $name, $studentID, $nric, $email, $gender, $phone, $hashedPassword, $qualification);

    if ($studentStmt->execute()) {

        // Query to retrieve the maximum ID from your table
        $sql = "SELECT COUNT(*) as count FROM internship";

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Fetch the maximum ID value
            $row = $result->fetch_assoc();
            $maxID = (int) $row["count"];

            // Increment the ID to generate the next ID
            $nextID = $maxID + 1;
        } else {
            // If there are no records in the table, start with ID 1
            $nextID = 1;
            echo "The table is empty. Starting with ID 1.";
        }

        $last3Digits = str_pad((string) $nextID, 3, '0', STR_PAD_LEFT);
        $internshipStatus = "In Progress";
        $formStatus = "Missing";
        $last4Digits = substr($internshipSession, -4);
        $internshipID = 'I' . $last4Digits . $last3Digits;

        $internshipInsertQuery = "INSERT INTO INTERNSHIP (internshipID, studID, sessionID, internshipStatus, indemnityStatus, parentAcknowledgementStatus, 
        companyAcceptanceStatus) VALUES (?,?,?,?,?,?,?)";
        $internshipStmt = $con->prepare($internshipInsertQuery);
        $internshipStmt->bind_param("sssssss", $internshipID, $studentID, $internshipSession, $internshipStatus, $formStatus, $formStatus, $formStatus);

        if ($internshipStmt->execute()) {
            echo '<script>
            alert("Registration successful!");
            window.location.href = "UserLogin.php"; // Redirect immediately
            </script>';

        } else {
            echo '<script>
            alert("Failed to insert internship record! Try again.");
            window.location.href = "Register.php"; // Redirect immediately
            </script>';
        }
    } else {
        echo '<script>
            alert("Failed to insert internship record! Try again.");
            window.location.href = "Register.php"; // Redirect immediately
            </script>';
    }
}
?>