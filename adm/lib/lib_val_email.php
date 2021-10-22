<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function valEmail($email) {
    if (stristr($email, "'")) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo e-mail inválido!</div>";
        return false;
    } elseif (stristr($email, '"')) {
        $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo e-mail inválido!</div>';
        return false;
    } elseif (stristr($email, " ")) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo e-mail!</div>";
        return false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail inválido!</div>";
        return false;
    }else{
        return true;
    }
}
