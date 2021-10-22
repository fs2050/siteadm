<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    $query_sit_user = "SELECT id FROM adms_sits_users WHERE id = $id LIMIT 1";
    $result_sit_user = mysqli_query($conn, $query_sit_user);
    if (($result_sit_user) AND ($result_sit_user->num_rows != 0)) {
        $query_sit_del_user = "DELETE FROM adms_sits_users WHERE id = $id LIMIT 1";
        mysqli_query($conn, $query_sit_del_user);
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Situação para usuário apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_sits_users";
            header("Location: $url_destination");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_sits_users";
            header("Location: $url_destination");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
        $url_destination = URLADM . "/list_sits_users";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
    $url_destination = URLADM . "/list_sits_users";
    header("Location: $url_destination");
}