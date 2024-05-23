

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Site web</title>
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
            <h2>Forgot password</h2>
            <form  style="margin-top: 60px;"  method="post" >
             <label for="email"><b>Email</b></label>
            <input type="email" class="form-control" placeholder="Enter Email" name="email"  style="margin-top: 60px;" required>
            <button type="submit" class="btn btn-primary"  style="width: 100%; margin-top: 60px;">Send me a random password</button>
            </form>
                <a href="sign-in.php"><button style="margin-top: 30px;  width: 100%;" class="btn btn-primary"  >return sign-in</button></a>
        </div>
     </div>
  </body>
</html>

<?php
   include 'connexion.php';
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  
  require '../PHPMailer/src/Exception.php';
  require '../PHPMailer/src/PHPMailer.php';
  require '../PHPMailer/src/SMTP.php';
  
  if (isset($_POST['email'])) {

    $email = $_POST['email'];
    $password = uniqid();
    $message = "Bonjour, voici votre nouveau mot de passe:$password";

    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'contact@mediabenotman.com';   //SMTP write your email
    $mail->Password   = 'Mediabenotman@00';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('contact@mediabenotman.com'); // Sender Email and name
    $mail->addAddress($email);  //Add a recipient email  
    // reply to sender email

    //Content
    $mail->Subject = 'Reset Password';   // email subject headings
    $mail->Body    = 'Your new password is:  ' . $password; //email message


    // Success sent message alert
    if ($mail->send()) {
        session_start();
        $con->query("update user set password ='$password' where email ='".$_POST['email']."'");
        header('location:sign-in.php?err=email');
    } else {
      header('location:sign-in.php?er=email');
    }
  }
   

?>