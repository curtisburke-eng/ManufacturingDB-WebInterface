<?php
    // connect to the database
    include('config/db_connect.php');

    // Write query for all trailers
    $sql = 'SELECT status.trailer_id, model_num, states.description, completed FROM status, models, states, trailers WHERE status.state_id=states.state_id AND trailers.trailer_id = status.trailer_id AND trailers.model_id = models.model_id ORDER BY trailers.trailer_id, status.state_id';

    // Make query & Get result
    $result  = mysqli_query($conn, $sql);

    // Fetch Resulting Rows as an array
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $trailer_array = array(
        "trailer" => array(),
        "model_num" => array(),
        "description" => array(),
        "completed" => array()
    );

    //$current_trailer_id = $rows[0]['trailer_id'];
    //echo 'Current id: ' . $current_trailer_id;

    // Echo Results at the top for debugging
    //print_r($rows);

    // Free resut from memory
    mysqli_free_result($result);

    mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

    <?php include('templates/header.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Trailer Build States</h4>

    </section>

    <div class="contrainer">
        <div class="row">

        <?php 
            $temp_desc_array = array();
            $temp_comp_array = array();

            foreach($rows as $row) { 
            
                $key = array_search($row['trailer_id'], $trailer_array['trailer']);
                
                if($key !== false) { // If trailer is found in trailer array  (ie trailer alread has descritptions)      //in_array($row['trailer_id'], $trailer_array['trailer'])) {
              
                    $trailer_array['description'][$key][] = $row['description'];
                    $trailer_array['completed'][$key][] = $row['completed'];

                }
                else {  // IF the trailer_id IS NOT found in trailer_array  (ie a new trailer)

                    $trailer_array['trailer'][] = $row['trailer_id'];
                    $trailer_array['model_num'][] = $row['model_num'];

                    $key = array_search($row['trailer_id'], $trailer_array['trailer']);     // get the updated key
                                        
                    $trailer_array['description'][$key][] = $row['description'];
                    $trailer_array['completed'][$key][] = $row['completed'];

                }
                
            }   
            
        ?>
        
        <?php 
            $i = 0;
            
            foreach($trailer_array['trailer'] as $value) { 
                $j = 0;
        ?>

        <div class="col s12 md6 l3">
                <div class="card z-depth-0">
                    <div class="card-content center">

                        <h5><?php echo 'Trailer: ' . htmlspecialchars($trailer_array['trailer'][$i]); ?></h5>
                        <div><?php echo 'Model: ' . htmlspecialchars($trailer_array['model_num'][$i]); ?></div>
                        
                        <?php foreach($trailer_array['description'][$i] as $value2) { ?>

                            <?php if($trailer_array['completed'][$i][$j] == 'T') { ?>
                                <div class="row left-align green"> 
                                    <div class="col left-align s9 md9 l9"><?php echo htmlspecialchars($trailer_array['description'][$i][$j]); ?></div>
                                    <div class="col right-align s3 md3 l3"><?php echo htmlspecialchars('Completed'); ?></div>
                                </div>
                            <?php } else {?>
                                <div class="row left-align "> 
                                    <div class="col left-align s9 md9 l9"><?php echo htmlspecialchars($trailer_array['description'][$i][$j]); ?></div>
                                    <!-- <div class="col right-align s1 md1 l1"><?php echo htmlspecialchars($trailer_array['completed'][$i][$j]); ?></div> -->
                                </div>
                            <?php } ?>
                   
                        <?php 
                            $j++;
                            } 
                        ?>
                    
  
                    </div>
                    <div class="card-action right-align">
                        <a class="brand-text" href="details.php?id=<?php echo  $trailer_array['trailer'][$i] ?>"> More info</a>
                    </div>
                </div>
            </div>
            
            <?php 
                $i++;
                } 
            ?>   


        </div>

    </div>


    <?php include('templates/footer.php'); ?>

</html>
