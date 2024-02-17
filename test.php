<?php
require "config.php";

echo "<pre>";
$id="27";
$response["answers"] = array();
$answers=$conn->query("SELECT answer, answer_id from answers where question_id='$id'")->fetch_all();
      for ($i=0; $i<count($answers); $i++) {
        #echo $answers[$i][1]." ".$answers[$i][0]."<br>";
        $response["answers"][$i]["answer"]=$answers[$i][0];
        $response["answers"][$i]["index"]=$answers[$i][1];
      }
print_r($response);
#print_r($res);
?>