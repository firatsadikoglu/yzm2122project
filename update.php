<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Satici = $uruncinsi = $Miktar  = $SatÄ±ÅŸ_fiyat = "";

// Processing form data when form is submitted
if(isset($_POST["Id"]) && !empty($_POST["Id"])){
    // Get hidden input value
    $id = $_POST["Id"];
    
    // Validate name
    $Satici = trim($_POST["Satici"]);
   
    // Validate address address
    $urun_cinsi = trim($_POST["urun_cinsi"]);
    
    // Validate salary
    $Miktar = trim($_POST["Miktar"]);
   
   $Fiyat = trim($_POST["Satis_Fiyati"]);
    
    // Prepare an update statement
    $sql = "UPDATE saticilar SET Satici=?, Urun_cinsi=?, Miktar=? , Satis_Fiyati=? WHERE id=?";
         
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssi", $param_satici, $param_uruncinsi, $param_miktar,$param_Fiyat, $param_id);
            
            // Set parameters
            
            $param_satici=$Satici;
            $param_uruncinsi=$urun_cinsi;
            $param_miktar=$Miktar;
            $param_Fiyat; $Fiyat;
                
        // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: satici.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
   
    
    // Close connection
    mysqli_close($link);

        
       
  

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">KayÄ±t GÃ¼ncelleme</h2>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Satici</label>
                            <input type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label>Miktar</label>
                            <textarea name="Miktar"></textarea>
                           
                        </div>
                        <div class="form-group">
                            <label>SatiÅŸ FiyatÄ±</label>
                            <input type="text" name="Satis_Fiyati">
                        </div>
                        <input type="hidden" name="id" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
