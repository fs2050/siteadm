<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!empty($id)) {
    $query_company = "SELECT id, image FROM sts_abouts_companies WHERE id = $id LIMIT 1";
    $result_company = mysqli_query($conn, $query_company);
    if (($result_company) AND ($result_company->num_rows != 0)) {
        $row_company = mysqli_fetch_assoc($result_company);
        $query_del_company = "DELETE FROM sts_abouts_companies WHERE id = $id LIMIT 1";
        mysqli_query($conn, $query_del_company);
        if (mysqli_affected_rows($conn)) {
            if(!empty($row_company['image'])){
                $destiny = "app/sts/assets/images/sobre/$id/";
                include './lib/lib_del_file_directory.php';
                delFileDirectory($destiny, $row_company['image']);
            }

            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Sobre empresa foi apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_companies";
            header("Location: $url_destination");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não foi apagado com sucesso!</div>";
            $url_destination = URLADM . "/list_companies";
            header("Location: $url_destination");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa foi não encontrado!</div>";
        $url_destination = URLADM . "/list_companies";
        header("Location: $url_destination");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa foi não encontrado!</div>";
    $url_destination = URLADM . "/list_companies";
    header("Location: $url_destination");
}