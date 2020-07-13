<?php

  $data = json_decode( file_get_contents( 'php://input' ), true );
  
  $id = $data['id'];
  
  $json = delete_user_info($id);
  echo json_encode($json);