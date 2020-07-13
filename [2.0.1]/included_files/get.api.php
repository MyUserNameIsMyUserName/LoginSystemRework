<?php

  if(isset($_GET['id']))
  {
    $id =  $_GET['id'];
    switch ($moduleName) {
        case "users":
            $json = get_single_user_info($id);
            break;
        case "user_notes":
            $json = get_single_user_notes_info($id);
            break;
        case "note":
            $json = get_single_note_info($id);
            break;
        default:
            $json['notification'] = 'Missing Module Name';
      };
      if(empty($json)) {
          header("HTTP/1.1 404 Not Found");
      };
  }
  else{
    $json = get_all_user_list();
  }
  echo json_encode($json);