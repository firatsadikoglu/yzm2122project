<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Lütfen Parolayı giriniz";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE Kullanici_Adi = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Kullanici adı zaten var.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "ters giden birşeyler var yeniden deneyiniz.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Parolayı giriniz.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "En az altı karakter giriniz.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Lütfen parolayı onaylayınız.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Parolalar uyuşmadı.";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (Ad, Soyad, Kullanici_Adi, Password, Tc, Telefon, Email, Adres) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_Ad, $param_Soyad, $param_username, $param_password, $param_Tc, $param_Telefon, $param_Email,$param_Adres);
            
            // Set parameters
            

            $param_username = trim($_POST["username"]);
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            $param_Ad=trim($_POST["Ad"]);

            $param_Soyad=trim($_POST["Soyad"]);

            $param_Tc=trim($_POST["Tc"]);
            $param_Telefon=trim($_POST["Telefon"]);
            $param_Email=trim($_POST["Email"]);
            $param_Adres=trim($_POST["Adres"]);



            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Birşeyler Ters gitti";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Formu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Kayıt Formu</h2>
        <p>Lütfen gerekli alanları doldurunuz.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Adı</label>
                <input type="text" name="Ad">
            </div>
            <div class="form-group">
                <label>Soyad</label>
                <input type="text" name="Soyad">
            </div>
            <div class="form-group">
                <label>Kullanıcı Adı</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Tc</label>
                <input type="text" name="Tc">
            </div>
            <div class="form-group">
                <label>Telefon</label>
                <input type="text" name="Telefon">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="Email">
            </div>
            <div class="form-group">
                <label>Adres</label>
                <input type="text" name="Adres">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Kaydol">
                <input type="reset" class="btn btn-secondary ml-2" value="Temizle">
            </div>
            <p>Hesabım var? <a href="login.php">Giriş sayfası</a>.</p>
        </form>
    </div>    
</body>
</html>