<?php
session_start();
session_unset();
session_destroy();

// Redirect to index.html
header("Location: index.html");
exit();
?>
