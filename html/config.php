<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$id = $_SESSION["user_id"];
$balancee = $_SESSION["balance"];
$emmmil = $_SESSION["email"];
$user_name = $_SESSION["name"];
$rolle = $_SESSION["role"];
$rolee = $_SESSION["role_ads"];
$roleb = $_SESSION["role_brand"];
include 'connexion.php';


if (isset($_POST['adduser'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['telephone'];
  $ville = $_POST['ville'];
  $role = $_POST['role'];
  $passwrd = $_POST['password'];
  $time = time();
 
  $con->query("insert into user(name,email,telephone,ville,role,password,is_verified,login_date) values('$name','$email','$phone','$ville','$role','$passwrd','true','$time')");

  header('location: users.php');
} 
if(isset($_POST["bal"])){
  
  $idLead = $_POST['idLead'];
  $idus = $_POST['idus'];
  $idnm = $_POST['idnm'];
  $idcr = $_POST['idcr'];
  $emailll = $_POST['emailll'];

  function random_string($length) {
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
  $rand =  random_string(10);
  $reference = "MBO".$rand;

  $con->query("update user set balance = balance +'$idLead'  where id= '".$idus."'");

  $con->query("update subscr set etat = 'accepte'  where id= '".$idcr."'");

  $sql_6 = 'select * from user  where id= "'.$idus.'"';
  $result_6 = mysqli_query($con, $sql_6);
  $row_6 = $result_6->fetch_assoc();
  $data_66 = $row_6['id'];
  $data_76 = $row_6['role'];
  $datee= date("Y-m-d H:i:s");  

  if($idLead > 0){
    $con->query("insert into balance_suivi (reference,name,role,date_add,balance_add,information,user_id,balance_type) values('$reference','$idnm','$data_76','$datee','$idLead','Modif by ".$user_name."','$data_66','add')");
  }
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
  $mail->addAddress($emailll);  //Add a recipient email  
  // reply to sender email

  //Content
  $mail->Subject = 'Your request has been approved';   // email subject headings
  $mail->Body    = 'Balance Add is: ' . $idLead.' MAD'; //email message


  // Success sent message alert
  if ($mail->send()) {
      header('location:subscriber.php');
  } else {
      header('location:./');
  }

  header('location: subscriber.php');
}

if(isset($_POST["Deluser"])){
  $sql = 'delete from  user  where id="'.$_POST["idLead"].'"';
  mysqli_query($con, $sql);
  header('location: users.php');
}
if(isset($_POST["delp"])){
  $sql = 'delete from  product  where id="'.$_POST["idLead"].'"';
  mysqli_query($con, $sql);
  header('location: product.php');
}

if(isset($_POST['mailSub'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $message=$_POST['message'];

    $to='contact@mediabenotman.com' ;
    $headers = "From:".$email."\r\n";
    $body =  "Name : {$name}\n\nEmail : {$email}\n\nMessage : {$message}";
    $subject = "New Message From Website Contact Form";

    mail($to,$subject,$body,$headers);

header('location: contact.php?ree=email');

}
if (isset($_POST['upppp'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $telephone = $_POST['telephone'];
  $ville = $_POST['ville'];
  $password =$_POST['password'];
  $con->query("update user set password='$password' , email='$email' , name='$name', telephone ='$telephone' , ville = '$ville'    where id= '".$_POST["idLead"]."'");

  header('location: profile.php');

}
if (isset($_POST['upduser'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $telephone = $_POST['telephone'];
  $ville = $_POST['ville'];
  $password =$_POST['password'];
  $role =$_POST['role'];
  $date =$_POST['date'];
  $balance =$_POST['balance'];

  function random_string($length) {
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
  $rand =  random_string(10);
  $reference = "MBO".$rand;

  $con->query("update user set balance = balance +'$balance',date='$date',password='$password' , email='$email' , name='$name', telephone ='$telephone' , ville = '$ville' , role ='$role'   where id= '".$_POST["idLead"]."'");
  $sql_6 = 'select * from user  where id= "'.$_POST["idLead"].'"';
  $result_6 = mysqli_query($con, $sql_6);
  $row_6 = $result_6->fetch_assoc();
  $data_66 = $row_6['id'];
  $datee= date("Y-m-d H:i:s");  

  if($balance > 0){
    $con->query("insert into balance_suivi (reference,name,role,date_add,balance_add,information,user_id,balance_type) values('$reference','$name','$role','$datee','$balance','Modif by ".$user_name."','$data_66','add')");
  }
  header('location: users.php');
} 
if (isset($_POST['aded'])) {

  $title = $_POST['title'];
  $description = $_POST['description'];
  $fournisseur2 = $_POST['fournisseur2'];
  $fournisseur1 = $_POST['fournisseur1'];
  
  $linkdesc = $_POST['linkdesc'];
  $linkvid = $_POST['linkvid'];
  $total_cost = $_POST['total_cost'];
  $shppi_cost = $_POST['shppi_cost'];

  $category = $_POST['category'];
  $benifit = $_POST['benifit'];
  $product_price = $_POST['product_price'];
  $selling_price = $_POST['selling_price'];
  $ads_cost = $_POST['ads_cost'];
  $ads_delivery = $_POST['ads_delivery'];
  $confirmation_rate = $_POST['confirmation_rate'];
  $delivery_rate = $_POST['delivery_rate'];
  $status = $_POST['status'];
  $date= date("Y-m-d H:i:s");
 

  $con->query("update product set date='$date',status='$status',total_cost='$total_cost',shppi_cost='$shppi_cost',title='$title',description='$description' , fournisseur1 ='$fournisseur1' , fournisseur2 ='$fournisseur2' 
  , category = '$category', benifit = '$benifit' , product_price = '$product_price' ,selling_price = '$selling_price' 
  ,ads_cost = '$ads_cost',ads_delivery = '$ads_delivery',confirmation_rate = '$confirmation_rate',delivery_rate = '$delivery_rate' ,linkdesc='$linkdesc',linkvid='$linkvid' where id= '".$_POST["idLead"]."'");

  header('location: product.php');

}

if (isset($_POST['adede'])) {

  $linkdesc = $_POST['linkdesc'];
  $linkvid = $_POST['linkvid'];
  $total_cost = $_POST['total_cost'];
  $shppi_cost = $_POST['shppi_cost'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $fournisseur2 = $_POST['fournisseur2'];
  $fournisseur1 = $_POST['fournisseur1'];
  $category = $_POST['category'];
  $benifit = $_POST['benifit'];
  $product_price = $_POST['product_price'];
  $selling_price = $_POST['selling_price'];
  $ads_cost = $_POST['ads_cost'];
  $ads_delivery = $_POST['ads_delivery'];
  $confirmation_rate = $_POST['confirmation_rate'];
  $delivery_rate = $_POST['delivery_rate'];
  $status = $_POST['status'];
  $date= date("Y-m-d H:i:s");


  $image = $_FILES['image'];
  move_uploaded_file($_FILES['image']["tmp_name"], "../images/".$_FILES["image"]["name"]);
  $name = $_FILES["image"]["name"];

  $image1 = $_FILES['image1'];
  move_uploaded_file($_FILES['image1']["tmp_name"], "../images/".$_FILES["image1"]["name"]);
  $im = $_FILES["image1"]["name"];

  $vedio = $_FILES['vedio'];
  move_uploaded_file($_FILES['vedio']["tmp_name"], "../images/".$_FILES["vedio"]["name"]);
  $namee = $_FILES["vedio"]["name"];

 
  $con->query("insert into product(title,description,fournisseur1,fournisseur2,category,benifit,product_price,selling_price,ads_cost,ads_delivery,confirmation_rate,delivery_rate,image,vedio,image1,linkdesc,linkvid,shppi_cost,total_cost,status,date) 
  values('$title','$description','$fournisseur1','$fournisseur2','$category','$benifit','$product_price','$selling_price','$ads_cost','$ads_delivery','$confirmation_rate','$delivery_rate','$name','$namee','$im','$linkdesc','$linkvid','$shppi_cost','$total_cost','$status','$date')");

  header('location: product.php');

}
if (isset($_POST['sett'])) {

  $balance = $_POST['balance'];
  $note = $_POST['note'];
  $namee = $_SESSION['name'];
  $image = $_FILES['recu'];
  move_uploaded_file($_FILES['recu']["tmp_name"], "./images/".$_FILES["recu"]["name"]);
  $name = $_FILES["recu"]["name"];

  $con->query("insert into subscr(balance,note,img,name,user_id,email) 
  values('$balance','$note','$name','$namee','$id','$emmmil')");

  header('location: index.php?msgg=balance');
}


if(isset($_POST['pack_vid'])){
  $type = $_POST['pack_type'];
  $price = $_POST['price'];
  $date= date("Y-m-d H:i:s");

  $videos_count = 0;
  $model_count = 0;

  if($type == 'basic'){
    if($price == '600'){
      $videos_count = 3;
    }elseif( $price == '850' ){
      $videos_count = 5;
    }elseif( $price == '2250' ){
      $videos_count = 15;
    }
  }elseif($type == 'standard'){
    if( $price == '700' ){
      $videos_count = 2;
      $model_count = 1;
    }elseif( $price == '1600' ){
      $videos_count = 5;
      $model_count = 2;
    }elseif( $price == '2900' ){
      $videos_count = 10;
      $model_count = 3;
    }
  }elseif($type == 'premium'){
    if( $price == '1200' ){
      $videos_count = 3;
      $model_count = 1;
    }elseif( $price == '1800' ){
      $videos_count = 15;
    }  
  }

  if($_SESSION["balance"] < intval($price)){
    header('location:video_pack.php?err=balance');
  }else{
    $con->query("INSERT INTO `pack`( `type`, `price`, `video_count`, `model_count`, `user_id`, `user_name`,date) VALUES ('".$type."','".$price."','".$videos_count."','".$model_count."','".$id."','".$user_name."','$date')");
    $con->query("update user set balance = balance - '$price' where id = '$id'");

    function random_string($length) {
      $str = random_bytes($length);
      $str = base64_encode($str);
      $str = str_replace(["+", "/", "="], "", $str);
      $str = substr($str, 0, $length);
      return $str;
  }
    $rand =  random_string(10);
    $reference = "MBO".$rand;

    $sql_6 = 'select * from user  where id= "'.$id.'"';
    $result_6 = mysqli_query($con, $sql_6);
    $row_6 = $result_6->fetch_assoc();
    $data_6 = $row_6['name'];
    $data_7 = $row_6['role'];
    $data_66 = $row_6['id'];
    $datee= date("Y-m-d H:i:s"); 

    $con->query("insert into balance_suivi (reference,name,role,date_add,balance_add,information,user_id,type,balance_type) values('$reference','$data_6','$data_7','$datee','$price','transaction by ".$data_6."','$data_66','Video pack ".$type."','sub')");

    $_SESSION["balance"] -= $price;


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
  $mail->addAddress($emmmil);  //Add a recipient email  
  // reply to sender email

  //Content
  $mail->Subject = ' Pack Videos ';   // email subject headings
  $mail->Body    = 'Thank you for purchasing our pack'; //email message


  // Success sent message alert
  if ($mail->send()) {
      header('location:pricing_video.php');
  } else {
      header('location:./');
  }

    header('location:pack_list_v.php?err=add');
  }
  
}



if (isset($_POST['ared'])) {
  
  $country = $_POST['country'];
  $Plink = $_POST['Plink'];
  $image = $_FILES['imgs'];
  move_uploaded_file($_FILES['imgs']["tmp_name"], "../images/".$_FILES["imgs"]["name"]);
  $name = $_FILES["imgs"]["name"];  
  $note = $_POST['note'];
  $Voixoff = $_POST['Voixoff'];
  $langue = $_POST['langue'];
  $audiance = $_POST['audiance'];
  $offres = $_POST['offres'];
  $id_pack = $_POST['id_pack'];
  $date= date("Y-m-d H:i:s");
  $namee = $_SESSION['name'];
  $prx_vnt = $_POST['prx_vnt'];


  $sql_6 = 'select * from pack where user_id="'.$id.'" and id='.$id_pack.'';
  $result_6 = mysqli_query($con, $sql_6);
  $row_6 = $result_6->fetch_assoc();
  $dataz = $row_6['video_count'];
  $dataa = $row_6['model_count'];

  function random_string($length) {
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
  $rand =  random_string(10);
  $reference = "MBO".$rand;

  if ($dataz <= 0) {
        header('location:vidio_decs.php?errr=video');
  }else{
  $con->query("INSERT INTO vidio (reference,prx_vnt,country, Plink, imgs, note, Voixoff, langue, audiance, offres, date, user_id, name_user,id_pack) 
  VALUES ('$reference','$prx_vnt','$country', '$Plink', '$name', '$note', '$Voixoff', '$langue', '$audiance', '$offres', '$date', '$id', '$namee','$id_pack')");
  $con->query("update pack set video_count =video_count -1 where user_id='".$_SESSION["user_id"]."' and  id='$id_pack' ");

  $con->query("insert into vidio_suivi(user_id,user_name,date,etat_vidio,information,reference) values('$id','$user_name','$date','pending','Vedio create by $user_name','$reference')");

  header('location: vidio_decs.php?id_pack='.$id_pack.'');
  }
  
}
if (isset($_POST['user_del'])) {
  $con->query("update user set role ='client_verifier' where id='".$_POST["idLead"]."'");
  header('location: users.php');

}
if (isset($_POST['suiii'])) {
  
  $con->query("delete from user where id='".$_POST["idLead"]."'");
  header('location: users.php');

}

if(isset($_POST['pack_dis'])){
  $type = $_POST['pack_type'];
  $price = $_POST['price'];
  $date= date("Y-m-d H:i:s");
  $post_count = 0;
  $land_count = 0;

  if($type == 'basic'){
    if($price == '720'){
      $post_count = 12;
    }elseif( $price == '1200' ){
      $post_count = 24;
    }
  }elseif($type == 'standard'){
    if( $price == '300' ){
      $land_count = 1;
    }elseif( $price == '750' ){
      $land_count = 3;
    }elseif( $price == '2000' ){
      $land_count = 10;
    }
  }

  if($_SESSION["balance"] < intval($price)){
    header('location:design_pack.php?err=balance');
  }else{
    $con->query("INSERT INTO `pack_dis`( `type`, `price`, `post_count`, `land_count`, `user_id`, `user_name`,date) VALUES ('".$type."','".$price."','".$post_count."','".$land_count."','".$id."','".$user_name."','$date')");
    $con->query("update user set balance = balance - '$price' where id = '$id'");

    function random_string($length) {
      $str = random_bytes($length);
      $str = base64_encode($str);
      $str = str_replace(["+", "/", "="], "", $str);
      $str = substr($str, 0, $length);
      return $str;
  }
    $rand =  random_string(10);
    $reference = "MBO".$rand;

    $sql_6 = 'select * from user  where id= "'.$id.'"';
    $result_6 = mysqli_query($con, $sql_6);
    $row_6 = $result_6->fetch_assoc();
    $data_6 = $row_6['name'];
    $data_7 = $row_6['role'];
    $data_66 = $row_6['id'];
    $datee= date("Y-m-d H:i:s"); 

    $con->query("insert into balance_suivi (reference,name,role,date_add,balance_add,information,user_id,type,balance_type) values('$reference','$data_6','$data_7','$datee','$price','transaction by ".$data_6."','$data_66','Design pack ".$type."','sub')");

    $_SESSION["balance"] -= $price;

    
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
  $mail->addAddress($emmmil);  //Add a recipient email  
  // reply to sender email

  //Content
  $mail->Subject = ' Pack Design ';   // email subject headings
  $mail->Body    = 'Thank you for purchasing our pack'; //email message


  // Success sent message alert
  if ($mail->send()) {
      header('location:pricing_design.php');
  } else {
      header('location:./');
  }

    header('location:pack_list_d.php?err=add');
  }
  
}

if (isset($_POST['aredd'])) {
  $Ilink = $_POST['Ilink'];
  $image = $_FILES['imgs'];
  move_uploaded_file($_FILES['imgs']["tmp_name"], "./images/".$_FILES["imgs"]["name"]);
  $name = $_FILES["imgs"]["name"];  
  $note = $_POST['note'];
  $contact = $_POST['contact'];
  $langue = $_POST['langue'];
  $offres = $_POST['offres'];
  $date= date("Y-m-d H:i:s");
  $namee = $_SESSION['name'];
  $quantite = $_POST['quantite'];
  $id_pack = $_POST['id_pack'];

  $sql_6 = 'select * from pack_dis  where user_id="'.$id.'"';
  $result_6 = mysqli_query($con, $sql_6);
  $row_6 = $result_6->fetch_assoc();
  $dataz = $row_6['post_count'];
  $dataa = $row_6['land_count'];

  function random_string($length) {
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
  $rand =  random_string(10);
  $reference = "MBO".$rand;


    if ($dataz <= 0) {
      header('location:design_desc.php?errr=post');
    }else{
    $con->query("INSERT INTO design(reference,quantite,contact ,Ilink, imgs, note, langue, offres, date, user_id, name_user,id_pack_dis) 
    VALUES ('$reference','$quantite','$contact','$Ilink','$name','$note','$langue','$offres','$date','$id','$namee','$id_pack')");
    $con->query("update pack_dis set post_count = post_count - '$quantite' where user_id = '".$_SESSION["user_id"]."' and id = '$id_pack'");
  
    $con->query("insert into design_suivi(user_id,user_name,date,etat_design,information,reference) values('$id','$user_name','$date','pending','Design create by $user_name','$reference')");



  }
  header('location: design_desc.php?id_pack='.$id_pack.'');
}

if (isset($_POST['aredde'])) {

  $Ilink = $_POST['Ilink'];
  $image = $_FILES['imgs'];
  move_uploaded_file($_FILES['imgs']["tmp_name"], "./images/".$_FILES["imgs"]["name"]);
  $name = $_FILES["imgs"]["name"];  
  $note = $_POST['note'];
  $contact = $_POST['contact'];
  $langue = $_POST['langue'];
  $offres = $_POST['offres'];
  $date= date("Y-m-d H:i:s");
  $namee = $_SESSION['name'];
  $id_pack = $_POST['id_pack'];

  $sql_6 = 'select * from pack_dis  where user_id="'.$id.'"';
  $result_6 = mysqli_query($con, $sql_6);
  $row_6 = $result_6->fetch_assoc();
  $dataz = $row_6['post_count'];
  $dataa = $row_6['land_count'];

  function random_string($length) {
    $str = random_bytes($length);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, $length);
    return $str;
}
  $rand =  random_string(10);
  $reference = "MBO".$rand;


    if ($dataz <= 0) {
      header('location:design_desc.php?errre=landing');
    }else{
    $con->query("INSERT INTO design(reference,contact ,Ilink, imgs, note, langue, offres, date, user_id, name_user,id_pack_dis) 
    VALUES ('$reference','$contact','$Ilink','$name','$note','$langue','$offres','$date','$id','$namee','$id_pack')");
    $con->query("update pack_dis set land_count =land_count -1 where user_id='".$_SESSION["user_id"]."' and  id='$id_pack'");
  }
  $con->query("insert into design_suivi(user_id,user_name,date,etat_design,information,reference) values('$id','$user_name','$date','pending','Design create by $user_name','$reference')");

  header('location: design_desc.php?id_pack='.$id_pack.'');
}

if(isset($_POST['pack_win'])){
  $type = $_POST['pack_type'];
  $price = $_POST['price'];
  $category = $_POST['category'];
  $date= date("Y-m-d H:i:s");
  

  if($_SESSION["balance"] < intval($price)){
    header('location:winning_pack.php?err=balance');
  }else{
    if($type == 'basic'){
      if($price == '450'){
        if($rolle == 'client'){
          $con->query("UPDATE user SET date = '$date' where id = '$id'");
          $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 30 DAY) where id = '$id'");
        }else{ 
           $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 30 DAY) where id = '$id'");  
          }
        }
        elseif( $price == '2400' ){
          if($rolle == 'client'){
            $con->query("UPDATE user SET date = '$date' where id = '$id'");
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 180 DAY) where id = '$id'");
          }  else{ 
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 180 DAY) where id = '$id'");  
           }      }
        elseif( $price == '3360' ){
          if($rolle == 'client'){
            $con->query("UPDATE user SET date = '$date' where id = '$id'");
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 365 DAY) where id = '$id'");
          }    else{ 
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 365 DAY) where id = '$id'");  
           }    }
    }elseif($type == 'standard'){
      if( $price == '750' ){
        if($rolle == 'client'){
          $con->query("UPDATE user SET date = '$date' where id = '$id'");
          $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 30 DAY) where id = '$id'");
        }     else{ 
          $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 30 DAY) where id = '$id'");  
         }    }
        elseif( $price == '3900' ){
          if($rolle == 'client'){
            $con->query("UPDATE user SET date = '$date' where id = '$id'");
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 180 DAY) where id = '$id'");
          }  else{ 
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 180 DAY) where id = '$id'");  
           }       
      }
        elseif( $price == '6600' ){
          if($rolle == 'client'){
            $con->query("UPDATE user SET date = '$date' where id = '$id'");
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 365 DAY) where id = '$id'");
          }       else{ 
            $con->query("UPDATE user SET date = DATE_ADD(date, INTERVAL 365 DAY) where id = '$id'");  
           }  }
        
    }
    $con->query("INSERT INTO `pack_win`( `type`, `price`, `user_id`,`user_name`,date,category) VALUES ('".$type."','".$price."','".$id."','".$user_name."','$date','$category')");
    $con->query("update user set balance = balance - '$price' where id = '$id'");
    switch($category){
      case 'all':
          $role = 'client_verifier';
          break;
      case 'MOROCCO':
          $role = 'client_verifier_M';
          break;
      case 'USA':
          $role = 'client_verifier_U';
          break;
      case 'AFRIQUA':
          $role = 'client_verifier_A';
          break;
      case 'MIDDLE_EAST':
          $role = 'client_verifier_E';
          break;
      default:
          $role = '';
  }
  if($role){
      $con->query("UPDATE user SET role = '$role' where id = '$id'");
  }

    function random_string($length) {
      $str = random_bytes($length);
      $str = base64_encode($str);
      $str = str_replace(["+", "/", "="], "", $str);
      $str = substr($str, 0, $length);
      return $str;
  }
    $rand =  random_string(10);
    $reference = "MBO".$rand;

    $sql_6 = 'select * from user  where id= "'.$id.'"';
    $result_6 = mysqli_query($con, $sql_6);
    $row_6 = $result_6->fetch_assoc();
    $data_6 = $row_6['name'];
    $data_7 = $row_6['role'];
    $data_66 = $row_6['id'];
    $datee= date("Y-m-d H:i:s"); 

    $con->query("insert into balance_suivi (reference,name,role,date_add,balance_add,information,user_id,type,balance_type) values('$reference','$data_6','$data_7','$datee','$price','transaction by ".$data_6."','$data_66','Winning product pack ".$type."','sub')");
    $_SESSION["balance"] -= $price;

    
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
  $mail->addAddress($emmmil);  //Add a recipient email  
  // reply to sender email

  //Content
  $mail->Subject = ' Pack Winnings Products ';   // email subject headings
  $mail->Body    = 'Thank you for purchasing our pack'; //email message


  // Success sent message alert
  if ($mail->send()) {
      header('location:pricing_win.php');
  } else {
      header('location:./');
  }

    header('location:index.php?err=msg');
  }
}

if(isset($_POST['pack_ads'])){
  $type = $_POST['pack_type'];
  $price = $_POST['price'];
  $date= date("Y-m-d H:i:s");
  $post_count = 0;
  $land_count = 0;

  if($type == 'basic'){
    if($price == '1000'){
      if($rolee == 'client'){
        $con->query("UPDATE user SET 	date_ads  = '$date' where id = '$id'");
        $con->query("UPDATE user SET 	date_ads  = DATE_ADD(	date_ads , INTERVAL 30 DAY) where id = '$id'");
      }else{ 
         $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 30 DAY) where id = '$id'");  
        }
      }
      elseif( $price == '2400' ){
        if($rolee == 'client'){
          $con->query("UPDATE user SET date_ads = '$date' where id = '$id'");
          $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 180 DAY) where id = '$id'");
        }  else{ 
          $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 180 DAY) where id = '$id'");  
         }     
         }
      
    }elseif($type == 'standard'){
    if( $price == '2200' ){
      if($rolee == 'client'){
        $con->query("UPDATE user SET date_ads = '$date' where id = '$id'");
        $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 30 DAY) where id = '$id'");
      }     else{ 
        $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 30 DAY) where id = '$id'");  
       }    }
      elseif( $price == '6000' ){
        if($rolee == 'client'){
          $con->query("UPDATE user SET date_ads = '$date' where id = '$id'");
          $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 180 DAY) where id = '$id'");
        }  else{ 
          $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 180 DAY) where id = '$id'");  
         }       
    }
      elseif( $price == '21600' ){
        if($rolee == 'client'){
          $con->query("UPDATE user SET date_ads = '$date' where id = '$id'");
          $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 365 DAY) where id = '$id'");
        }       else{ 
          $con->query("UPDATE user SET date_ads = DATE_ADD(date_ads, INTERVAL 365 DAY) where id = '$id'");  
         }  }
      
    }elseif($type == 'premium'){
      if( $price == '280' ){
        $page_count = 5;
      }elseif( $price == '500' ){
        $page_count = 10;
      }elseif( $price == '800' ){
        $page_count = 20;
      }
    }

  if($_SESSION["balance"] < intval($price)){
    header('location:ads_m_pack.php?err=balance');
  }else{
    $con->query("INSERT INTO `pack_ads`(`land_count`, `type`, `price`, `user_id`,`user_name`,date,category) VALUES ('".$page_count."','".$type."','".$price."','".$id."','".$user_name."','$date','$category')");
    $con->query("update user set balance = balance - '$price',role_ads = 'client_ads' where id = '$id'");
    function random_string($length) {
      $str = random_bytes($length);
      $str = base64_encode($str);
      $str = str_replace(["+", "/", "="], "", $str);
      $str = substr($str, 0, $length);
      return $str;
  }
    $rand =  random_string(10);
    $reference = "MBO".$rand;
    $sql_6 = 'select * from user  where id= "'.$id.'"';
    $result_6 = mysqli_query($con, $sql_6);
    $row_6 = $result_6->fetch_assoc();
    $data_6 = $row_6['name'];
    $data_7 = $row_6['role'];
    $data_66 = $row_6['id'];
    $datee= date("Y-m-d H:i:s"); 

    $con->query("insert into balance_suivi (reference,name,role,date_add,balance_add,information,user_id,type,balance_type) values('$reference','$data_6','$data_7','$datee','$price','transaction by ".$data_6."','$data_66','ads management pack ".$type."','sub')");

    $_SESSION["balance"] -= $price;

    
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
  $mail->addAddress($emmmil);  //Add a recipient email  
  // reply to sender email

  //Content
  $mail->Subject = ' Pack Ads Management ';   // email subject headings
  $mail->Body    = 'Thank you for purchasing our pack'; //email message


  // Success sent message alert
  if ($mail->send()) {
      header('location:pricing_ads.php');
  } else {
      header('location:./');
  }

    header('location:index.php?erro=msg');
  }
  
}


