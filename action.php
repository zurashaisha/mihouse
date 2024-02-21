<?php
require "config.php";
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
/*if ($_REQUEST["loginmail"] && $_REQUEST["loginpassword"]) {
    echo $_REQUEST["loginmail"]." ".$_REQUEST["loginpassword"];
} */


$username=$_POST["customer_id"];
$selectuser = $conn->query("SELECT * from customer where UID='$username'");
if ($selectuser) {
    if ($selectuser->num_rows>0) {
        #echo "user exist";
        $_SESSION["loggedin"] = true;
        $_SESSION["UID"] = $selectuser->fetch_assoc()["UID"];
        
        header("location: index.php"); 
    }
    else {
        echo "user exist but password is not correct";
    }
}
else { echo "wrong user"; }
    


?>