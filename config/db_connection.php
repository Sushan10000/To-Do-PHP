<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'sushan', 'test123', 'todo_list');

// Check connection
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}
?>