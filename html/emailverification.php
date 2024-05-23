<?php

session_start();

if (empty($_SESSION['email'])) {
    header('location:sing-up.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Email verification</title>

    <style>
        .cont {
    width: 40%;
    margin: 100px auto; 
    padding: 10px;
}
@media (max-width: 375px) {
    .cont {
width: 100%;
}
}
    </style>
</head>

<body>
    <div class="container">
        <div class="cont">
            <h5 style="text-align: center;">Nous vous avons envoyé le code,</h5>
            <h5 style="text-align: center;">Vérifiez votre boite mail</h5>
            <p>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    if (!empty($_GET['errorr'])) {
                        echo'<div class="alert alert-danger" role="alert" >
                        Code incorrect ! </div>';
                    }
                }
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                  if (!empty($_GET['errorer'])) {
                      echo'<div class="alert alert-success" role="alert" >
                      Verification code resent successfully! </div>';
                  }
              }
              if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!empty($_GET['erroreer'])) {
                    echo'<div class="alert alert-danger" role="alert" >
                    Failed to resend verification code. Please try again later. </div>';
                }
            }
            ?>
                </p>
            <form style="margin-top: 60px;" method="post" >
                <h6>Le code valable 10 minutes</h6>
                <div class="mb-3">
                    <label for="code" class="form-label">Code de verification</label>
                    <input type="text" class="form-control" id="code" name="code" minlength="6" maxlength="6" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Verifier</button>
            </form>
            <form method="post" class="form-control" action = "config.php">
            <input type="submit" class="btn btn-primary" style="width: 100%;" name="resend" value="Resend Verification Code">
            </form>
            <a href="sign-up.php"><button style="margin-top: 60px; width: 100%;" class="btn btn-primary">return Sign-up</button></a>
        </div>
    </div>
</body>

</html>

<?php
include('connexion.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['code'])) {
        $code_verification = $_POST['code'];
        $email = $_SESSION['email'];

        $sql = "select * from user where email='$email' and code_verification='$code_verification'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                if (((abs(time() - $row['login_date']) / 60)) < 10) {
                    $sql = "update user set is_verified='true' where email='$email'";
                    mysqli_query($con, $sql);
                    session_destroy();
                    header('location: sign-in.php?erof=code_verification');
                } else {
                    $sql = "delete from user where email='$email'";
                    mysqli_query($con, $sql);
                    session_destroy();
                    header('location:sign-up.php?CodeExpire=true');
                }
            }
        } else {
            header('location:emailverification.php?errorr=password');

          
        }
    }
}


  
?>