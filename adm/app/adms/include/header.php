<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
?>

<nav class="navbar navbar-expand navbar-dark bg-primary">

    <a class="sidebar-toggle text-light mr-3">
        <span class="navbar-toggler-icon"></span>
    </a>

    <a class="navbar-brand" href="dashboard">Celke</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    if (((isset($_SESSION['user_image'])) AND (!empty($_SESSION['user_image']))) AND (file_exists("app/adms/assets/images/users/" . $_SESSION['user_id'] . "/" . $_SESSION['user_image']))) {
                        $image_url = "app/adms/assets/images/users/" . $_SESSION['user_id'] . "/" . $_SESSION['user_image'];
                    } else {
                        $image_url = "app/adms/assets/images/users/icon_user.png";
                    }
                    ?>
                    <img src="<?php echo $image_url; ?>" class="rounded-circle img-user"> &nbsp;<span class="d-none d-sm-inline">Usuário</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile"><i class="fas fa-user"></i> Perfil</a>
                    <a class="dropdown-item" href="sair"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>