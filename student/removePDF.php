<?php
if (isset($_POST['submit'])) {
    $studID = $_POST['student_id'];
    $formType = $_POST['form_type'];

    // Create a connection to your database
    require 'connect.php';

    // Check for connection errors
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Retrieve the current file path from the database
    $stmt = $con->prepare("SELECT {$formType} FROM internship WHERE studID = ?");
    $stmt->bind_param("i", $studID);
    $stmt->execute();
    $stmt->bind_result($filePath);
    $stmt->fetch();
    $stmt->close();

    // Check if a file path was found in the database
    if ($filePath) {
        // Remove the file from the server
        if (unlink($filePath)) {
            // Update the database to remove the file path and set the form status back to "Pending"
            $stmt = $con->prepare("UPDATE internship SET {$formType} = NULL, {$formType}Status = 'Missing' WHERE studID = ?");
            $stmt->bind_param("i", $studID);

            if ($stmt->execute()) {
                echo "File removed successfully.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                echo "Error updating database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error removing the file from the server.";
        }
    } else {
        echo "No file found for removal in the database.";
    }

    $con->close();
}
?>