if(isset($_POST['pack_brand'])){
  $type = $_POST['pack_type'];
  $price = $_POST['price'];
  $date= date("Y-m-d H:i:s");

  if($type == 'basic'){
    if($price == '1700'){
      if($roleb == 'client'){
        $con->query("UPDATE user SET 	date_brand   = '$date' where id = '$id'");
        $con->query("UPDATE user SET 	date_brand   = DATE_ADD(	date_brand  , INTERVAL 30 DAY) where id = '$id'");
      }else{ 
         $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 30 DAY) where id = '$id'");  
        }
      }
      elseif( $price == '3900' ){
        if($roleb == 'client'){
          $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 180 DAY) where id = '$id'");
        }  else{ 
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 180 DAY) where id = '$id'");  
         }     
         }
        elseif( $price == '13200' ){
          if($roleb == 'client'){
            $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
            $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 365 DAY) where id = '$id'");
          }  else{ 
            $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 365 DAY) where id = '$id'");  
           }     
           }
      
    }elseif($type == 'standard'){
    if( $price == '2500' ){
      if($roleb == 'client'){
        $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
        $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 30 DAY) where id = '$id'");
      }     else{ 
        $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 30 DAY) where id = '$id'");  
       }    }
      elseif( $price == '6600' ){
        if($roleb == 'client'){
          $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 180 DAY) where id = '$id'");
        }  else{ 
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 180 DAY) where id = '$id'");  
         }       
    }
      elseif( $price == '22800' ){
        if($roleb == 'client'){
          $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 365 DAY) where id = '$id'");
        }       else{ 
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 365 DAY) where id = '$id'");  
         }  }
      
    }elseif($type == 'standard'){
      if( $price == '6700' ){
        if($roleb == 'client'){
          $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 30 DAY) where id = '$id'");
        }     else{ 
          $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 30 DAY) where id = '$id'");  
         }    }
        elseif( $price == '17700' ){
          if($roleb == 'client'){
            $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
            $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 180 DAY) where id = '$id'");
          }  else{ 
            $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 180 DAY) where id = '$id'");  
           }       
      }
        elseif( $price == '64800' ){
          if($roleb == 'client'){
            $con->query("UPDATE user SET date_brand  = '$date' where id = '$id'");
            $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 365 DAY) where id = '$id'");
          }       else{ 
            $con->query("UPDATE user SET date_brand  = DATE_ADD(date_brand , INTERVAL 365 DAY) where id = '$id'");  
           }  }
          }

  if($_SESSION["balance"] < intval($price)){
    header('location:branding_pack.php?err=balance');
  }else{
    $con->query("INSERT INTO `pack_brand`( `type`, `price`, `user_id`,`user_name`,date,category) VALUES ('".$type."','".$price."','".$id."','".$user_name."','$date','$category')");
    $con->query("update user set balance = balance - '$price',role_brand  = 'client_brand' where id = '$id'");
    function random_string($length) {
      $str = random_bytes($length);
      $str = base64_encode($str);
      $str = str_replace(["+", "/", "="], "", $str);
      $str = substr($str, 0, $length);
      return $str;
  }
    $rand =  random_string(10);
    $reference = "MBO".$rand;
    $sql_6 = 'select * from user  where id= "'.$id.'"';
    $result_6 = mysqli_query($con, $sql_6);
    $row_6 = $result_6->fetch_assoc();
    $data_6 = $row_6['name'];
    $data_7 = $row_6['role'];
    $data_66 = $row_6['id'];
    $datee= date("Y-m-d H:i:s"); 

    $con->query("insert into balance_suivi (reference,name,role,date_add,balance_add,information,user_id,type,balance_type) values('$reference','$data_6','$data_7','$datee','$price','transaction by ".$data_6."','$data_66','Brading pack ".$type."','sub')");

    $_SESSION["balance"] -= $price;
    
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
  $mail->addAddress($emmmil);  //Add a recipient email  
  // reply to sender email

  //Content
  $mail->Subject = ' Pack Branding ';   // email subject headings
  $mail->Body    = 'Thank you for purchasing our pack'; //email message


  // Success sent message alert
  if ($mail->send()) {
      header('location:pricing_brand.php');
  } else {
      header('location:./');
  }

    header('location:index.php?erroo=msg');
  }
  
}



