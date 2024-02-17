<?php
require "config.php";
require "func.php";
require "header.php";
?>
<!DOCTYPE html>
<html>
<head>
<style>
    #quizWrap {
    max-width: 600px;
    margin: 0 auto;
}

#quizQn {
    padding: 20px;
    background: #4c93ba;
    color: #fff;
    font-size: 24px;
    border-radius: 10px;
}

#quizAns {
    margin: 10px 0;
    display: grid;
    grid-template-columns: auto auto;
    grid-gap: 10px;
}

#quizAns input[type=radio] {
    display: none;
}

#quizAns label {
    background: #fafafa;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 10px;
    font-size: 20px;
    cursor: pointer;
    text-align: center;
}

#quizAns label.correct {
    background: #d8ffc4;
    border: 1px solid #60a03f;
}

#quizAns label.wrong {
    background: #ffe8e8;
    border: 1px solid #c78181;
}

* {
    font-family: arial, sans-serif;
    box-sizing: border-box;
}

body {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    text-align: center;
    background: rgb(238, 174, 202);
    background: radial-gradient(circle, rgba(238, 174, 202, 1) 0%, rgba(148, 187, 233, 1) 100%);
}

.widget-wrap {
    width: 600px;
    padding: 30px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.4);
}
.button {
  background-color: #BA7DB5;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 20%;
}
    </style>
</head>
<body>


<?php

?>
<div class="widget-wrap" id="start_game">
    <h1><?php
    $name=$conn->query("SELECT name from customer where UID='$_SESSION[UID]'")->fetch_assoc()["name"];
    echo "Hello ".$name;
    ?>
    <h1><button class="button" onclick="start_game()">Start Game</button></h1>
    <div id="game_quiz"></div>
</div>
<div class="widget-wrap" id="game">
<div id="question"></div>
<table border=1>
    <tbody width=100%>
        
        <tr>
            <td question="" name=""><label id="answer_0"></td>
            <td question="" name=""><label id="answer_1"></td>
        </tr>
        <tr>
            <td question="" name=""><label id="answer_2"></td>
            <td question="" name=""><label id="answer_3"></td>
        </tr>
    </tbody>
</table>
<?php
$user_questions=$conn->query("SELECT question from customer where UID='$_SESSION[UID]'")->fetch_assoc()["question"];
$user_questions=explode(".", $user_questions);
for ($i=1; $i<=count($user_questions); $i++) {
    echo $i." ";
}
?>
</div>



</section>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
    var game_start = document.getElementById("start_game");
    var game_begin = document.getElementById("game");
    game_start.style.display = 'block';
    game_begin.style.display = 'none';
    function start_game(uid) {
        var uid=<?php echo $_SESSION["UID"]; ?>;
        game_quiz.style.display = 'block';
        $.ajax({
            url: 'process.php',
            type: 'post',
            data: {request:'get_questions',uid:uid},
            dataType: 'json',
            success: function(data) {
                var question=data["question"];
                var answers=data["answers"];
                var question_index=data["question_id"];
                $('#question').html(question);
                for (var i=0; i<answers.length; i++) {
                    $('#answer_'+i).html(answers[i]["answer"]);
                    $('#answer_'+i).attr("name", answers[i]["index"]);
                    $('#answer_'+i).attr("question", question_index);

                }
            }
        });
        game_start.style.display = 'none';
        game_begin.style.display = 'block';
    }
    </script>
</html>