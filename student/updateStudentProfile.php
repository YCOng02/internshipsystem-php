<?php
$response = "Invalid request!";

if (isset($_POST['action']) && $_POST['action'] == "ProfileUpdate") {
    // Get the values sent from the client
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    require '../student/connect.php';

    // Check for connection errors
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    


    $sql = "UPDATE student SET studName = ?, studPhoneNo = ?,
    studQualification = ?
    WHERE staffID = ?";
    $stmt = $con->prepare($sql);

    $stmt->bind_param("ssss", $name, $phone, $qualification, $id);
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