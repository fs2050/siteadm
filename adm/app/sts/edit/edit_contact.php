<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$contact_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Detalhes do Serviço</h2>
            </div>
            <div class="p-2">
                <a href="view_contact" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        $query_contact = "SELECT title_opening_hours, opening_hours, title_address, address, address_two, phone FROM sts_contacts LIMIT 1";
        $result_contact = mysqli_query($conn, $query_contact);
        if (($result_contact) AND ($result_contact->num_rows != 0)) {
            $row_contact = mysqli_fetch_assoc($result_contact);
            //var_dump($row_sit_user);
            $contact_exist = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Contato não encontrado!</div>";
            $url_destination = URLADM . "/view_contact";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditContact'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_contact = "UPDATE sts_contacts SET title_opening_hours = '" . $data['title_opening_hours'] . "', opening_hours = '" . $data['opening_hours'] . "', title_address = '" . $data['title_address'] . "', address = '" . $data['address'] . "', address_two = '" . $data['address_two'] . "', phone = '" . $data['phone'] . "', modified = NOW() LIMIT 1";
                mysqli_query($conn, $query_up_contact);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Contato editado com sucesso</div>";
                    $url_destination = URLADM . "/view_contact";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Contato não foi editado com sucesso!</div>";
                }
            }
        }

        if ($contact_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_contact" method="POST" action="">
                <div class="form-group">
                    <label for="title_opening_hours"><span class="text-danger">*</span> Título do contato</label>
                    <input name="title_opening_hours" type="text" class="form-control" id="title_opening_hours" placeholder="Digite o título do contato" value="<?php
                    if (isset($data['title_opening_hours'])) {
                        echo $data['title_opening_hours'];
                    } elseif (isset($row_contact['title_opening_hours'])) {
                        echo $row_contact['title_opening_hours'];
                    }
                    ?>" autofocus required>
                </div>

                <div class="form-group">
                    <label for="opening_hours"><span class="text-danger">*</span> Horário</label>
                    <input name="opening_hours" type="text" class="form-control" id="opening_hours" placeholder="Digite o horário" value="<?php
                    if (isset($data['opening_hours'])) {
                        echo $data['opening_hours'];
                    } elseif (isset($row_contact['opening_hours'])) {
                        echo $row_contact['opening_hours'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="title_address"><span class="text-danger">*</span> Título do endereço</label> 
                    <input name="title_address" type="text" class="form-control" id="title_address" placeholder="Digite o horário" value="<?php
                    if (isset($data['title_address'])) {
                        echo $data['title_address'];
                    } elseif (isset($row_contact['title_address'])) {
                        echo $row_contact['title_address'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="address"><span class="text-danger">*</span> Endereço 1</label> 
                    <input name="address" type="text" class="form-control" id="address" placeholder="Digite o endereço 1" value="<?php
                    if (isset($data['address'])) {
                        echo $data['address'];
                    } elseif (isset($row_contact['address'])) {
                        echo $row_contact['address'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="address_two"><span class="text-danger">*</span> Endereço 2</label> 
                    <input name="address_two" type="text" class="form-control" id="address_two" placeholder="Digite o endereço 2" value="<?php
                    if (isset($data['address_two'])) {
                        echo $data['address_two'];
                    } elseif (isset($row_contact['address_two'])) {
                        echo $row_contact['address_two'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="phone"><span class="text-danger">*</span> Telefone</label> 
                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Digite o telefone" value="<?php
                    if (isset($data['phone'])) {
                        echo $data['phone'];
                    } elseif (isset($row_contact['phone'])) {
                        echo $row_contact['phone'];
                    }
                    ?>" required>
                </div>

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditContact" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}