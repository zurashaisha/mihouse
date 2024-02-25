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
    if (!$conn->query("SELECT question from customer where UID='$uid' and question is not null")->fetch_assoc()["question"]) {
        
        while (count($random_numbers) < 10) {
            $rand=rand(1, $conn->query("SELECT id from questions")->num_rows);
            if(!in_array($rand, $random_numbers)) {
                array_push($random_numbers, $rand);
             }
         }
        $numbers=implode(".", $random_numbers);
        $conn->query("UPDATE customer set question='$numbers' where UID='$uid'");
        #print_r($numbers);
        #echo "db updated";
        #echo $uid;
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
        $conn->query("UPDATE customer set current_question='$response[0]' where UID='$uid'");
        $response=json_encode($fresponse);
        echo $response;
    }
    else {
        if ($conn->query("SELECT current_question from customer where UID='$uid'")->fetch_assoc()["current_question"]) {
            $question=$conn->query("SELECT current_question from customer where UID='$uid'")->fetch_assoc()["current_question"];
        }
        else { $question=$response[0]; }
        $fresponse=array();
        $response=explode(".", $conn->query("SELECT question from customer where UID='$uid'")->fetch_assoc()["question"]);
        $question_data=$conn->query("SELECT * from questions where id=$question")->fetch_assoc()["question"];
        $fresponse["question"]=$question_data;
        $fresponse["question_id"]=$question;
        $fresponse["answers"] = array();
        $answers=$conn->query("SELECT answer, answer_id from answers where question_id='$question'")->fetch_all();
        for ($i=0; $i<count($answers); $i++) {
            $fresponse["answers"][$i]["answer"]=$answers[$i][0];
            $fresponse["answers"][$i]["index"]=$answers[$i][1];
        }
        #$conn->query("UPDATE customer set current_question='$response[0]' where UID='$uid'");
        $response=json_encode($fresponse);
        echo $response;
    }
}
if ($request == "set_answer") {
    $customer_id=$_POST["uid"];
    $answer_data=$_POST["answer_data"];
    $time_used=120-$_POST["time"];
    $answer=explode("#", $answer_data);
    $passed=array();
    $fresponse=array();
    if ($conn->query("SELECT correct from answers where question_id='$answer[0]' and answer_id='$answer[1]'")->fetch_assoc()["correct"]>0){
        #echo json_encode("Correct");
        $conn->query("INSERT into customer_success (UID, question_id, correct_check, time_used) values('$customer_id', '$answer[0]', 'yes', $time_used)");
        #$conn->query("UPDATE customer_success SET question_id='$answer[0]', correct_check='yes' where UID='$customer_id'");
    }
    else {
        $conn->query("INSERT into customer_success (UID, question_id, correct_check) values('$customer_id', '$answer[0]', 'no')");
        #echo json_encode($customer_id);
    }
    $all_questions=explode(".", $conn->query("SELECT question from customer where UID='$customer_id'")->fetch_assoc()["question"]);
    $passed_questions=$conn->query("SELECT question_id from customer_success where UID='$customer_id' and skip_q is null")->fetch_all();
    $final_score=$conn->query("SELECT question_id from customer_success where UID='$customer_id' and correct_check is not null")->fetch_all();
    if (count($all_questions) == count($final_score)) {
        $score=$conn->query("SELECT UID from customer_success where UID='$customer_id' and correct_check='yes'")->num_rows;
        $fresponse["state"] = "over";
        $fresponse["message"] = "თქვენი შედეგია 10-დან ".$score." სწორი პასუხი";
        echo json_encode($fresponse);
    }
    else {
    for ($p=0; $p<count($passed_questions); $p++) {
        array_push($passed, $passed_questions[$p][0]);
      }
      for ($i=0; $i<count($all_questions); $i++) {
        if (!in_array($all_questions[$i], $passed)) {
          $new_question=$all_questions[$i];
          break;
        }
      }
      $conn->query("UPDATE customer set current_question='$new_question' where UID='$customer_id'");
      #------------------ return next question--------------
      if ($conn->query("SELECT remaining_time from customer_success where question_id='$new_question'")->fetch_assoc()["remaining_time"]) {
        $remaining_time=$conn->query("SELECT remaining_time from customer_success where question_id='$new_question'")->fetch_assoc()["remaining_time"];
        $fresponse["time"]=$remaining_time;
      }
      $question_data=$conn->query("SELECT * from questions where id=$new_question")->fetch_assoc()["question"];
      $fresponse["question"]=$question_data;
        $fresponse["question_id"]=$new_question;
        $fresponse["answers"] = array();
      $answers=$conn->query("SELECT answer, answer_id from answers where question_id='$new_question'")->fetch_all();
        for ($i=0; $i<count($answers); $i++) {
            $fresponse["answers"][$i]["answer"]=$answers[$i][0];
            $fresponse["answers"][$i]["index"]=$answers[$i][1];
        }
        $response=json_encode($fresponse);
        echo $response;
    }
}
if ($request == "skip_answer") {
    $uid=$_POST["user_id"];
    $time=$_POST["time"];
    $passed=array();
    $fresponse=array();
    $user_questions=explode(".", $conn->query("SELECT question from customer where UID='$uid'")->fetch_assoc()["question"]);
    $current_question=$conn->query("SELECT current_question from customer where UID='$uid'")->fetch_assoc()["current_question"];
    $passed_questions=$conn->query("SELECT question_id from customer_success where UID='$uid'")->fetch_all();
    for ($i=0; $i<count($passed_questions); $i++){
        array_push($passed, $passed_questions[$i][0]);
    }
    array_push($passed, $current_question);
    for ($i=0; $i<count($user_questions); $i++) {
        if(!in_array($user_questions[$i], $passed)) {
            $next_question=$user_questions[$i];
            break;
        }
    }
    #---------------- insert skipped question at the bottom------------
    for ($i=0; $i<=count($user_questions); $i++) {
        if ($user_questions[$i] == $current_question) {
            unset($user_questions[$i]);
        }
    }
    array_push($user_questions, $current_question);
    array_values($user_questions);
    $user_questions=implode(".", $user_questions);
    $conn->query("UPDATE customer set question='$user_questions' where UID='$uid'");
    #-------------------------------------------------
    $conn->query("INSERT into customer_success (UID, question_id, skip_q, remaining_time) values('$uid', '$current_question', 'yes', '$time')");
    #$conn->query("UPDATE customer_success set question_id='$current_question', skip='yes', time_remaining='$time_remaining' where UID='$uid'");
    $conn->query("UPDATE customer set current_question='$next_question' where UID='$uid'");

    $question_data=$conn->query("SELECT * from questions where id=$next_question")->fetch_assoc()["question"];
      $fresponse["question"]=$question_data;
        $fresponse["question_id"]=$next_question;
        $fresponse["answers"] = array();
      $answers=$conn->query("SELECT answer, answer_id from answers where question_id='$next_question'")->fetch_all();
        for ($i=0; $i<count($answers); $i++) {
            $fresponse["answers"][$i]["answer"]=$answers[$i][0];
            $fresponse["answers"][$i]["index"]=$answers[$i][1];
        }
        $response=json_encode($fresponse);
        echo $response;

}
?>