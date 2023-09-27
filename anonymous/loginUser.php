<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $email = $_POST["txtEmail"];
    $password = $_POST["txtPassword"];

    // Create a connection
    require '../student/connect.php';

    // Check if the connection was successful
    if ($con->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input (to prevent SQL injection, use prepared statements in production)
    $email = mysqli_real_escape_string($con, $email);

    // Hash the input password and truncate to varchar 100
    $hashedPassword = substr(hash('sha256', $password), 0, 50);

    // Query the database to retrieve the stored hashed password and student details for the given email
    $query = "SELECT studID, studName, studEmail, studPassword FROM student WHERE studEmail = '$email'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        // Fetch the stored hashed password and student details from the database
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row["studPassword"];
        $studID = $row["studID"];
        $studName = $row["studName"];
        $studEmail = $row["studEmail"];
        $studIC = $row["studIC"];
        $studGender = $row["studGender"];
        $studPhoneNo = $row["studPhoneNo"];
        $studQualification = $row["studQualification"];

        // Compare the hashed input password with the stored hashed password
        if ($hashedPassword === $storedHashedPassword) {
            // Password is correct, set session variables with student details

            $_SESSION["studID"] = $studID;
            $_SESSION["login_successful"] = "1";
            // Redirect to Profile.php
            header("Location: ../student/Profile.php");

        } else {
            // Authentication failed, display an error message or redirect to a login page with an error message

            $errorMessage = "Invalid username or password";
            header("Location: UserLogin.php?error=" . urlencode($errorMessage)); // Redirect with error message
            exit();
        }
    } else {
        // Email not found in the database, display an error message
        $errorMessage = "Invalid username or password";
        header("Location: UserLogin.php?error=" . urlencode($errorMessage)); // Redirect with error message
        exit();
    }

    // Close the database connection
    $con->close();
}
?>