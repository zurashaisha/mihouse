<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
require "config.php";
require "func.php";
echo "<pre>";
$uid="2011";
$score=$conn->query("SELECT UID from customer_success where UID='$uid' and correct_check='yes'")->num_rows;
print_r($score);
?>

