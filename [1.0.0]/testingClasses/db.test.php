<?php

include '../classes/database.class.php';

$newDBtest = new dbClass();

echo 'DATABASE TEST <br>';
echo '*connection Test: <span style="color: red">';
echo $newDBtest->connect();
echo '</span><br>';
echo '*DISconnection Test: <span style="color: red">';
echo $newDBtest->disconnect();
echo '</span><br>';
echo '<br><br><br>';

?>