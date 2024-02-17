<?php
require "config.php";
/*
$function=$_GET["route"];
    echo $function();
*/
if(isset($_POST['request'])){
    $request = $_POST['request'];
}
if ($request == "get_questions") {
    $uid=$_POST["uid"];
    
    $random_numbers = array();
    for ($i = 0; $i < 10; $i++) {
        if(!in_array($random_numbers, $random_numbers)) {
        $random_numbers[] = rand(1, $conn->query("SELECT id from questions")->num_rows);
        }
    }
    $numbers=implode(".", $random_numbers);
    if (!$conn->query("SELECT question from customer where UID='$uid'")->fetch_assoc()["question"]) {
        $conn->query("UPDATE customer set question='$numbers' where UID='$uid'");
        print_r($numbers);
        echo "db updated";
        echo $uid;
    }
    else {
        $fresponse=array();
        $response=explode(".", $conn->query("SELECT question from customer where UID='$uid'")->fetch_assoc()["question"]);
        $question_data=$conn->query("SELECT * from questions where id=$response[0]")->fetch_assoc()["question"];
        $fresponse["question"]=$question_data;
        $fresponse["question_id"]=$response[0];
        $fresponse["answers"] = array();
        $answers=$conn->query("SELECT answer, answer_id from answers where question_id='$response[0]'")->fetch_all();
        for ($i=0; $i<count($answers); $i++) {
            $fresponse["answers"][$i]["answer"]=$answers[$i][0];
            $fresponse["answers"][$i]["index"]=$answers[$i][1];
        }
        $response=json_encode($fresponse);
        echo $response;
    }
}

?>