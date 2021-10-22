<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$conf_email = filter_input(INPUT_GET, "key", FILTER_SANITIZE_STRING);

$conf_email = str_ireplace(" ", "a", $conf_email);

if (!empty($conf_email)) {
    $query_user = "SELECT id FROM adms_users WHERE conf_email = '$conf_email' LIMIT 1";
    $result_user = mysqli_query($conn, $query_user);
    if (($result_user) AND ($result_user->num_rows != 0)) {
        $row_user = mysqli_fetch_assoc($result_user);
        extract($row_user);
        $value_conf_email = 'NULL';
        $query_up_user = "UPDATE adms_users SET conf_email = $value_conf_email, adms_sits_user_id = 1 WHERE id = $id LIMIT 1";
        mysqli_query($conn, $query_up_user);
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail confirmado com sucesso!</div>";
            $url_destination = URLADM . "/login";
            header("Location: $url_destination");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Não é possivel confirmar o e-mail, tente novamente ou entre em contato com o e-mail " . EMAILADM . "!</div>";
            $url_destination = URLADM . "/login";
            header("Location: $url_destination");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Link inválido, não é possivel confirmar o e-mail!</div>";
        $url_destination = URLADM . "/login";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Link inválido, não é possivel confirmar o e-mail!</div>";
    $url_destination = URLADM . "/login";
    header("Location: $url_destination");
}