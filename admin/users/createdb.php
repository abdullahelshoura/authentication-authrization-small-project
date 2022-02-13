<?php



///////////DATABASE CREATION/////////////////
// Create connection
// $conn = mysqli_connect("localhost", "root", "");

// // Check connection
// if (! $conn) {
//   echo mysqli_connect_error();
//   exit;
// }
// echo "Connected successfully";

// $DB="CREATE DATABASE IF NOT EXISTS myDB;";
// $createDB=mysqli_query($conn,$DB);
// if (! $createDB) {
//     echo mysqli_connect_error();
//     exit;
//   }
//   echo "</br>DATABASE Created successfully";


///////////////TABLE CREATION///////////////

// Create connection
$conn = mysqli_connect("localhost", "root", "","myDB");

// Check connection
if (! $conn) {
  echo mysqli_connect_error();
  exit;
}
echo "Connected successfully";

  $TAB="CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255),
    Password nvarchar(256) not null,
    Admin boolean,
    PRIMARY KEY (ID)
);";
$CreateTAB=mysqli_query($conn,$TAB);
if ($CreateTAB) {
    echo "Table Created Successfully";
}

mysqli_close($conn);
?>