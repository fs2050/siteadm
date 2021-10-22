<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$contact_msg = false;
$msg = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Mensagem de Contato</h2>
            </div>
            <div class="p-2">
                <a href="list_contacts_msgs" class="btn btn-outline-info btn-sm">Listar</a>
                <a href="view_contact_msg?id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        $query_contact_msg = "SELECT name, email, subject, content, sts_sits_conts_msg_id FROM sts_contacts_msgs WHERE id = $id LIMIT 1";
        $result_contact_msg = mysqli_query($conn, $query_contact_msg);
        if (($result_contact_msg) AND ($result_contact_msg->num_rows != 0)) {
            $row_contact_msg = mysqli_fetch_assoc($result_contact_msg);
            //var_dump($row_sit_user);
            $contact_msg = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não encontrada!</div>";
            $url_destination = URLADM . "/list_contacts_msgs";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditContactMsg'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_contact_msg = "UPDATE sts_contacts_msgs SET name = '" . $data['name'] . "', email = '" . $data['email'] . "', subject = '" . $data['subject'] . "', content = '" . $data['content'] . "', sts_sits_conts_msg_id = '" . $data['sts_sits_conts_msg_id'] . "', modified = NOW() WHERE id = $id LIMIT 1";
                mysqli_query($conn, $query_up_contact_msg);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Mensagem de contato editada com sucesso</div>";
                    $url_destination = URLADM . "/list_contacts_msgs";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não foi editada com sucesso!</div>";
                }
            }
        }

        if ($contact_msg) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_contact_msg" method="POST" action="">
                <div class="form-group">
                    <label for="name"><span class="text-danger">*</span> Nome</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Digite o nome" value="<?php
                        if (isset($data['name'])) {
                            echo $data['name'];
                        } elseif (isset($row_contact_msg['name'])) {
                            echo $row_contact_msg['name'];
                        }
                        ?>" autofocus required>
                </div>

                <div class="form-group">
                    <label for="email"><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="E-mail" value="<?php
                        if (isset($data['email'])) {
                            echo $data['email'];
                        } elseif (isset($row_contact_msg['email'])) {
                            echo $row_contact_msg['email'];
                        }
                        ?>" required>
                </div>

                <div class="form-group">
                    <label for="subject"><span class="text-danger">*</span> Assunto</label>
                    <input name="subject" type="subject" class="form-control" id="subject" placeholder="Assunto" value="<?php
                        if (isset($data['subject'])) {
                            echo $data['subject'];
                        } elseif (isset($row_contact_msg['subject'])) {
                            echo $row_contact_msg['subject'];
                        }
                        ?>" required>
                </div>

                <div class="form-group">
                    <label for="content"><span class="text-danger">*</span> Conteúdo</label>
                    <textarea name="content" class="form-control" id="content" rows="3" required><?php
                        if (isset($data['content'])) {
                            echo $data['content'];
                        } elseif (isset($row_contact_msg['content'])) {
                            echo $row_contact_msg['content'];
                        }?></textarea>
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
                            } elseif (isset($row_contact_msg['sts_sits_conts_msg_id']) AND ($row_contact_msg['sts_sits_conts_msg_id'] == $row_sit_msg['id'])) {
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
                <input type="submit" value="Salvar" name="EditContactMsg" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}