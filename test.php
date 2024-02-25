<?php
require "config.php";
$numbers=array(24, 56, 71, 5, 1, 65, 80);
echo "<pre>";

$key=71;
for ($i=0; $i<=count($numbers); $i++) {
    if ($numbers[$i] == $key) {
        unset($numbers[$i]);

    }
}

$numbers=array_values($numbers);
array_push($numbers, $key);
print_r($numbers);
?>