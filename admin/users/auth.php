<?php
session_start();
$error_fields=array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['signup'])){
        header("Location: ./add.php");}
    //VALIDATION
    if(! (isset($_POST['authemail']) && filter_input(INPUT_POST,'authemail',FILTER_VALIDATE_EMAIL))) {
        $error_fields[]="authemail";
    }

    if(! (isset($_POST['authpass']) && strlen($_POST['authpass'])>5) ) {
        $error_fields[]="authpass";
    }

    if(! $error_fields) {
        //Connect to DB
        $conn=mysqli_connect("localhost","root","","myDB");
        if(!$conn){
            echo mysqli_connect_error();
            exit;
        }
        //Escape any special chars to avoid SQL injection
        // $name=mysqli_escape_string($conn,$_POST['name']);
        $email=mysqli_escape_string($conn,$_POST['authemail']);
        $password=sha1($_POST['authpass']);
        // $admin=(isset($_POST['admin'])) ? 1 : 0 ;
        $query="SELECT * FROM users WHERE email='$email' and password='$password'";
        $result=mysqli_query($conn,$query);
        if ($row=mysqli_fetch_assoc($result)) {
            // $query1="SELECT password FROM users WHERE email=$email";
            $_SESSION['id']=$row['id'];
            $_SESSION['email']=$row['email'];
            $_SESSION['name']=$row['name'];
            $_SESSION['admin']=$row['admin'];
            header("Location: ./list.php");
            exit;
            
            
        }else {
            $error="Invalid Password";
        }
            
        mysqli_close($conn);
    }
}

?>

<html>
    <head><title>Login Form</title></head>
    <link rel="stylesheet" href="./css/authstyles.css">
<body>
    <?php if (isset($error)) echo $error;?>
    <div class="login">
    <div class="login-triangle"></div>
    <h2 class="login-header">Log in</h2>
    <form class="login-container"  method="post">

    <p><input placeholder="Email" type="email" name="authemail" id="authemail" value="<?= (isset($_POST['authemail'])) ? $_POST['authemail'] :'' ?> "/></p>
    
    <h5 class="h5"><?php if (in_array("authemail",$error_fields))
     echo "*plese enter valid email";?></h5>

    <p><input placeholder="Password" name="authpass" id="authpass" type="password" /></p>
    
    <h5 class="h5"><?php if (in_array("authpass",$error_fields))
     echo "*Wrong password"; ?></h5>
     



    <p><input type="submit"  name="signin" value="Sign In" /></p>
    <p><input type="submit"  name="signup" value="Sign Up" /></p>
   
    
    </form>
</div>
</body>
</html>