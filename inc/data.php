<?php

//Server connection
$conn = new mysqli('localhost', 'root', '', 'crud-v');
$data = $conn->query("SELECT * FROM users ORDER BY id DESC");

$all_data = [];

while ($user = $data->fetch_assoc()) {
    array_push($all_data, $user);
}

echo json_encode($all_data);
