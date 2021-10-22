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
                <h2 class="display-4 title">Cadastrar E-mail</h2>
            </div>
            <div class="p-2">
                <a href="list_confs_emails" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">

        <?php

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['AddEmail'])) {
            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_conf_email = "INSERT INTO adms_confs_emails (title, name, email, host_server, username, password, smtpsecure, port, created) VALUES ('" . $data['title'] . "', '" . $data['name'] . "', '" . $data['email'] . "', '" . $data['host_server'] . "', '" . $data['username'] . "', '" . $data['password'] . "', '" . $data['smtpsecure'] . "', '" . $data['port'] . "', NOW())";
                mysqli_query($conn, $query_conf_email);

                if (mysqli_insert_id($conn)) {
                    //$ultimo_id = mysqli_insert_id($conn);
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail cadastrado com sucesso!</div>";
                    $url_destination = URLADM . "/list_confs_emails";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: E-mail não cadastrado com sucesso!</div>";
                }
            }
        }

        if (!empty($msg)) {
            echo $msg;
            $msg = "";
        }
        ?>
        <span class="msg"></span>
        <form id="add_email" method="POST" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name"><span class="text-danger">*</span> Título</label>
                    <input name="title" type="text" class="form-control" id="title" placeholder="Título do E-mail" value="<?php
                    if (isset($data['title'])) {
                        echo $data['title'];
                    }
                    ?>" autofocus required>
                </div>
                <div class="form-group col-md-6">
                    <label for="name"><span class="text-danger">*</span>Nome</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Nome do usuário do e-mail" value="<?php
                    if (isset($data['name'])) {
                        echo $data['name'];
                    }
                    ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="email"><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="E-mail" value="<?php
                    if (isset($data['email'])) {
                        echo $data['email'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="host_server"><span class="text-danger">*</span>Host</label>
                    <input name="host_server" type="text" class="form-control" id="host_server" placeholder="Host para enviar o e-mail" value="<?php
                    if (isset($data['host_server'])) {
                        echo $data['host_server'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="username"><span class="text-danger">*</span>Usuário</label>
                    <input name="username" type="text" class="form-control" id="username" placeholder="Usuário do e-mail na maioria dos servidores é o próprio e-mail" value="<?php
                    if (isset($data['username'])) {
                        echo $data['username'];
                    }
                    ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="password"><span class="text-danger">*</span> Senha</label>
                    <input name="password" type="text" class="form-control" id="password" placeholder="Senha do e-mail" value="<?php
                    if (isset($data['password'])) {
                        echo $data['password'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="smtpsecure"><span class="text-danger">*</span>SMTP</label>
                    <input name="smtpsecure" type="text" class="form-control" id="smtpsecure" placeholder="SMTP do servidor" value="<?php
                    if (isset($data['smtpsecure'])) {
                        echo $data['smtpsecure'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="port"><span class="text-danger">*</span>Porta</label>
                    <input name="port" type="text" class="form-control" id="port" placeholder="Porta do servidor para enviar e-mail" value="<?php
                    if (isset($data['port'])) {
                        echo $data['port'];
                    }
                    ?>" required>
                </div>
            </div>

            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input type="submit" value="Cadastrar" name="AddEmail" class="btn btn-outline-success btn-sm">
        </form>
    </div>    
</div>