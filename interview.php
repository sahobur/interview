<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Опросник</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
        <h3 class="userid">Пользователь:&nbsp<?= $_SESSION['user']['name'] ?>&nbsp&nbsp&nbsp&nbsp</h3>
        <a class="exitid" href="functions/logout.php" class="logout">Выход</a>
<?php
$user_id = $_SESSION["user"]["id"];
$current_q_id=1;
require_once 'functions/connect.php';


if(!empty($_POST)){
    foreach ($_POST["q"] as $k => $v){
        $current_q_id = $k;
        $q_id = $k;
        // ищем id последнего вопроса если текущий id равен посл то завершаем
        $r1 = mysqli_query($connect,"SELECT MAX(qu_id) FROM questions" );
        $c = mysqli_fetch_assoc($r1);
        $maxid = $c["MAX(qu_id)"];

        foreach($v as $i => $aid) {
            // update answer stats
            $r = mysqli_query($connect,"INSERT INTO stats (`user_id`, `qu_id`, `answer_id`) VALUES ({$user_id},{$q_id},{$aid})");
               
        }
       

    }
    //echo $maxid."===".$current_q_id;die();
    if($current_q_id == $maxid) {
        echo "<h1>Конец:)</h1>";
        die();
    }
    header('Location: interview.php');
} else {


?>
<form method = "POST">
<?php

// получим айдишники всех вопросов
$q = mysqli_query($connect,"SELECT qu_id,question,qtype from questions");
$n = mysqli_num_rows($q);
while ($ch = mysqli_fetch_assoc($q)) {
    $quid = $ch["qu_id"];
    $ans = mysqli_query($connect,"SELECT id FROM stats WHERE user_id = {$user_id} AND qu_id = {$quid}");
    //echo "S:".mysqli_num_rows($ans);

    if (mysqli_num_rows($ans)>0) continue; // уже отвечали на этот вопрос, пропсукаем
    // множественный выбор ответов
    if ($ch["qtype"]==2) { 

        $res = mysqli_query($connect,"SELECT * FROM answers WHERE qu_id={$quid}"); 
        echo "<p><b>".$ch["question"]."</b></p>\n";
        while ($a = mysqli_fetch_assoc($res)){
            
            echo "<p><input type=\"checkbox\" name=\"q[{$quid}][{$a["answer_id"]}]\" value=\"{$a["answer_id"]}\">".$a["answer"]."</p>\n";
        }
        ?>
        <p><input type="submit" value="Выбрать"></p>
        <?php
        break;
        

    }
    // один вариант ответа
    else { 
       // echo "quid:".$quid;
        $res = mysqli_query($connect,"SELECT * FROM answers WHERE qu_id={$quid}"); 
        echo "<p><b>".$ch["question"]."</b></p>\n";
        echo "Выберите 1 вариант";//echo mysqli_num_rows($res)."eee";
        while ($a = mysqli_fetch_assoc($res)){
               echo "<p><input type=\"radio\" name=\"q[{$quid}][{$a["answer_id"]}]\" value=\"{$a["answer_id"]}\" onclick=\"this.form.submit()\">".$a["answer"]."</p>\n";
        }
        break;

    }

}

}
mysqli_close($connect);

echo "</form>";

?>

</body>
</html>