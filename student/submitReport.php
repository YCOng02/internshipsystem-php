<?php
ob_start(); // Enable output buffering

if (isset($_POST['submit'])) {
    $studID = $_POST['student_id'];
    $formType = $_POST['form_type'];

    // Specify the target directory for file uploads
    $targetDirectory = '../Report/';

    // Create the target directory if it doesn't exist
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    // Get the uploaded file
    $pdfFile = $_FILES['pdf_file'];

    // Check if a file was uploaded
    if ($pdfFile['error'] === UPLOAD_ERR_OK) {
        // Define the target file path within the "Report" folder using the original file name
        $targetFile = $targetDirectory . $pdfFile['name'];

        // Move the uploaded file to the target directory
        if (move_uploaded_file($pdfFile['tmp_name'], $targetFile)) {
            // Successfully uploaded the file
            // Now, insert the file path into the database

            // Create a connection to your database
            $con = new mysqli('localhost', 'root', '', 'internship');

            // Check for connection errors
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            // Prepare an SQL statement to insert the file path
            $stmt = $con->prepare("UPDATE internship SET {$formType} = ? WHERE studID = ?");
            $stmt->bind_param("si", $targetFile, $studID);

            if ($stmt->execute()) {
                // Initialize grade columns to 0 (add this part)
                $initializeGradesStmt = $con->prepare("UPDATE internship SET {$formType}Grade = 0 WHERE studID = ?");
                $initializeGradesStmt->bind_param("i", $studID);
                $initializeGradesStmt->execute();
                $initializeGradesStmt->close();

                // Redirect back to the current page after successful upload
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                echo "Error inserting file path into the database: " . $stmt->error;
            }

            $stmt->close();
            $con->close();
        } else {
            echo "Error uploading the file.";
        }
    }
}

ob_end_flush(); // End output buffering and send content to the browser
?>
