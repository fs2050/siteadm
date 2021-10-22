<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function keyConfEmailSingle() {
    $key_conf_email = password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
    //$key_conf_email = 'a2ya10aFHLN07vhbWAQtOxoAnMZyaLcd6xwvSMQfWsAxfCTFQPh58S5STeo6';

    valKeySingleBd($key_conf_email);

    return $key_conf_email;
}

function valKeySingleBd(&$key_conf_email) {
    include './config/connection.php';
    $format_a = '"!@#$%*()+{[}];:/,.\\\'<>°ºª';
    $format_b = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa';
    $key_conf_email = strtr($key_conf_email, $format_a, $format_b);

    $query_user = "SELECT id FROM adms_users WHERE conf_email = '$key_conf_email' LIMIT 1";
    $result_user = mysqli_query($conn, $query_user);
    if (($result_user) AND ($result_user->num_rows != 0)) {
        $key_conf_email = password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
        valKeySingleBd($key_conf_email);
    } 
}
