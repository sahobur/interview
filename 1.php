<?php
require_once 'functions/connect.php';
 $r1 = mysqli_query($connect,"SELECT MAX(qu_id) FROM questions" );
  $c = mysqli_fetch_assoc($r1);
   //$maxid = $c;
 print_r($c["MAX(qu_id)"]);

