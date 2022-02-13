<?php
$conn=mysqli_connect("localhost","root","","myDB");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}
$id=filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
$select="DELETE FROM users WHERE users.id=$id LIMIT 1";
$result=mysqli_query($conn,$select);
if ($result) {
    header("Location: list.php");
        exit;
}else{
    echo mysqli_error($conn);
}
mysqli_close($conn);