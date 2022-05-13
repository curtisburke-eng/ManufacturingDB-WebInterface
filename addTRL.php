<?php
    
    $model_num = '';
    $serial_num = '';
    $mco = '';
    $vin = '';

    $errors = array('model_num' => '','serial_num' => '','vin' => '','mco' => '');
    
    if(isset($_POST['submit'])){

        // Check & Validate Model Number
        if(empty($_POST['model_num'])) {
            $errors['model_num'] = 'A Trailer Model is required. <br />';
        } else {
            $model_num = $_POST['model_num'];
            if(!preg_match('/^\b[a-zA-Z0-9]+\b$/', $model_num)) {
                $errors['model_num'] =  'Model must be a single word; Only letters & numbers (no special characters). <br />';
            }
        }
        
        // Check & Validate Serial Number
        if(empty($_POST['serial_num'])) {
            $errors['serial_num'] = 'A Trailer Serial Number is required. <br />';
        } else {
            $serial_num = $_POST['serial_num'];
            if(!preg_match('/^[1]{1}[0]{1}[\d]{6}$/', $serial_num)) {
                $errors['serial_num'] = 'Serial Number must be: 8 digits long, only numbers, and must begin with "10". <br />';
            }
        }
        
        // Check & Validate VIN
        if(!empty($_POST['vin'])) {
            $vin = $_POST['vin'];
            if(!preg_match('/^[a-zA-Z0-9]{17}$/', $vin)) {
                $errors['vin'] =  'VIN must be: 17 digits long and only letters & numbers (no special characters). <br />';
            }
        } 

        // Check & Validate MCO
        if(empty($_POST['mco'])) {
            $errors['mco'] =  'A Manufacturer Certificate of Origin is required. <br />';
        } else {
            $mco = $_POST['mco'];
        }

        // Check if any errors exsits
        if(array_filter($errors)) {  //IF no errors inside $errors will return false
            // Errors in the array
            
        } else { // No errors in array
            // Add to database
            include('addToDB.php');
        }

    }

?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Add a New Trailer</h4>
    <form class="white" action="addTRL.php" method="POST">
        <label>Trailer Model:</label>
        <input type="text" name="model_num" value="<?php echo htmlspecialchars($model_num) ?>">
        <div class="red-text"><?php echo $errors['model_num']; ?></div>

        <label>Serial Number: (1000XXXX)</label>
        <input type="text" name="serial_num" value="<?php echo htmlspecialchars($serial_num); ?>">
        <div class="red-text"><?php echo $errors['serial_num']; ?></div>

        <label>MCO: </label>
        <input type="text" name="mco" value="<?php echo htmlspecialchars($mco); ?>">
        <div class="red-text"><?php echo $errors['mco']; ?></div>

        <label>VIN: (optional)</label>
        <input type="text" name="vin" value="<?php echo htmlspecialchars($vin); ?>">
        <div class="red-text"><?php echo $errors['vin']; ?></div>

        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php'); ?>

</html>
