<?php
    // Conect to the database
    include('config/db_connect.php');

    // Check data for malitious SQL code
    $model_num = mysqli_real_escape_string($conn, $_POST['model_num']);
    $serial_num = mysqli_real_escape_string($conn, $_POST['serial_num']);
    $mco = mysqli_real_escape_string($conn, $_POST['mco']);
    $vin = mysqli_real_escape_string($conn, $_POST['vin']);

    //CHECK IF MODEL_NUM EXISTS
    $query = "SELECT EXISTS(SELECT * FROM models WHERE model_num = '$model_num')";
    $result  = mysqli_query($conn, $query);
    // Fetch Resulting Rows as an array
    $model_exists = mysqli_fetch_all($result, MYSQLI_NUM);
    $model_exists = $model_exists[0][0];
    // Print Results (for debugging)
    //print_r($model_exists);
    //echo $model_exists;
    // Free resut from memory
    mysqli_free_result($result);

    // If model number DOES NOT exist in db => add it
    if(!$model_exists) {
        $query = "INSERT INTO models VALUES (NULL, '$model_num', NULL)";
        $err  = mysqli_query($conn, $query);
        if(!$err) {
            //Error
            echo 'Query Error with Model Number INSERT: ' . mysqli_error($conn);
        }
    }

    //GET MODEL_ID
    $query = "SELECT model_id FROM models WHERE model_num = '$model_num'";
    $result  = mysqli_query($conn, $query);
    // Fetch Resulting Rows as an array
    $model_id = mysqli_fetch_all($result, MYSQLI_NUM);
    $model_id = $model_id[0][0];
    // Echo Results at the top for debugging
    //echo $model_id;

    // Free resut from memory
    mysqli_free_result($result);
    
    // CHECK IF SERIAL NUMBER EXISTS
    $query = "SELECT EXISTS(SELECT * FROM trailers WHERE serial_num = $serial_num)";
    $result  = mysqli_query($conn, $query);
    // Fetch Resulting Rows as an array
    $exists = mysqli_fetch_all($result, MYSQLI_NUM);
    $exists = $exists[0][0];
    // Echo Results at the top for debugging
    //echo $exists;
    // Free resut from memory
    mysqli_free_result($result);
    
    // If trailer serial number exists in db Get trailer_id from db
    if($exists) {
        // GET TRAILER_ID AND MODEL_ID FROM trailers table
        $query = "SELECT trailer_id FROM trailers WHERE serial_num = $serial_num";
        $result  = mysqli_query($conn, $query);
        // Fetch Resulting Rows as an array
        $trailer_id = mysqli_fetch_all($result, MYSQLI_NUM);
        $trailer_id = $trailer_id[0][0];
        // Echo Results at the top for debugging
        //echo $trailer_id;
        // Free resut from memory
        mysqli_free_result($result);

        //UPDATE TABLE WITH NEW DATA (from form)
        $query = "UPDATE trailers SET model_id = '$model_id', mco = '$mco', vin = '$vin' WHERE trailer_id = $trailer_id";
        $result  = mysqli_query($conn, $query);
        if($result) {
            //Success
            header('Location: success.php');
        } else {
            //Error
            echo 'Query Error with Trailer UPDATE: ' . mysqli_error($conn);
        }
        // Free resut from memory
        mysqli_free_result($result);

    } else { // Trailer doesn't exsist
        //INSERT INTO TABLE WITH NEW DATA (from form)
        $query = "INSERT INTO trailers VALUES (NULL, '$model_id', '$vin', $serial_num, '$mco')";
        $result  = mysqli_query($conn, $query);
        if($result) {
            //Success
            header('Location: success.php');
        } else {
            //Error
            echo 'Query Error with Trailer INSERT: ' . mysqli_error($conn);
        }
        // Free resut from memory
        mysqli_free_result($result);

    }

    mysqli_close($conn);    

?>
