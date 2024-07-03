<?php

session_start();

if (isset($_SESSION["customer"])) {

    setcookie("email", "", -1);
    setcookie("password", "", -1);
    session_destroy();

    echo ("success");
}
?>