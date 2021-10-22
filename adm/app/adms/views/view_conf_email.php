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
                <h2 class="display-4 title">Detalhes do E-mail</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="list_confs_emails" class="btn btn-outline-info btn-sm">Listar</a>
                    <a href="<?php echo 'edit_conf_email?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                    <a href="<?php echo 'delete_conf_email?id=' . $id; ?>" class="btn btn-outline-danger btn-sm" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> 
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="list_confs_emails">Listar</a>
                        <a class="dropdown-item" href="<?php echo 'edit_conf_email?id=' . $id; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo 'delete_conf_email?id=' . $id; ?>" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (!empty($id)) {
            $query_conf_email = "SELECT title, name, email, host_server, username, smtpsecure, port, created, modified
            FROM adms_confs_emails
            WHERE id = $id 
            LIMIT 1";
            $result_conf_email = mysqli_query($conn, $query_conf_email);
            if (($result_conf_email) AND ($result_conf_email->num_rows != 0)) {
                $row_conf_email = mysqli_fetch_assoc($result_conf_email);
                extract($row_conf_email);
                echo "<dl class='row'>";

                echo "<dt class='col-sm-3'>Título:</dt>";
                echo "<dd class='col-sm-9'>$title</dd>";
                
                echo "<dt class='col-sm-3'>Name:</dt>";
                echo "<dd class='col-sm-9'>$name</dd>";
                
                echo "<dt class='col-sm-3'>E-mail:</dt>";
                echo "<dd class='col-sm-9'>$email</dd>";
                
                echo "<dt class='col-sm-3'>Host:</dt>";
                echo "<dd class='col-sm-9'>$host_server</dd>";
                
                echo "<dt class='col-sm-3'>Usuário:</dt>";
                echo "<dd class='col-sm-9'>$username</dd>";
                
                echo "<dt class='col-sm-3'>SMTP:</dt>";
                echo "<dd class='col-sm-9'>$smtpsecure</dd>";
                
                echo "<dt class='col-sm-3'>Porta:</dt>";
                echo "<dd class='col-sm-9'>$port</dd>";
                
                echo "<dt class='col-sm-3'>Cadastrado:</dt>";
                echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($created)) . "</dd>";

                echo "<dt class='col-sm-3'>Editado:</dt>";
                if (!empty($modified)) {
                    echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($modified)) . "</dd>";
                }
                echo "</dl>";
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não encontrado!</div>";
                $url_destination = URLADM . "/list_confs_emails";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: E-mail não encontrado!</div>";
            $url_destination = URLADM . "/list_confs_emails";
            header("Location: $url_destination");
        }
        ?>
    </div>
</div>