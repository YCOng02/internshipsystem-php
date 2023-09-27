<?php
session_start();
session_destroy();
header("Location: anonymous/UserLogin.php");
exit();

?>