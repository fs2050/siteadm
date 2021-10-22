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
                <h2 class="display-4 title">Visualizar a Cor</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="list_colors" class="btn btn-outline-info btn-sm">Listar</a>
                    <a href="<?php echo 'edit_color?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                    <a href="<?php echo 'delete_color?id=' . $id; ?>" class="btn btn-outline-danger btn-sm" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> 
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="list_colors">Listar</a>
                        <a class="dropdown-item" href="<?php echo 'edit_color?id=' . $id; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo 'delete_color?id=' . $id; ?>" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>
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
            $query_color = "SELECT name, color, created, modified
            FROM adms_colors 
            WHERE id = $id 
            LIMIT 1";
            $result_color = mysqli_query($conn, $query_color);
            if (($result_color) AND ($result_color->num_rows != 0)) {
                $row_color = mysqli_fetch_assoc($result_color);
                extract($row_color);
                echo "<dl class='row'>";
                
                echo "<dt class='col-sm-3'>ID:</dt>";
                echo "<dd class='col-sm-9'>$id</dd>";

                echo "<dt class='col-sm-3'>Nome:</dt>";
                echo "<dd class='col-sm-9'>$name</dd>";

                echo "<dt class='col-sm-3'>Cor:</dt>";
                echo "<dd class='col-sm-9'><span class='badge badge-pill badge-$color'>$color</span></dd>";

                echo "<dt class='col-sm-3'>Cadastrado:</dt>";
                echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($created)) . "</dd>";

                echo "<dt class='col-sm-3'>Editado:</dt>";
                if (!empty($modified)) {
                    echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($modified)) . "</dd>";
                }
                echo "</dl>";
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
                $url_destination = URLADM . "/list_colors";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
            $url_destination = URLADM . "/list_colors";
            header("Location: $url_destination");
        }
        ?>
    </div>
</div>