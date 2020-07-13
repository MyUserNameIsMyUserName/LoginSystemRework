<?php

    $data = json_decode( file_get_contents( 'php://input' ), true );
  
    $id = $data['id'];
    $name = $data['name'];
    $email = $data['email'];
    
    $json = update_user_info($id,$name,$email);
    echo json_encode($json);