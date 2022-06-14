<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
$user_id = $_SESSION["user"]["id"];
require_once 'connect.php';


// спарсись номер вопроса
//echo "Question N ".$_POST["q"][1][5];

?><pre>
    <?php
print_r($_POST);
foreach ($_POST["q"] as $k => $v){

    foreach($v as $i => $a) {
        echo "Q:".$k.":".$a.",";

    }
}


?>

