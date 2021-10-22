<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Perfil</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="edit_profile" class="btn btn-outline-warning btn-sm">Editar</a>
                    <a href="edit_profile_password" class="btn btn-outline-warning btn-sm">Editar Senha</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="edit_profile">Editar</a>
                        <a class="dropdown-item" href="edit_profile_password">Editar Senha</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if (isset($_SESSION['user_id'])) {
            $query_profile = "SELECT id, name, nickname, email, username, image  FROM adms_users WHERE id = " . $_SESSION['user_id'] . " LIMIT 1";
            $result_profile = mysqli_query($conn, $query_profile);
            if (($result_profile) AND ($result_profile->num_rows != 0)) {
                $row_profile = mysqli_fetch_assoc($result_profile);
                extract($row_profile);
                
                echo "<dl class='row'>";
                echo "<dt class='col-sm-3'>Imagem:</dt>";

                if (!empty($image) and (file_exists("app/adms/assets/images/users/" . $_SESSION['user_id'] . "/$image"))) {
                    $image = "app/adms/assets/images/users/" . $_SESSION['user_id'] . "/$image";
                } else {
                    $image = "app/adms/assets/images/users/icon_user.png";
                }
                ?>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="Usuário" class="img-thumbnail view-img-size">
                        <div class="edit">
                            <a href="edit_profile_image" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>
                <?php

                echo "<dt class='col-sm-3'>Nome:</dt>";
                echo "<dd class='col-sm-9'>$name</dd>";

                echo "<dt class='col-sm-3'>Apelido:</dt>";
                echo "<dd class='col-sm-9'>$nickname</dd>";

                echo "<dt class='col-sm-3'>E-mail:</dt>";
                echo "<dd class='col-sm-9'>$email</dd>";

                echo "<dt class='col-sm-3'>Usuário:</dt>";
                echo "<dd class='col-sm-9'>$username</dd>";
                echo "</dl>";
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Perfil não encontrado!</div>";
                $url_destination = URLADM . "/login";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Perfil não encontrado!</div>";
            $url_destination = URLADM . "/login";
            header("Location: $url_destination");
        }
        ?>
    </div>
</div>