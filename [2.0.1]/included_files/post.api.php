<?php

  $data = json_decode( file_get_contents( 'php://input' ), true );
  
  $name = $data['name'];
  $email = $data['email'];
  
  $json = add_user_info($name,$email);
  echo json_encode($json);