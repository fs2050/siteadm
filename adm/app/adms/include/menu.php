<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$menu_active = "";
if ($path_page == "dashboard") {
    $menu_active = "dashboard";
} elseif (($path_page == "list_users") OR ($path_page == "view_user") OR ($path_page == "add_user") OR ($path_page == "edit_user") OR ($path_page == "edit_user_password") OR ($path_page == "edit_user_image")) {
    $menu_active = "list_users";
} elseif (($path_page == "list_sits_users") OR ($path_page == "view_sit_user") OR ($path_page == "add_sit_user") OR ($path_page == "edit_sit_user")) {
    $menu_active = "list_sits_users";
} elseif (($path_page == "list_confs_emails") OR ($path_page == "view_conf_email") OR ($path_page == "add_conf_email") OR ($path_page == "edit_conf_email")) {
    $menu_active = "list_confs_emails";
} elseif (($path_page == "list_colors") OR ($path_page == "view_color") OR ($path_page == "add_color") OR ($path_page == "edit_color")) {
    $menu_active = "list_colors";
} elseif ($path_page == "view_home") {
    $menu_active = "view_home";
} elseif (($path_page == "list_companies") OR ($path_page == "view_company") OR ($path_page == "add_company") OR ($path_page == "edit_company")) {
    $menu_active = "list_companies";
} elseif (($path_page == "view_contact") OR ($path_page == "edit_contact")) {
    $menu_active = "view_contact";
} elseif (($path_page == "list_contacts_msgs") OR ($path_page == "view_contact_msg") OR ($path_page == "add_contact_msg") OR ($path_page == "edit_contact_msg")) {
    $menu_active = "list_contacts_msgs";
} elseif (($path_page == "view_footer") OR ($path_page == "edit_footer")) {
    $menu_active = "view_footer";
}
?>
<div class="d-flex">
    <nav class="sidebar">
        <ul class="list-unstyled">
            <li class="<?php
            if ($menu_active == "dashboard") {
                echo "active";
            }
            ?>"><a href="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li>
                <a href="#submenu1" data-toggle="collapse"><i class="fas fa-user"></i> Usuário</a>
                <ul id="submenu1" class="list-unstyled collapse">
                    <li class="<?php
                    if ($menu_active == "list_users") {
                        echo "active";
                    }
                    ?>"><a href="list_users"><i class="fas fa-users"></i> Usuários</a></li>
                    <li class="<?php
                    if ($menu_active == "list_sits_users") {
                        echo "active";
                    }
                    ?>"><a href="list_sits_users"><i class="fas fa-users-cog"></i> Situação</a></li>
                </ul>
            </li>

            <li>
                <a href="#submenu2" data-toggle="collapse"><i class="fas fa-cogs"></i> Configuração</a>
                <ul id="submenu2" class="list-unstyled collapse">
                    <li class="<?php
                    if ($menu_active == "list_confs_emails") {
                        echo "active";
                    }
                    ?>"><a href="list_confs_emails"><i class="fas fa-envelope"></i> E-mail</a></li>

                    <li class="<?php
                    if ($menu_active == "list_colors") {
                        echo "active";
                    }
                    ?>"><a href="list_colors"><i class="fas fa-palette"></i> Cores</a></li>
                </ul>
            </li>

            <li>
                <a href="#submenu3" data-toggle="collapse"><i class="fas fa-globe"></i> Site</a>
                <ul id="submenu3" class="list-unstyled collapse">
                    <li class="<?php
                    if ($menu_active == "view_home") {
                        echo "active";
                    }
                    ?>"><a href="view_home"><i class="fas fa-home"></i> Home</a></li> 

                    <li class="<?php
                    if ($menu_active == "list_companies") {
                        echo "active";
                    }
                    ?>"><a href="list_companies"><i class="fas fa-building"></i> Sobre Empresa</a></li>  

                    <li class="<?php
                    if ($menu_active == "view_contact") {
                        echo "active";
                    }
                    ?>"><a href="view_contact"><i class="fas fa-id-card"></i> Contato</a></li>
                    
                    <li class="<?php
                    if ($menu_active == "list_contacts_msgs") {
                        echo "active";
                    }
                    ?>"><a href="list_contacts_msgs"><i class="fas fa-envelope"></i> Mensagens</a></li>
                    
                    <li class="<?php
                    if ($menu_active == "view_footer") {
                        echo "active";
                    }
                    ?>"><a href="view_footer"><i class="fas fa-home"></i> Rodapé</a></li>

                </ul>
            </li>

            <li><a href="sair"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
        </ul>
    </nav>

