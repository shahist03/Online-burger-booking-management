<?php
// Start the session to access session data
session_start();

// Destroy the session data
session_destroy();

// Redirect to the login page or any other page
header("Location: index.html");
exit;
?>