if (isset($_POST['convr'])) {
  
    $sql_11 = "select *  from user where id=" . $_SESSION['user_id'] . " ";

    $result_11 = mysqli_query($con, $sql_11);
    $row_11 = $result_11->fetch_assoc();
    $role_ads= $row_11['role_ads'];
            
    if( $role_ads == "admin"){
      $sql_6 = 'select * from user  where id= "'.$_POST["idLead"].'"';
    }
    elseif($role_ads == "client_ads"){
      $sql_6 = 'select * from user  where id= "8"';
    }
    $result_6 = mysqli_query($con, $sql_6);
    $row_6 = $result_6->fetch_assoc();
    $data_6 = $row_6['name'];
    $em = $row_6['email'];
    $datee= date("Y-m-d H:i:s");
    $message = $_POST['message'];
    $image = $_FILES['image'];
    move_uploaded_file($_FILES['image']["tmp_name"], "./images/".$_FILES["image"]["name"]);
    $imageee = $_FILES["image"]["name"];  
    $con->query("insert into ads_management(image,from_user,to_user,message,user_id_from,user_id_to,date) values('$imageee','$user_name','$data_6','$message','$id',".$_POST["idLead"].",'$datee')");
    

    
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
  $mail->addAddress($em);  //Add a recipient email  
  // reply to sender email

  //Content
  $mail->Subject = ' MBO Ads Management ';   // email subject headings
  $mail->Body    = 'Hello  ' .$data_6.'  You have an update in your ads strategies make sure to check the message from your ads manager'; //email message


  // Success sent message alert
  if ($mail->send()) {
    header('location:ads_management.php?user_ads='.$_POST["idLead"].'');
  } else {
      header('location:./');
  }

    header('location:ads_management.php?user_ads='.$_POST["idLead"].'');
    
  }


