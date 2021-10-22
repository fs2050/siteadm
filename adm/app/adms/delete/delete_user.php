<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    $query_user = "SELECT id, image FROM adms_users WHERE id = $id LIMIT 1";
    $result_user = mysqli_query($conn, $query_user);
    if (($result_user) AND ($result_user->num_rows != 0)) {
        $row_user = mysqli_fetch_assoc($result_user);
        $query_del_user = "DELETE FROM adms_users WHERE id = $id LIMIT 1";
        mysqli_query($conn, $query_del_user);
        if (mysqli_affected_rows($conn)) {
            if(!empty($row_user['image'])){
                $destiny = "app/adms/assets/images/users/$id/";
                include './lib/lib_del_file_directory.php';
                delFileDirectory($destiny, $row_user['image']);
            }

            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_users";
            header("Location: $url_destination");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_users";
            header("Location: $url_destination");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
        $url_destination = URLADM . "/list_users";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Usuário não encontrado!</div>";
    $url_destination = URLADM . "/list_users";
    header("Location: $url_destination");
}