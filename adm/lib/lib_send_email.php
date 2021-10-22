<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($email_data, $option_conf_email) {
    
    require './lib/vendor/autoload.php';

    $mail = new PHPMailer(true);
        
    $row_conf_email = confEmail($option_conf_email);
    
    //var_dump($row_conf_email);
    extract($row_conf_email);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $host_server;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = $smtpsecure;
        $mail->Port = $port;

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress($email_data['to_email'], $email_data['to_name']);

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $email_data['subject'];
        $mail->Body = $email_data['content_html'];
        $mail->AltBody = $email_data['content_text'];

        $mail->send();
        //echo 'E-mail enviado com sucesso!<br>';
        return true;
    } catch (Exception $e) {
        //echo "Erro: E-mail não enviado com sucesso!<br>. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function confEmail($option_conf_email){
    include './config/connection.php';
    $query_conf_email = "SELECT name, email, host_server, username, password, smtpsecure, port
            FROM adms_confs_emails
            WHERE id = $option_conf_email
            LIMIT 1";
    $result_conf_email= mysqli_query($conn, $query_conf_email);
    $row_conf_email = mysqli_fetch_assoc($result_conf_email);
    //var_dump($row_conf_email);
    return $row_conf_email;
}
