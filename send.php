<?php
    $caixaPostalServidorEmail = 'admin@dominio.com';

    require 'phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer();

    $mail->isSMTP();
    //$mail->Host = "smtp.gmail.com";
    $mail->Host  = 'smtp.'.substr(strstr($caixaPostalServidorEmail, '@'), 1);
    //$mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@dominio.com';
    $mail->Password = 'password';
    $mail->setFrom('admin@dominio.com', 'Mask');
    $mail->AddReplyTo('contato@dominio.com', 'Mask Name');
    $mail->addAddress('contato@dominio.com');
    $txttitle = 'Título do E-mail';
    $mail->Subject = utf8_decode($txttitle);
    $mail->Body = 'Texto do corpo do e-mail';

    if ($mail->send())
        //echo "Mail sent";
?>