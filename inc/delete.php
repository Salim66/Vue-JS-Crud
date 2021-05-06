<?php

//Server connection
$conn = new mysqli('localhost', 'root', '', 'crud-v');

//get url data
$id = $_GET['id'];

//delete query
$conn->query("DELETE FROM users WHERE id='$id'");
