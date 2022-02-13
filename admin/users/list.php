<?php
session_start();
if (isset($_SESSION['id'])) {
    echo "<h1 class='main-title'>Welcome <span class='thin'>".$_SESSION['name']."</span></h1>";

}else {
    header("Location: ./auth.php");
    exit;
}

$conn=mysqli_connect("localhost","root","","myDB");
if (! $conn) {
    echo mysqli_connect_error();
    exit;
}


$query="SELECT * FROM users";

if (isset($_GET['search'])) {
    $search=mysqli_escape_string($conn,$_GET['search']);
    $query.= " WHERE `users`.`name` LIKE '%".$search."%' OR `users`.`email` LIKE '%".$search."%'";
}
$sel=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> LIST </title>
    <link rel="stylesheet" href="./css/liststyles.css">
   
</head>
<body>
    <a id="logout" href="./auth.php">Logout</a></br>
   <form method="get">
       
       <input type="text" name="search" placeholder="Search By Name">
       <input type="submit" value="Search">
   </form>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Admin</th>
<th>Actions</th>
</tr>
<tbody>
<tr>
<?php
while ($row=mysqli_fetch_assoc($sel)) { ?>
   <?php
   if ($_SESSION['admin']){?>
   <tr> <td><?=$row['id']?></td>
    <td><?=$row['name']?></td>
    <td><?=$row['email']?></td>
    <td><?=($row['admin']) ? 'Yes' : 'No' ?></td>
    <td><a href="edit.php?id= <?=$row['id']?>">Edit</a> | <a href="delete.php?id= <?=$row['id']?>">Delete</a> </td></tr>
   <?php }else{?>
      <tr><td><?=$row['id']?></td>
      <td><?=$row['name']?></td>
      <td><?=$row['email']?></td>
      <td><?=($row['admin']) ? 'Yes' : 'No' ?></td>
      <?php while ($row['id']) {
          if ($row['id']==$_SESSION['id']) { ?>
            <td><a href="edit.php?id= <?=$row['id']?>">Edit</a> </td>
         <?php } else {
             ?>
             <td>Secured</td>
          <?php
         } break;
      } 
      ?>
      
  
      
      </tr></tbody>
   <?php }
   }?>

<tfoot>
<tr>
<td style="text-align:center" colspan="2"><?php echo mysqli_num_rows($sel) ?> Users</td>
<td style="text-align:center" colspan="3"><a href="add.php">Add User</a></td>
</tr>
</tfoot>
<?php 
//close connection
mysqli_free_result($sel);
mysqli_close($conn);
?>
</body>
</html>