<?php
include 'inc/createUniqUsername.php';
include '../classes/user.class.php';

echo "USER CLASS TEST <br>";

$newTestUser = new UserClass();

echo '*set username <span style="color: red;">  '.$newTestUser->setUsername('slavkovula').'</span><br>';
echo '*get username <span style="color: red;">  '.$newTestUser->getUsername().'</span><br>';
echo '*get getFirstAndLastName <span style="color: red;">  '.$newTestUser->getFirstAndLastName().'</span><br>';
echo '*get email <span style="color: red;">  '.$newTestUser->getEmail().'</span><br>';

echo '<br>*register<br>';
echo '***********************************<br>';
echo '1[crashTest]=> <span style="color: red;">  '.$newTestUser->register('a','F','L','email@mail','email@mail.','pa', 'password').'</span><br>';
echo '2[crashTest]=><span style="color: red;">  '.$newTestUser->register('aaaaa','Fa','La','email@mail.','email@mail.','pa', 'pa').'</span><br>';
echo '3[crashTest]=><span style="color: red;">  '.$newTestUser->register('Vaaas','Fav','Lava','email@mail.com','email@mail.com','password', 'password').'</span><br>';
echo '4[goodOne]=><span style="color: red;">  '.$newTestUser->register($uniqName,'Fav','Lava', $uniqMail, $uniqMail,'password', 'password').'</span><br>';
echo '***********************************<br>';

echo '<br>*login<br>';
echo '***********************************<br>';
echo '1[crashTest]=> <span style="color: red;">  '.$newTestUser->login('slavkovula', '').'</span><br>';
echo '2[crashTest]=> <span style="color: red;">  '.$newTestUser->login('', 'passwordaa').'</span><br>';
echo '3[crashTest]=> <span style="color: red;">  '.$newTestUser->login('slavkovul', 'passwordaa').'</span><br>';
echo '4[goodOne] => <span style="color: red;">  '.$newTestUser->login($uniqName, 'password').'</span><br>';
echo '***********************************<br>';

/* SELF REPAIR TESTING PART, first need to make these functions public inside user class...and then the testing can be done *

echo '<br>*tableExists<br>';
echo '1[crashTest]=> <span style="color: red;">  '.$newTestUser->tableExists().'</span><br>';
echo '<br>*dropTable<br>';
echo '1[crashTest]=> <span style="color: red;">  '.$newTestUser->dropTable().'</span><br>';
echo '<br>*repairTable<br>';
echo '1[crashTest]=> <span style="color: red;">  '.$newTestUser->repairTable().'</span><br>';

/* END OF SELF REPAIR TESTS */


?>