<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function valPassword($password) {
    if (stristr($password, "'")) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo senha inválido!</div>";
        return false;
    } elseif (stristr($password, '"')) {
        $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo senha inválido!</div>';
        return false;
    } elseif (stristr($password, " ")) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo senha!</div>";
        return false;
    } elseif ((strlen($password)) < 6) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter no mínimo 6 caracteres!</div>";
        return false;
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%&*()]{6,}$/', $password)) {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter letras e números!</div>";
        return false;
    }else{
        return true;
    }
}
