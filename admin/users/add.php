<?php
$error_fields=array();
$email_exist="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //VALIDATION
    if(! (isset($_POST['name']) && !empty($_POST['name'])) ) {
        $error_fields[]="name";
    }

    if(! (isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))) {
        $error_fields[]="email";
    }

    if(! (isset($_POST['password']) && strlen($_POST['password'])>5) ) {
        $error_fields[]="password";
    }

    if(! $error_fields) {
        $conn=mysqli_connect("localhost","root","","myDB");
        if(!$conn){
            echo mysqli_connect_error();
            exit;
        }
        //Escape any special chars to avoid SQL injection
        $name=mysqli_escape_string($conn,$_POST['name']);
        $email=mysqli_escape_string($conn,$_POST['email']);
        $password=sha1($_POST['password']);
        $admin=(isset($_POST['admin'])) ? 1 : 0 ;
        $chquery="SELECT email FROM users";
        $chres=mysqli_query($conn,$chquery);
        $chrow=mysqli_fetch_array($chres);
       
        if (in_array($email,$chrow)) {
            $email_exist="exist";

        }else {
            $query="INSERT INTO users (name,email,password,admin) Values ('$name','$email','$password',$admin)";
        $result=mysqli_query($conn,$query);
        if ($result) {
            header("Location: list.php");
            exit;
        }else {
            echo mysqli_error($conn);
        }
        
        mysqli_close($conn);
        }

        //Connect to DB
       
       
            
        
    }
}

?>

<html>
    <head><title>Admin :: Add User</title></head>
    <link rel="stylesheet" href="./css/authstyles.css">
<body>
    
    <div class="login">
    <div class="login-triangle"></div>
    <h2 class="login-header">Add User</h2>
    <form class="login-container"  method="post">
    
    
    <input placeholder="Your Name" type="text" name="name" value="<?= (isset($_POST['name'])) ? $_POST['name'] :'' ?>"/>
    <h5 class="red"><?php if (in_array("name",$error_fields))
     echo "*plese enter your name"?></h5>


    
    
    <input placeholder="Your Email" type="email" name="email" id="email" value="<?= (isset($_POST['email'])) ? $_POST['email'] :'' ?> "/>
    <h5 class="red"><?php if (in_array("email",$error_fields)) echo "*plese enter valid email";?></h5>

   

    
    <input placeholder="Your Password" name="password" id="password" type="password" />
    <h5 class="red"><?php if (in_array("password",$error_fields))
     echo "*Please Enter a password not less than 6 characters"; ?></h5>
     
  

    <input type="checkbox" name="admin" value="<?= (isset($_POST['admin'])) ? 'checked' : '' ?> " />Admin
    <h5 class="red"><?php if ($email_exist=="exist") {
        echo "*this email is already registered before";
     }?></h5>
 <input type="submit"  name="submit" value="Add User" /></br>
<a href="./auth.php" class="button" >Sign In</a>
   
    
    </form>
</div>
</body>
</html>