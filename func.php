<?php

function customer_query($uid) {
    require "config.php";
    $response=$conn->query("SELECT * from customer where UID='$uid'");
    return $response;
}

?>