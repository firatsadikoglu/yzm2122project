<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Ad = trim($_POST["Ad"]);
    
    $Para = trim($_POST["Para"]);
   
    
    $sql = "INSERT INTO alicilar (Ad, Para) VALUES (?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_Ad, $param_Para);
            
            // Set parameters
            $param_Ad=$Ad;
            $param_Para=$Para;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: alici.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Alıcı Kaydı</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Alıcı</label>
                            <input type="text" name="Ad">
                        </div>
                        <div class="form-group">
                            <label>Para</label>
                            <input type="text" name="Para">
                        </div>
                           
                        
      
                        <input type="submit" class="btn btn-primary" value="Kaydet">
                        <a href="alici.php" class="btn btn-secondary ml-2">Vazgeç</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>