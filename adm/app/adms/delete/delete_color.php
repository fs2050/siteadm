<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    $query_color = "SELECT id FROM adms_colors WHERE id = $id LIMIT 1";
    $result_color = mysqli_query($conn, $query_color);
    if (($result_color) AND ($result_color->num_rows != 0)) {
        $row_color = mysqli_fetch_assoc($result_color);
        $query_del_color = "DELETE FROM adms_colors WHERE id = $id LIMIT 1";
        mysqli_query($conn, $query_del_color);
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cor apagada com sucesso!</div>";
            $url_destination = URLADM . "/list_colors";
            header("Location: $url_destination");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não apagada com sucesso!</div>";
            $url_destination = URLADM . "/list_colors";
            header("Location: $url_destination");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
        $url_destination = URLADM . "/list_colors";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
    $url_destination = URLADM . "/list_colors";
    header("Location: $url_destination");
}