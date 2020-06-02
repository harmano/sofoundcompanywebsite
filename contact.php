<?php
session_start();
require_once 'libs/phpmailer/PHPMailerAutoload.php';

$errors =[];

if(isset($_POST['name'],$_POST['email'],$_POST['message'],$_POST['phone'],$_POST['subjectsubject'])){
    $fields=[
        'name'=>$_POST['name'],
        'email'=>$_POST['email'],
        'message'=>$_POST['message'],
        'phone'=>$_POST['phone'],
        'subjectsubject'=>$_POST['subjectsubject']
    ];
    foreach($fields as $field=>$data){
        if(empty($data)){
            $errors[]='The '.$field . ' field is required.';
        }
    }
    if(empty($errors)){
        $m=new PHPMailer;
        $m->isSMTP();
        $m->SMTPAuth=true;
        $m->Host='smtp.gmail.com';
        $m->Username='redirect.tsf.101@gmail.com';//replace with your email address
        $m->Password='hjkhkjhhkj788**773LL';//replace with your password
        $m->SMTPSecure='ssl';
        $m->Port=465;

        $m->isHTML();
        $m->Subject = $fields['subjectsubject'];
        $m->Body='From: '.$fields['name'].'<p>'.'Email: '.$fields['email'].'</p>'.'<p>'.'Phone: '.$fields['phone'].'</p>'.'<p>'.$fields['message'].'</p>';

        $m->FromName='Contact';
        $m->AddAddress('team@thesofound.com','Some one');
        if ($m->send()) {
          $referer = $_SERVER['HTTP_REFERER'];
          header("Location: $referer");
          die();
        }else{
            $errors[]="Sorry ,Could not send email.Try again later.";
        }
    }
}else{
    $errors[]= 'Something went wrong';
}
$_SESSION['errors']=$errors;
$_SESSION['fields']=$fields;
header ('Location:index.html');
