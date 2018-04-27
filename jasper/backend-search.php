<?php
include('admin/config.php');
 
if(isset($_REQUEST['term'])){
    // Prepare a select statement
    $sql = "SELECT * FROM tbl_locations WHERE region LIKE ?";
    
    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST['term'] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                $i=1;
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    if($i==1 || $i==0){
                    echo "<p style='background: white;margin-top: -4px;margin-left: 0px;color: black;padding: 3px 83px;'>". $row["region"] . "</p>";
                    }
                    else {
                    echo "<p style='background: white;margin-top: -46px;margin-left: 0px;color: black;padding: 3px 83px;'>". $row["region"] . "</p>";    
                    }
               $i++; }
            } else{
                echo "<p style='background: white;margin-top: -4px;margin-left: 0px;color: black;padding: 3px 83px;'>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($con);
?>