<?php
session_start();
session_unset();
session_destroy();

// Redirect back to Buyer Login page
// Path adjustment: Up from Controllers -> app -> Views -> Buyer -> Login
header("Location: ../Views/Buyer/login.php");
exit();
?>