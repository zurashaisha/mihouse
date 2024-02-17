<?php
require "config.php";
require "func.php";
?>
<!DOCTYPE html>
<html>
<head>
<link href="bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="ajax.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<form action="" method="post">
    <input type=text name="customer_id">
    <button type=submit>PROCEED</button>
</form>
<?php
if (isset($_POST)) {
    $customer_id=$_POST["customer_id"];
    
    if (customer_query($_POST["customer_id"])->num_rows>0) {
        echo "<button name=\"start_game\" onclick=\"start_game(".$customer_id.")\">Start Game</button>";
    }
}
?>
<div id="quiz">
<table border=1 cellpadding="0" cellspacing="0">
    <tbody>
        <th id="question"></th>
        <tr>
            <td><p id="question_1"></p></td>
            <td><p id="question_2"></p></td>
        </tr>
        <tr>
            <td><p id="question_3"></p></td>
            <td><p id="question_4"></p></td>
        </tr>
    </tbody>
</table>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript">
    var game_quiz = document.getElementById("quiz");
    game_quiz.style.display = 'none';
    function start_game(uid) {
        //var uid=<?php echo $customer_id; ?>;
        game_quiz.style.display = 'block';
    }
    </script>
</html>