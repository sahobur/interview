<?php

    $connect = mysqli_connect('localhost', 'musr1234', 'pF6h31XtgMmcLXt9', 'interview');

    if (!$connect) {
        die('Error connect to DataBase');
    }