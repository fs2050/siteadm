<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    $query_conf_email = "SELECT id FROM adms_confs_emails WHERE id = $id LIMIT 1";
    $result_conf_email = mysqli_query($conn, $query_conf_email);
    if (($result_conf_email) AND ($result_conf_email->num_rows != 0)) {
        $query_del_conf_email = "DELETE FROM adms_confs_emails WHERE id = $id LIMIT 1";
        mysqli_query($conn, $query_del_conf_email);
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_confs_emails";
            header("Location: $url_destination");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_confs_emails";
            header("Location: $url_destination");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não encontrado!</div>";
        $url_destination = URLADM . "/list_confs_emails";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não encontrado!</div>";
    $url_destination = URLADM . "/list_confs_emails";
    header("Location: $url_destination");
}