if (isset($_POST['convrss'])) {
  
  $sql_11 = "select *  from user where id=" . $_SESSION['user_id'] . " ";

  $result_11 = mysqli_query($con, $sql_11);
  $row_11 = $result_11->fetch_assoc();
  $role_brand= $row_11['role_brand'];
          
  if( $role_brand == "admin"){
    $sql_6 = 'select * from user  where id= "'.$_POST["idLead"].'"';
  }
  elseif($role_brand == "client_brand"){
    $sql_6 = 'select * from user  where id= "8"';
  }
  $result_6 = mysqli_query($con, $sql_6);
  $row_6 = $result_6->fetch_assoc();
  $data_6 = $row_6['name'];
  $datee= date("Y-m-d H:i:s");
  $message = $_POST['message'];
  $image = $_FILES['image'];
  move_uploaded_file($_FILES['image']["tmp_name"], "./images/".$_FILES["image"]["name"]);
  $imageee = $_FILES["image"]["name"];  
  $con->query("insert into branding(image,from_user,to_user,message,user_id_from,user_id_to,date) values('$imageee','$user_name','$data_6','$message','$id',".$_POST["idLead"].",'$datee')");
  
  header('location:branding.php?user_brand='.$_POST["idLead"].'');
  
}

if (isset($_POST['vedCon'])) {

  $id_pack = $_POST['id_pack'];


  $sql_11 = 'select * from pack where user_id="'.$id.'" and id='.$id_pack.'';

  $result_11 = mysqli_query($con, $sql_11);
  $row_11 = $result_11->fetch_assoc();
  $iddd= $row_11['id'];
  $datee= date("Y-m-d H:i:s");

  $con->query("update vidio set etat ='done' where id='".$_POST["idLead"]."'");
  $irf= $_POST["idref"];
  $con->query("insert into vidio_suivi(user_id,user_name,date,etat_vidio,information,reference) values('$id','$user_name','$datee','done','Vedio done by $user_name','$irf')");
  header('location: vidio_decs.php?id_pack='.$id_pack.'');

}

