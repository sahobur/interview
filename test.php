<?php
require_once 'functions/connect.php';
$user_id = 1;
// получим айдишники всех вопросов
$q = mysqli_query($connect,"SELECT qu_id,question,qtype from questions");
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
            
            echo "<p><input type=\"checkbox\" name=\"a\" value=\"{$a["answer_id"]}\">".$a["answer"]."</p>\n";
        }
        ?>
        <p><input type="submit" value="Выбрать"></p>
        <?php
        //break;
        

    }
    // один вариант ответа
    else { 
        $res = mysqli_query($connect,"SELECT * FROM answers WHERE qu_id={$quid}"); 
        echo "<p><b>".$ch["question"]."</b></p>\n";
        while ($a = mysqli_fetch_assoc($res)){
            
            echo "<p><input type=\"radio\" name=\"{$quid}\" value=\"{$a["answer_id"]}\" onclick=\"this.form.submit()\">".$a["answer"]."</p>\n";
        }
        //break;

    }

}

mysqli_close($connect);
// проверим, проходил ли опрос юзер в таблице с результатами опросов в табл. stats
//$d = mysqli_query($connect, "SELECT ")
