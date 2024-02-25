<?php

function customer_query($uid) {
    require "config.php";
    $response=$conn->query("SELECT * from customer where UID='$uid'");
    return $response;
}
function game_state($customer_id) {
    global $conn;
    $all_questions=explode(".", $conn->query("SELECT question from customer where UID='$customer_id'")->fetch_assoc()["question"]);
    $passed_questions=$conn->query("SELECT question_id from customer_success where UID='$customer_id'")->fetch_all();
    if (count($all_questions) == count($passed_questions)) {
        return false;
      }
      else {
        return true;
      }
}

function get_record_data($customer_id) {
  $all_questions=explode(".", $conn->query("SELECT question from customer where UID='$customer_id'")->fetch_assoc()["question"]);
  $passed_questions = $conn->query("SELECT question_id from customer_success where UID='$customer_id' and skip_q is null")->fetch_all();
  $skipped_questions=$conn->query("SELECT question_id from customer_success where UID='$customer_id' and skip_q is not null")->fetch_all();

}
?>