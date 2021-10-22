<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$msg = "";
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Cadastrar Mensagem de Contato</h2>
            </div>
            <div class="p-2">
                <a href="list_contacts_msgs" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['AddContactMsg'])) {
            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_contact_msg = "INSERT INTO sts_contacts_msgs (name, email, subject, content, sts_sits_conts_msg_id, created) VALUES ('" . $data['name'] . "', '" . $data['email'] . "', '" . $data['subject'] . "', '" . $data['content'] . "', '" . $data['sts_sits_conts_msg_id'] . "', NOW())";
                mysqli_query($conn, $query_contact_msg);

                if (mysqli_insert_id($conn)) {
                    //$ultimo_id = mysqli_insert_id($conn);
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Mensagem de contato cadastrado com sucesso!</div>";
                    $url_destination = URLADM . "/list_contacts_msgs";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não cadastrado com sucesso!</div>";
                }
            }
        }

        if (!empty($msg)) {
            echo $msg;
            $msg = "";
        }
        ?>
        <span class="msg"></span>
        <form id="add_contact_msg" method="POST" action="">
            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome" value="<?php
                if (isset($data['name'])) {
                    echo $data['name'];
                }
                ?>" autofocus required>
            </div>

            <div class="form-group">
                <label for="email"><span class="text-danger">*</span> E-mail</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="E-mail" value="<?php
                if (isset($data['email'])) {
                    echo $data['email'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="subject"><span class="text-danger">*</span> Assunto</label>
                <input name="subject" type="subject" class="form-control" id="subject" placeholder="Assunto" value="<?php
                if (isset($data['subject'])) {
                    echo $data['subject'];
                }
                ?>" required>
            </div>

            <div class="form-group">
                <label for="content"><span class="text-danger">*</span> Conteúdo</label>
                <textarea name="content" class="form-control" id="content" rows="3" required><?php
                    if (isset($data['content'])) {
                        echo $data['content'];
                    }
                    ?></textarea>
            </div>

            <?php
            $query_sit_msg = "SELECT id, name FROM sts_sits_conts_msgs ORDER BY name ASC";
            $result_sit_msg = mysqli_query($conn, $query_sit_msg);
            ?>
            <div class="form-group">
                <label for="sts_sits_conts_msg_id"><span class="text-danger">*</span> Situação</label>
                <select name="sts_sits_conts_msg_id" id="sts_sits_conts_msg_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php
                    while ($row_sit_msg = mysqli_fetch_assoc($result_sit_msg)) {
                        $select_sit_msg = "";
                        if (isset($data['sts_sits_conts_msg_id']) AND ($data['sts_sits_conts_msg_id'] == $row_sit_msg['id'])) {
                            $select_sit_msg = "selected";
                        }
                        echo "<option value='" . $row_sit_msg['id'] . "' $select_sit_msg>" . $row_sit_msg['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input type="submit" value="Cadastrar" name="AddContactMsg" class="btn btn-outline-success btn-sm">
        </form>
    </div>    
</div>