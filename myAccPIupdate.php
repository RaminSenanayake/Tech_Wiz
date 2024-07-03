<?php
session_start();
require "connection.php";

Database::iud("UPDATE `customer` SET `fname`='".$_POST["myAccFname"]."', `lname`='".$_POST["myAccLname"]."', `gender_gender_id`='".$_POST["myAccGender"]."', `dob`='".$_POST["myAccDOB"]."' 
WHERE `email`='".$_SESSION["customer"]["email"]."'");
echo("Successfully updated.");

?>