if (isset($_POST['vedrev'])) {

  $id_pack = $_POST['id_pack'];
  $sql_11 = 'select * from pack where user_id="'.$id.'" and id='.$id_pack.'';

  $result_11 = mysqli_query($con, $sql_11);
  $row_11 = $result_11->fetch_assoc();
  $iddd= $row_11['id'];
  $datee= date("Y-m-d H:i:s");

  $con->query("update vidio set etat ='reviewing' where id='".$_POST["idLead"]."'");
  $irf= $_POST["idref"];
  $con->query("insert into vidio_suivi(user_id,user_name,date,etat_vidio,information,reference) values('$id','$user_name','$datee','reviewing','Vedio reviewing by $user_name','$irf')");
  header('location: vidio_decs.php?id_pack='.$id_pack.'');

}

if (isset($_POST['vedconR'])) {

  $id_pack = $_POST['id_pack'];
  $sql_11 = 'select * from pack where user_id="'.$id.'" and id='.$id_pack.'';

  $result_11 = mysqli_query($con, $sql_11);
  $row_11 = $result_11->fetch_assoc();
  $iddd= $row_11['id'];
  $datee= date("Y-m-d H:i:s");

  $con->query("update vidio set etat ='final' where id='".$_POST["idLead"]."'");
  $irf= $_POST["idref"];
  $con->query("insert into vidio_suivi(user_id,user_name,date,etat_vidio,information,reference) values('$id','$user_name','$datee','final','Vedio final by $user_name','$irf')");
  header('location: vidio_decs.php?id_pack='.$id_pack.'');

}

