<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function valUsername($username) {
    if (stristr($username, " ")) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo usuário!</div>";
        return false;
    } elseif (stristr($username, '"')) {
        $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo usuário inválido!</div>';
        return false;
    } elseif (stristr($username, "'")) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo usuário inválido!</div>";
        return false;
    } else {
        return true;
    }
}
