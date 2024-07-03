<?php
$mobile = $_POST["mobile"];

if (empty($mobile)) {
    echo ("Please enter your mobile number.");
} elseif (strlen($mobile) != 10 || !preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid mobile number.");
}
?>