if (isset($_POST['disCon'])) {

  $id_pack = $_POST['id_pack'];


  $sql_11 = 'select * from pack_dis where user_id="'.$id.'" and id='.$id_pack.'';

  $result_11 = mysqli_query($con, $sql_11);
  $row_11 = $result_11->fetch_assoc();
  $iddd= $row_11['id'];
  $datee= date("Y-m-d H:i:s");

  $con->query("update design set etat ='done' where id='".$_POST["idLead"]."'");
  $irf= $_POST["idref"];
  $con->query("insert into design_suivi(user_id,user_name,date,etat_design,information,reference) values('$id','$user_name','$datee','done','Design done by $user_name','$irf')");
  header('location: design_desc.php?id_pack='.$id_pack.'');

}

if (isset($_POST['disrev'])) {

  $id_pack = $_POST['id_pack'];
  $sql_11 = 'select * from pack_dis where user_id="'.$id.'" and id='.$id_pack.'';

  $result_11 = mysqli_query($con, $sql_11);
  $row_11 = $result_11->fetch_assoc();
  $iddd= $row_11['id'];
  $datee= date("Y-m-d H:i:s");

  $con->query("update design set etat ='reviewing' where id='".$_POST["idLead"]."'");
  $irf= $_POST["idref"];
  $con->query("insert into design_suivi(user_id,user_name,date,etat_design,information,reference) values('$id','$user_name','$datee','reviewing','Design reviewing by $user_name','$irf')");
  header('location: design_desc.php?id_pack='.$id_pack.'');

}

