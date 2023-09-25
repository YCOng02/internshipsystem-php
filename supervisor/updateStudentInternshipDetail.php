<?php

// Check if the request is coming via Ajax
if (isset($_POST['action']) && $_POST['action'] == "updateDatabase") {
    // Get the values sent from the client
    $columnName = $_POST['columnName'];
    $status = $_POST['status'];
    $id = $_POST['id'];

    require '../student/connect.php';
    
    // Check for connection errors
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $sql = "UPDATE INTERNSHIP SET $columnName = ? WHERE internshipID = ?";
    $stmt = $con->prepare($sql);

    $stmt->bind_param("ss", $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = "Database updated successfully!";
    } else {
        $response = "No records updated. Please check your input.";
    }

    $stmt->close();
    $con->close();

} else if (isset($_POST['action']) && $_POST['action'] == "terminate") {
    $id = $_POST['id'];
    $status = "Terminated";
    $con = new mysqli('localhost', 'root', '', 'internship');

    // Check for connection errors
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $sql = "UPDATE INTERNSHIP SET internshipStatus = ? WHERE internshipID = ?";
    $stmt = $con->prepare($sql);

    $stmt->bind_param("ss", $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = "Database updated successfully!";
    } else {
        $response = "No records updated. Please check your input.";
    }

    $stmt->close();
    $con->close();

} else if (isset($_POST['action']) && $_POST['action'] == "Graded") {
    $columnName = $_POST['columnName'];
    $reportMark = $_POST['reportMark'];
    $finalMark = $_POST['finalMark'];
    $id = $_POST['id'];

    $con = new mysqli('localhost', 'root', '', 'internship');

    // Check for connection errors
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }


    if ($finalMark == null) {
        $sql = "UPDATE INTERNSHIP SET $columnName = ? WHERE internshipID = ?";
        $stmt = $con->prepare($sql);

        $stmt->bind_param("is", $reportMark, $id);
    } else {
        $sql = "UPDATE INTERNSHIP SET $columnName = ?, finalGrade = ? WHERE internshipID = ?";
        $stmt = $con->prepare($sql);

        $stmt->bind_param("iis", $reportMark, $finalMark, $id);
    }

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = "Database updated successfully!";
    } else {
        $response = "No records updated. Please check your input.";
    }

    $stmt->close();
    $con->close();

} else {
    $response = "Invalid request!";
}

// Send a JSON response back to the client
echo json_encode($response);
?>