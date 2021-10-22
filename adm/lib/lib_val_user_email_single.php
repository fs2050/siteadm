<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function valUserEmailSingle($email) {
    include './config/connection.php';
    $query_user = "SELECT id FROM adms_users WHERE email = '$email' OR username = '$email' LIMIT 1";
    $result_user = mysqli_query($conn, $query_user);
    if (($result_user) AND ($result_user->num_rows != 0)) {
        return true;
    } else {
        return false;
    }
}
