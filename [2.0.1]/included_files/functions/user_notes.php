<?php
include_once 'database.php';
$ownerId = 1;

function get_all_user_notes_list()
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM user_notes";

    try {

        $query = $pdo->prepare($sql);
        $query->execute();
        $all_user_notes_info = $query->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $all_user_notes_info;
}

function get_single_user_notes_info($id)
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM user_notes where owner_id = {$id} ";

    try {

        $query = $pdo->prepare($sql);
        $query->execute();
        $user_notes_info = $query->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $user_notes_info;
}

function get_single_note_info($id)
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM user_notes where id = {$id} ";

    try {

        $query = $pdo->prepare($sql);
        $query->execute();
        $user_notes_info = $query->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $user_notes_info;
}




function update_user_notes_info($id,$name,$note_content)
{
    $pdo = Database::connect();
    $sql = "UPDATE user_notes SET name = '{$name}', note_content = '{$note_content}' where id = '{$id}'";
    $status = [];

    try {

        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if($result)
        {
            $status['message'] = "Data updated";
        }
        else{
            $status['message'] = "Data is not updated";
        }

    } catch (PDOException $e) {

        $status['message'] = $e->getMessage(); 
    }

    Database::disconnect();
    return $status;
}


function add_user_notes_info($name,$note_content)
{
    $pdo = Database::connect();
    $sql = "INSERT INTO user_notes(`name`,`note_content`) VALUES('{$name}', '{$note_content}')";
    $status = [];

    try {

        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if($result)
        {
            $status['message'] = "Data inserted";
        }
        else{
            $status['message'] = "Data is not inserted";
        }

    } catch (PDOException $e) {

        $status['message'] = $e->getMessage(); 
    }

    Database::disconnect();
    return $status;
}

function delete_user_notes_info($id)
{
    $pdo = Database::connect();
    $sql ="DELETE FROM user_notes where id = '{$id}'";
    $status = [];

    try {

        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if($result)
        {
            $status['message'] = "Data deleted";
        }
        else{
            $status['message'] = "Data is not deleted";
        }

    } catch (PDOException $e) {

        $status['message'] = $e->getMessage(); 
    }

    Database::disconnect();
    return $status;
}