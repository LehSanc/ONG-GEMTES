<?php

if (!isset($_SESSION)) session_start();

if (isset($_SESSION)) {
    session_destroy();
    session_unset();
}

header("Location: ./index.php");

exit();
