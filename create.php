<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Satici = trim($_POST["Satici"]);
    
    $Miktar = trim($_POST["Miktar"]);
   
    $Satis_Fiyati = trim($_POST["Satis_Fiyati"]);
    $cinsi=$_POST['cinsi'];
    // Prepare an insert statement
    $sql = "INSERT INTO saticilar (Satici, Urun_cinsi, Miktar, Satis_Fiyati) VALUES (?, ?, ?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssss", $param_satici, $param_cinsi, $param_miktar,$param_fiyati);
            
            // Set parameters
            $param_satici=$Satici;
            $param_cinsi=$cinsi;
            $param_miktar=$Miktar;
            $param_fiyati=$Satis_Fiyati;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
                    <h2 class="mt-5">Satıcı Kaydı</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Satıcı</label>
                            <input type="text" name="Satici" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Miktar</label>
                            <textarea name="Miktar" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                           <div class="form-group">
                            <label>Ürün_Cinsi</label>
                                <select name="cinsi">
                                <option value="Arpa">Arpa</option>
                                <option value="Buğday">Buğday</option>
                                <option value="Yulaf">Yulaf</option>
                                <option value="Pamuk">Pamuk</option>
                              </select>
                        </div>
                        <div class="form-group">
                            <label>Satis_Fiyati</label>
                            <input type="text" name="Satis_Fiyati" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                      
      
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>