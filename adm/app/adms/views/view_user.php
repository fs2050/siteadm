<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Visualizar o Usuário</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="list_users" class="btn btn-outline-info btn-sm">Listar</a>
                    <a href="<?php echo 'edit_user?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                    <a href="<?php echo 'edit_user_password?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar Senha</a>
                    <a href="<?php echo 'delete_user?id=' . $id; ?>" class="btn btn-outline-danger btn-sm" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> 
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="list_users">Listar</a>
                        <a class="dropdown-item" href="<?php echo 'edit_user?id=' . $id; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo 'edit_user_password?id=' . $id; ?>">Editar Senha</a>
                        <a class="dropdown-item" href="<?php echo 'delete_user?id=' . $id; ?>" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>
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

        if (!empty($id)) {
            $query_user = "SELECT usr.name name_usr, usr.nickname, usr.email, usr.username, usr.image, usr.created, usr.modified,
            sit.name name_sit,
            col.color
            FROM adms_users usr
            LEFT JOIN adms_sits_users AS sit ON sit.id=usr.adms_sits_user_id
            LEFT JOIN adms_colors AS col ON col.id=sit.adms_color_id
            WHERE usr.id = $id 
            LIMIT 1";
            $result_user = mysqli_query($conn, $query_user);
            if (($result_user) AND ($result_user->num_rows != 0)) {
                $row_user = mysqli_fetch_assoc($result_user);
                extract($row_user);
                echo "<dl class='row'>";
                echo "<dt class='col-sm-3'>Imagem:</dt>";

                if (!empty($image) and (file_exists("app/adms/assets/images/users/$id/$image"))) {
                    $image = "app/adms/assets/images/users/$id/$image";
                } else {
                    $image = "app/adms/assets/images/users/icon_user.png";
                }
                ?>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="Usuário" class="img-thumbnail view-img-size">
                        <div class="edit">
                            <a href="<?php echo 'edit_user_image?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </dd>
                <?php
                echo "<dt class='col-sm-3'>ID:</dt>";
                echo "<dd class='col-sm-9'>$id</dd>";

                echo "<dt class='col-sm-3'>Nome:</dt>";
                echo "<dd class='col-sm-9'>$name_usr</dd>";

                echo "<dt class='col-sm-3'>Apelido:</dt>";
                echo "<dd class='col-sm-9'>$nickname</dd>";

                echo "<dt class='col-sm-3'>E-mail:</dt>";
                echo "<dd class='col-sm-9'>$email</dd>";

                echo "<dt class='col-sm-3'>Usuário:</dt>";
                echo "<dd class='col-sm-9'>$username</dd>";

                echo "<dt class='col-sm-3'>Situação:</dt>";
                echo "<dd class='col-sm-9'><span class='badge badge-pill badge-$color'>$name_sit</span></dd>";

                echo "<dt class='col-sm-3'>Cadastrado:</dt>";
                echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($created)) . "</dd>";

                echo "<dt class='col-sm-3'>Editado:</dt>";
                if (!empty($modified)) {
                    echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($modified)) . "</dd>";
                }
                echo "</dl>";
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
        ?>
    </div>
</div>