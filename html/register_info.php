<?php
// Include database connection or configuration file
include('connexion.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random verification code
function generateVerificationCode()
{
    return rand(100000, 999999);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['name']) && !empty($_POST['ville']) && !empty($_POST['telephone']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_2'])) {
        $name = $_POST['name'];
        $ville = $_POST['ville'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_2 = $_POST['password_2'];

        if ($password != $password_2) {
            header('location:sign-up.php?error=password');
        } else {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,50}$/', $password)) {
                header('location:sign-up.php?errore=password');
            } else {
                $sqle = "select * from user where email='$email'";
                $resul = mysqli_query($con, $sqle);
                $present = mysqli_num_rows($resul);
                if ($present > 0) {
                    header('location:sign-up.php?erroree=password');
                } else {
                    $code_verification = generateVerificationCode();

                    $time = time();

                    $sql = "insert into user (name, ville,email,telephone, password, code_verification, login_date, is_verified,role,role_ads,role_brand) VALUES ('$name', '$ville ','$email','$telephone', '$password', '$code_verification','$time','false','client','client','client')";

                    mysqli_query($con, $sql);


                    //required files
                    require '../PHPMailer/src/Exception.php';
                    require '../PHPMailer/src/PHPMailer.php';
                    require '../PHPMailer/src/SMTP.php';

                    //Create an instance; passing `true` enables exceptions


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
                    $mail->Subject = 'Email Verification';   // email subject headings
                    $mail->Body    = 'Your verification code is: ' . $code_verification; //email message


                    // Success sent message alert
                    if ($mail->send()) {
                        session_start();
                        $_SESSION["email"] = $email;
                        header('location:emailverification.php');
                    } else {
                        header('location:./');
                    }
                }
            }
        }
    }
}
