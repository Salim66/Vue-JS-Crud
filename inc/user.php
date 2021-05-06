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
    $name = $data->name;
    $email = $data->email;
    $cell = $data->cell;

    $conn->query("INSERT INTO users (name, email, cell) VALUES ('$name', '$email', '$cell')");
}
