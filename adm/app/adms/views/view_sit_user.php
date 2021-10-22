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
                <h2 class="display-4 title">Situação para Usuários</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="list_sits_users" class="btn btn-outline-info btn-sm">Listar</a>
                    <a href="<?php echo 'edit_sit_user?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                    <a href="<?php echo 'delete_sit_user?id=' . $id; ?>" class="btn btn-outline-danger btn-sm"  data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> 
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="list_sits_users">Listar</a>
                        <a class="dropdown-item" href="<?php echo 'edit_sit_user?id=' . $id; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo 'delete_sit_user?id=' . $id; ?>" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (!empty($id)) {
            $query_sit_user = "SELECT sit.name, sit.created, sit.modified,
                col.color
                FROM adms_sits_users sit
                LEFT JOIN adms_colors AS col ON col.id=sit.adms_color_id
                WHERE sit.id = $id 
                LIMIT 1";
            $result_sit_user = mysqli_query($conn, $query_sit_user);
            if (($result_sit_user) AND ($result_sit_user->num_rows != 0)) {
                $row_sit_user = mysqli_fetch_assoc($result_sit_user);
                extract($row_sit_user);

                echo "<dl class='row'>";

                echo "<dt class='col-sm-3'>Nome:</dt>";
                echo "<dd class='col-sm-9'><span class='badge badge-pill badge-$color'>$name</span></dd>";

                echo "<dt class='col-sm-3'>Cadastrado:</dt>";
                echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($created)) . "</dd>";

                echo "<dt class='col-sm-3'>Editado:</dt>";
                if (!empty($modified)) {
                    echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($modified)) . "</dd>";
                }

                echo "</dl>";
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
                $url_destination = URLADM . "/list_sits_users";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Situação para usuário não encontrado!</div>";
            $url_destination = URLADM . "/list_sits_users";
            header("Location: $url_destination");
        }
        ?>
    </div>
</div>