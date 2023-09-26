<?php

// Check if the session is not empty
session_start();

if (!empty($_SESSION)) {
    echo "Session Variables:<br>";

    // Loop through all session variables and display their names and values
    foreach ($_SESSION as $key => $value) {
        echo "$key: $value<br>";
    }
} else {
    echo "Session is empty.";
}
?>
