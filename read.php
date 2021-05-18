<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "config.php";
    
    $sql = "SELECT * FROM saticilar WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $Satici = $row["Satici"];
                $Urun_cinsi = $row["Urun_cinsi"];
                $Miktar = $row["Miktar"];
                $Satis_Fiyati = $row["Satis_Fiyati"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SatÄ±cÄ± Bilgileri</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">SatÄ±cÄ± Bilgileri</h1>
                    <div class="form-group">
                        <label>SatÄ±cÄ±</label>
                        <p><b><?php echo $row["Satici"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Urun Cnsi</label>
                        <p><b><?php echo $row["Urun_cinsi"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>MiktarÄ±</label>
                        <p><b><?php echo $row["Miktar"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>SatiÅŸ FiyatÄ±</label>
                        <p><b><?php echo $row["Satis_Fiyati"]; ?></b></p>
                    </div>
                    <p><a href="satici.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
