<?php
///including of the functions for api to use
include('included_files/functions/users.php');
include('included_files/functions/user_notes.php');
include('included_files/functions/helpers.php');

//set header to json type
header('content-type: application/json');

//finding module name from url
$moduleName = getCurrentModuleName();

//GET
if($_SERVER['REQUEST_METHOD']=="GET"){
  include('included_files/get.api.php');
}

//POST
if($_SERVER['REQUEST_METHOD']=="POST"){
  include('included_files/post.api.php');
}

//PUT/UPDATE
if($_SERVER['REQUEST_METHOD']=="PUT"){
  include('included_files/put.api.php');
}

//DELETE
if($_SERVER['REQUEST_METHOD']=="DELETE"){
  include('included_files/delete.api.php');
}

?>