<?php

//Server connection
$conn = new mysqli('localhost', 'root', '', 'crud-v');

//get user data fetch
$data = json_decode(file_get_contents('php://input'));


//get url action data
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

/**
 * Get all user data
 */
if ($action == 'read') {
    $data = $conn->query("SELECT * FROM users ORDER By id DESC");

    $all_data = [];
    while ($user = $data->fetch_assoc()) {
        array_push($all_data, $user);
    }

    echo json_encode($all_data);
}

/**
 * User data add
 */
if ($action == 'create') {
    //get all user data
    // $name = $data->name;
    // $email = $data->email;
    // $cell = $data->cell;

    //get file name and file tmp name
    $photo_name = $_FILES['photo']['name'];
    $photo_tmp_name = $_FILES['photo']['tmp_name'];

    //upload user photo
    move_uploaded_file($photo_tmp_name, '../photos/users/' . $photo_name);

    //get all user data by $_POST[] 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $cell = $_POST['cell'];

    //insert data query
    $conn->query("INSERT INTO users (name, email, cell, photo) VALUES ('$name', '$email', '$cell', '$photo_name')");
}

/**
 * User data delete
 */
if ($action == 'delete') {
    //Get url user id
    $id = $_GET['id'];

    //delete query
    $conn->query("DELETE FROM users WHERE id='$id'");
}

/**
 * Single user view 
 */
if ($action == 'single') {
    //Get user id
    $id = $_GET['id'];

    //get user data query
    $data = $conn->query("SELECT * FROM users WHERE id='$id'");
    $single_data =  $data->fetch_assoc();
    echo json_encode($single_data);
}

/**
 * Search user data
 */
if ($action == 'search') {
    //Get user search value
    $search = $_GET['search'];

    //get user search query
    $data = $conn->query("SELECT * FROM users WHERE name LIKE '%$search%' ");

    $user_result = [];
    while ($result = $data->fetch_assoc()) {
        array_push($user_result, $result);
    }

    echo json_encode($user_result);
}

/**
 * Edit user data
 */
if ($action == 'edit') {
    //Get user id
    $id = $_GET['id'];

    //GEt user data query
    $data = $conn->query("SELECT * FROM users WHERE id='$id'");

    //associative data convert to json format
    echo json_encode($data->fetch_assoc());
}

/**
 * Update user data
 */
if ($action == 'update') {

    //Get user Value
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email =  $_POST['email'];
    $cell = $_POST['cell'];

    $photo_name = '';
    if (isset($_FILES['photo'])) {
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp_name = $_FILES['photo']['tmp_name'];

        //upload photo
        move_uploaded_file($photo_tmp_name, '../photos/users/' . $photo_name);
    } else {

        $photo_name = $_POST['photo'];
    }

    //update user data query
    $conn->query("UPDATE users SET name='$name', email='$email', cell='$cell', photo='$photo_name' WHERE id='$id'");
}
