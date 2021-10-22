<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_nickname'], $_SESSION['user_email'], $_SESSION['user_image'], $_SESSION['user_key']);

$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Deslogado com sucesso!</div>";
$url_destination = URLADM . "/login";
header("Location: $url_destination");

