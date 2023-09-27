<?php
// Check if the form is submitted
session_start();
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
    $query = "SELECT staffID, staffName, staffEmail, staffIC, staffGender, staffPhoneNo, staffPassword FROM staff WHERE staffEmail = '$email'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        // Fetch the stored hashed password and student details from the database
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row["staffPassword"];
        $staffID = $row["staffID"];

        // Compare the hashed input password with the stored hashed password
        if ($hashedPassword === $storedHashedPassword) {
            // Password is correct, set session variables with student details
            $_SESSION["staffID"] = $staffID;
            $_SESSION['login_successful'] = "1";

            if (isset($_SESSION['login_failed'])) {
                unset($_SESSION['login_failed']);
            }
            // Redirect to Profile.php
            header("Location: StaffProfile.php");

        } else {
            // Authentication failed, display an error message or redirect to a login page with an error message
            echo "Login failed. Invalid email or password.";
            $_SESSION["login_failed"] = "1";
            header("Location: StaffLogin.php");
        }
    } else {
        // Email not found in the database, display an error message
        echo "Login failed. Email not found.";
        $_SESSION["login_failed"] = "1";
        header("Location: StaffLogin.php");
    }

    // Close the database connection
    $con->close();
}
?>