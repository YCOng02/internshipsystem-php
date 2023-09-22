<?php

// Check if the request is coming via Ajax
if (isset($_POST['action']) && $_POST['action'] == "updateDatabase") {
    // Get the values sent from the client
    $columnName = $_POST['columnName'];
    $status = $_POST['status'];
    $id = $_POST['id'];

    $con = new mysqli('localhost', 'root', '', 'internship');

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
} else {
    $response = "Invalid request!";
}

// Send a JSON response back to the client
echo json_encode($response);
?>