<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function keyRecoverPassSingle() {
    $key_recover_pass = password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
    //$key_conf_email = 'a2ya10aFHLN07vhbWAQtOxoAnMZyaLcd6xwvSMQfWsAxfCTFQPh58S5STeo6';

    valKeyPassSingleBd($key_recover_pass);

    return $key_recover_pass;
}

function valKeyPassSingleBd(&$key_recover_pass) {
    include './config/connection.php';
    $format_a = '"!@#$%*()+{[}];:/,.\\\'<>°ºª';
    $format_b = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaa';
    $key_recover_pass = strtr($key_recover_pass, $format_a, $format_b);

    $query_user = "SELECT id FROM adms_users WHERE recover_password = '$key_recover_pass' LIMIT 1";
    $result_user = mysqli_query($conn, $query_user);
    if (($result_user) AND ($result_user->num_rows != 0)) {
        $key_recover_pass = password_hash(date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
        valKeySingleBd($key_recover_pass);
    } 
}
