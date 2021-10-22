<?php

if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

function validateAccess($path_page) {
    $page_public = ["login", "sair", "404", "login_new_user", "login_recover_password", "login_conf_email", "login_new_conf_email", "login_up_password"];

    $page_restricted = ["dashboard", "profile", "edit_profile", "edit_profile_password", "edit_profile_image", "list_users", "view_user", "add_user", "edit_user", "edit_user_password", "edit_user_image", "delete_user", "list_sits_users", "view_sit_user", "add_sit_user", "edit_sit_user", "delete_sit_user", "list_confs_emails", "view_conf_email", "add_conf_email" , "edit_conf_email", "delete_conf_email", "list_colors", "view_color", "add_color", "edit_color", "delete_color", "view_home", "edit_home_top", "edit_home_serv", "edit_home_action", "edit_home_det", "edit_home_top_image", "edit_home_action_image", "edit_home_det_image", "list_companies", "view_company", "add_company", "edit_company", "delete_company", "view_contact", "edit_contact", "list_contacts_msgs", "view_contact_msg", "add_contact_msg", "edit_contact_msg", "delete_contact_msg", "view_footer", "edit_footer" ];

    if (in_array($path_page, $page_public)) {
        return $path_page;
    } elseif (in_array($path_page, $page_restricted)) {
        if (verifyLogin()) {
            return $path_page;
        } else {            
            return "login";
        }
    } else {
        return "login";
    }
}

function verifyLogin() {
    if (isset($_SESSION['user_id']) AND isset($_SESSION['user_key'])) {
        return true;
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Para acessar a página necessário estar logado!</div>";
        return false;
    }
}
