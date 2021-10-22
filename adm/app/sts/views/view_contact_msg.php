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
                <h2 class="display-4 title">Mensagem de Contato</h2>
            </div>
            <div class="mr-auto p-2">
                <h2 class="display-4 title"></h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="list_contacts_msgs" class="btn btn-outline-info btn-sm">Listar</a>
                    <a href="<?php echo 'edit_contact_msg?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                    <a href="<?php echo 'delete_contact_msg?id=' . $id; ?>" class="btn btn-outline-danger btn-sm" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="list_contacts_msgs">Listar</a>
                        <a class="dropdown-item" href="<?php echo 'edit_contact_msg?id=' . $id; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo 'delete_contact_msg?id=' . $id; ?>" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>
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

        $query_contact_msg = "SELECT cont_msg.name, cont_msg.email, cont_msg.subject, cont_msg.content, cont_msg.sts_sits_conts_msg_id, cont_msg.created, cont_msg.modified,
              sit_msg.name name_sit
              FROM sts_contacts_msgs cont_msg
              LEFT JOIN sts_sits_conts_msgs AS sit_msg ON sit_msg.id=cont_msg.sts_sits_conts_msg_id
              WHERE cont_msg.id = $id
              LIMIT 1";
        $result_contact_msg = mysqli_query($conn, $query_contact_msg);
        if (($result_contact_msg) AND ($result_contact_msg->num_rows != 0)) {
            $row_contact_msg = mysqli_fetch_assoc($result_contact_msg);
            extract($row_contact_msg);
            //var_dump($row_contact);

            echo "<dl class='row'>";

            echo "<dt class='col-sm-3'>Nome:</dt>";
            echo "<dd class='col-sm-9'>$name</dd>";

            echo "<dt class='col-sm-3'>E-mail:</dt>";
            echo "<dd class='col-sm-9'>$email</dd>";

            echo "<dt class='col-sm-3'>Assunto:</dt>";
            echo "<dd class='col-sm-9'>$subject</dd>";

            echo "<dt class='col-sm-3'>Conteúdo:</dt>";
            echo "<dd class='col-sm-9'>$content</dd>";

            echo "<dt class='col-sm-3'>Situação:</dt>";
            echo "<dd class='col-sm-9'>$name_sit</dd>";

            echo "<dt class='col-sm-3'>Cadastrado:</dt>";
            echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($created)) . "</dd>";

            echo "<dt class='col-sm-3'>Editado:</dt>";
            if (!empty($modified)) {
                echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($modified)) . "</dd>";
            }

            echo "</dl>";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada!</div>";
            $url_destination = URLADM . "/list_contacts_msgs";
            header("Location: $url_destination");
        }
        ?>
    </div>
</div>