if (isset($_POST['disconR'])) {

  $id_pack = $_POST['id_pack'];
  $sql_11 = 'select * from pack_dis where user_id="'.$id.'" and id='.$id_pack.'';

  $result_11 = mysqli_query($con, $sql_11);
  $row_11 = $result_11->fetch_assoc();
  $iddd= $row_11['id'];
  $datee= date("Y-m-d H:i:s");

  $con->query("update design set etat ='final' where id='".$_POST["idLead"]."'");
  $irf= $_POST["idref"];
  $con->query("insert into design_suivi(user_id,user_name,date,etat_design,information,reference) values('$id','$user_name','$datee','final','Design final by $user_name','$irf')");
  header('location: design_desc.php?id_pack='.$id_pack.'');

}


if (isset($_POST['donw'])) {
  
  $link_drive = $_POST['link_drive'];

  $id_pack = $_POST['id_pack'];

  $con->query("update vidio set link_drive ='$link_drive' where id='".$_POST["idLead"]."'");
  header('location: pack_list_v.php?msa=done');

}


if (isset($_POST['acc'])) {
  
  $email = $_POST['email'];
  $password = $_POST['password'];
  $note = $_POST['note'];
  $datee = date("Y-m-d H:i:s");

  $id_pack = $_POST['id_pack'];

  $con->query("insert into management(email, password, note, user_id, name_user, date, id_pack_ads) values('$email', '$password', '$note', '$id', '$user_name', '$datee', '$id_pack')");

  $con->query("UPDATE pack_ads SET land_count = land_count - 1 WHERE user_id='" . $_SESSION["user_id"] . "' AND id='$id_pack'");

  header('location: ads_desc.php?id_pack=' . $id_pack);

}

//required files
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Function to generate a random verification code
function generateVerificationCode($length = 6) {
  return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),1,$length);
}


// Function to send verification email
function sendVerificationEmail($email, $code_verification) {



  $mail = new PHPMailer(true);
  
  try {
      // Server settings
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

      // Content
      $mail->isHTML(true);
      $mail->Subject = 'Resent erification code ';   // email subject headings
      $mail->Body    = 'Your verification code is: ' . $code_verification;

      $mail->send();
      return true;
  } catch (Exception $e) {
      return false;
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if(isset($_POST['resend'])) {
// Get email from session or wherever you store it
$email = $_SESSION['email'];

// Generate new verification code
$code_verification = generateVerificationCode();

// Send verification email
if(sendVerificationEmail($email, $code_verification)) {
    // Update the verification code in your database or wherever you store it
    $_SESSION['code_verification'] = $code_verification;
    $sql = "update user set code_verification='$code_verification' where email='$email'";
    $result = mysqli_query($con, $sql);
    header('location:emailverification.php?errorer=password');
  } else {
    header('location:emailverification.php?erroreer=password');
  }
}
}

