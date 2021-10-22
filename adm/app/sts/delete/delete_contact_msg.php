<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    $query_contact_msg = "SELECT id FROM sts_contacts_msgs WHERE id = $id LIMIT 1";
    $result_contact_msg = mysqli_query($conn, $query_contact_msg);
    if (($result_contact_msg) AND ($result_contact_msg->num_rows != 0)) {
        $row_contact_msg = mysqli_fetch_assoc($result_contact_msg);
        $query_del_contact_msg = "DELETE FROM sts_contacts_msgs WHERE id = $id LIMIT 1";
        mysqli_query($conn, $query_del_contact_msg);
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Mensagem de contato apagada com sucesso!</div>";
            $url_destination = URLADM . "/list_contacts_msgs";
            header("Location: $url_destination");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não apagada com sucesso!</div>";
            $url_destination = URLADM . "/list_contacts_msgs";
            header("Location: $url_destination");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada!</div>";
        $url_destination = URLADM . "/list_contacts_msgs";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
    $url_destination = URLADM . "/list_contacts_msgs";
    header("Location: $url_destination");
}