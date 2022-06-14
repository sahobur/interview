<?php
session_start();

if ($_SESSION['user']) {
    header('Location: interview.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Опросы </title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <form class="loginform">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <button type="submit" class="login-btn">Войти</button>
        <p class="msg none">Lorem ipsum dolor sit amet.</p>
    </form>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/main.js"></script>

</body>
</html>