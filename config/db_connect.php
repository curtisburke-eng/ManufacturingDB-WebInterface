<?php
    // connect to the database
    $conn = mysqli_connect('localhost','web','test','BBDrawTrailers');

    // Check Connection
    if(!$conn) {
        echo 'Database Connection Error: ' . mysqli_connect_error();
    }
?>