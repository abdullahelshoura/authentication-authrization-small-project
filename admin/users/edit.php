<?php
$conn=mysqli_connect("localhost","root","","myDB");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$select="SELECT * FROM users WHERE users.id=$id LIMIT 1";
$result=mysqli_query($conn,$select);
$row=mysqli_fetch_assoc($result);

$error_fields=array();
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
        //Connect to DB
        
        //Escape any special chars to avoid SQL injection
        $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
        $name=mysqli_escape_string($conn,$_POST['name']);
        $email=mysqli_escape_string($conn,$_POST['email']);
        $password=(!empty($_POST['password'])) ? sha1($_POST['password']) : $row['password'];
        $admin=(isset($_POST['admin'])) ? 1 : 0 ;
        $query="UPDATE users SET name='$name',email='$email',password='$password',admin='$admin' WHERE users.id=$id";
        $result=mysqli_query($conn,$query);
        if ($result) {
            header("Location: list.php");
            exit;
        }else {
            echo mysqli_error($conn);
        }
            
        mysqli_close($conn);
    }
}

?>

<html>
    <head><title>Admin :: Add User</title></head>
    <link rel="stylesheet" href="./css/authstyles.css">
<body>
<div class="login">
    <div class="login-triangle"></div>
    <h2 class="login-header">Edit User Information</h2>
    <form class="login-container"  method="post">

    <input  type="text" name="name" value="<?= (isset($row['name'])) ? $row['name'] :'' ?> "/>
    <?php if (in_array("name",$error_fields))
     echo "*plese enter your name"?>

    <input type="hidden" name="id" id="id" value="<?= (isset($row['id'])) ? $row['id'] :'' ?> "/>   

     </br>
    
    <input type="email" name="email" id="email" value="<?= (isset($row['email'])) ? $row['email'] :'' ?> "/>
    <?php if (in_array("email",$error_fields))
     echo "*plese enter valid email";?>

     </br>

    <input placeholder="Your Password" name="password" id="password" type="password" />
    <?php if (in_array("password",$error_fields))
     echo "*Please Enter a password not less than 6 characters"; ?>
     
    </br>

    <input type="checkbox" name="admin" value="<?= (isset($row['admin'])) ? 'checked' : '' ?> " />Admin
    </br><br>
    <input type="submit"  name="submit" value="Edit" />
   
    
    </form>
</div>
</body>
</html>