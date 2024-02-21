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
    width: 800px;
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
    <h1><input type=button class="button" onclick="start_game()" value="Start Game"></input></h1>
    <div id="game_quiz"></div>
</div>
<div class="widget-wrap" id="game">
<p id="countdownInput" onclick="showRemainingTime()"></p>
<div id="question" value=""></div>
<div id="answers">
<table border=0>
    <tbody width=100%>
        
        <tr>
            <td><input type="radio"  id="answer_0" name="check_answer"></td><td align=left><label for="answer_0" id="panswer_0" name=""></label></td></tr>
        <tr>
            <td><input type="radio"  id="answer_1" name="check_answer"></td><td align=left><label for="answer_1" id="panswer_1" name=""></label></td></tr>
        <tr>
            <td><input type="radio"  id="answer_2" name="check_answer"></td><td align=left><label for="answer_2" id="panswer_2" name=""></label></td></tr>
        <tr>
            <td><input type="radio"  id="answer_3" name="check_answer"></td><td align=left><label for="answer_3" id="panswer_3" name=""></label></td>
        </tr>
    </tbody>
</table>
<table border=0>
    <tbody width=100%>
        <tr><td align=right><button class=button onclick="set_answer()">შემდეგი კითხვა</button></td><td alight=right><button class=button onclick="skip_answer()">გამოტოვება</button></td></tr>
</tbody>
</table>
</div>

</div>
<div class="widget-wrap" id="end_game">
    Game Over
</div>


</section>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
    var game_start = document.getElementById("start_game");
    var game_begin = document.getElementById("game");
    var game_end = document.getElementById("end_game");
    game_start.style.display = 'block';
    game_begin.style.display = 'none';
    game_end.style.display = 'none';
    var countdown = 120;
    var countdownDuration = countdown;
    var timer;

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
                    $('#panswer_'+i).html(answers[i]["answer"]);
                    $('#answer_'+i).val(question_index+"#"+answers[i]["index"]);

                }
                
            }
        });
        game_start.style.display = 'none';
        game_begin.style.display = 'block';
        clearInterval(timer);
        countdownDuration = countdown;
        startCountdown();
   
        
    }
    function set_answer() {
        
        var checked_answer = document.querySelector('input[name="check_answer"]:checked').value;
        if (!checked_answer) {
            alert("check one answer");
        }
        console.log(checked_answer)
        var uid=<?php echo $_SESSION["UID"]; ?>;
        $.ajax({
            url: 'process.php',
            type: 'post',
            data: {request: 'set_answer', answer_data:checked_answer, uid:uid, time:countdownDuration},
            dataType: 'json',
            success: function(data) {
                if (data == "over") {
                    game_begin.style.display = 'none';
                    game_end.style.display = 'block';
                }
                else {
                var question=data["question"];
                var answers=data["answers"];
                var question_index=data["question_id"];
                $('#question').html(question);
                for (var i=0; i<answers.length; i++) {
                    $('#panswer_'+i).html(answers[i]["answer"]);
                    $('#answer_'+i).val(question_index+"#"+answers[i]["index"]);
                }
                $('input[name=check_answer]').prop('checked',false);
                
            }
            }
        });
        clearInterval(timer);
        countdownDuration = countdown;
        startCountdown();
    }
   function skip_answer() {
    var uid=<?php echo $_SESSION["UID"]; ?>;
    $.ajax({
        url: 'process.php',
        type: 'post',
        data: {request: 'skip_answer', user_id:uid, time:countdownDuration},
        dataType: 'json',
        success: function(skipdata) {
            var question=skipdata["question"];
            var skipanswers=skipdata["answers"];
            var question_index=skipdata["question_id"];
            $('#question').html(question);
            for (var i=0; i<skipanswers.length; i++) {
                $('#panswer_'+i).html(skipanswers[i]["answer"]);
                $('#answer_'+i).val(question_index+"#"+skipanswers[i]["index"]);
            }
            $('input[name=check_answer]').prop('checked',false);
        }
    });
    clearInterval(timer);
        countdownDuration = countdown;
        startCountdown();
   }
 
    
    // Function to start the countdown
    function startCountdown() {
        var display = document.getElementById('countdownInput');
        timer = setInterval(function() {
            var minutes = Math.floor(countdownDuration / 60);
            var seconds = countdownDuration % 60;
            display.textContent = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
            countdownDuration--;
            // Check if the countdown has finished
            if (countdownDuration < 0) {
                clearInterval(timer);
                alert("time is up");
            }
        }, 1000);
    }

    window.onload = function() {
        startCountdown();
    };
    </script>
</html>