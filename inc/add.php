<?php

//server connection
$conn = new mysqli('localhost', 'root', '', 'crud-v');

//get all data
$data = json_decode(file_get_contents('php://input'));

$name = $data->name;
$email = $data->email;
$cell = $data->cell;

//data add query
$conn->query("INSERT INTO  users (name, email, cell) VALUES ('$name', '$email', '$cell')");
