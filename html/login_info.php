<?php
// Include database connection or configuration file
include('connexion.php');
session_start();

if (!empty($_SESSION["user_id"])) {
    header('location:index.php');
  }

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
  

    $sql = "select * from user where email='$email' and password='$password' ";
  
    $result = mysqli_query($con, $sql);
  
  
    if (mysqli_num_rows($result) > 0) {
  
      while ($row = mysqli_fetch_array($result)) {
        if ($row['is_verified'] == 'true') {
          $_SESSION["user_id"] = $row['id'];
          $_SESSION["name"] = $row['name'];
          $_SESSION["role"] = $row['role'];
          $_SESSION["email"] = $row['email'];
          $_SESSION["ville"] = $row['ville'];
          $_SESSION["telephone"] = $row['telephone'];
          $_SESSION["balance"] = $row['balance'];
          $_SESSION["role_ads"] = $row['role_ads'];
          $_SESSION["role_brand"] = $row['role_brand'];
  
          header('Location:index.php');
        } else {
          $_SESSION["email"] = $row['email'];
          header('Location:emailverification.php');
        }
      }
    } else {
       header('Location:sign-in.php?errorer=password'); 
    }
  }


  if (isset($_POST['logout'])) {
    session_destroy();
    header('location:sign-in.php');
  }

?>