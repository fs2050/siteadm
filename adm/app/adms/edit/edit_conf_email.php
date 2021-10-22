<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$conf_email_exist = false;
$msg = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar E-mail</h2>
            </div>
            <div class="p-2">
                <a href="list_confs_emails" class="btn btn-outline-info btn-sm">Listar</a>
                <a href="view_conf_email?id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        if (!empty($id)) {
            $query_conf_email = "SELECT title, name, email, host_server, username, password, smtpsecure, port 
                    FROM adms_confs_emails
                    WHERE id = $id 
                    LIMIT 1";
            $result_conf_email = mysqli_query($conn, $query_conf_email);
            if (($result_conf_email) AND ($result_conf_email->num_rows != 0)) {
                $row_conf_email = mysqli_fetch_assoc($result_conf_email);
                //var_dump($row_user);
                $conf_email_exist = true;
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

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditEmail'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_conf_email = "UPDATE adms_confs_emails
                         SET title = '" . $data['title'] . "', 
                         name = '" . $data['name'] . "', 
                         email = '" . $data['email'] . "', 
                         host_server = '" . $data['host_server'] . "', 
                         username = '" . $data['username'] . "', 
                         password = '" . $data['password'] . "', 
                         smtpsecure = '" . $data['smtpsecure'] . "', 
                         port = '" . $data['port'] . "', 
                         modified = NOW() 
                         WHERE id = $id 
                         LIMIT 1";
                mysqli_query($conn, $query_up_conf_email);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['user_nickname'] = $data['nickname'];
                    $_SESSION['user_email'] = $data['email'];

                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>E-mail editado com sucesso!</div>";
                    $url_destination = URLADM . "/list_confs_emails";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: E-mail não editado com sucesso!</div>";
                }
            }
        }

        if ($conf_email_exist) {
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
                            } elseif (isset($row_conf_email['title'])) {
                                echo $row_conf_email['title'];
                            }
                            ?>" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name"><span class="text-danger">*</span>Nome</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Nome do usuário do e-mail" value="<?php
                            if (isset($data['name'])) {
                                echo $data['name'];
                            } elseif (isset($row_conf_email['name'])) {
                                echo $row_conf_email['name'];
                            }
                            ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="email"><span class="text-danger">*</span> E-mail</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="E-mail" value="<?php
                            if (isset($data['email'])) {
                                echo $data['email'];
                            } elseif (isset($row_conf_email['email'])) {
                                echo $row_conf_email['email'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="host_server"><span class="text-danger">*</span>Host</label>
                            <input name="host_server" type="text" class="form-control" id="host_server" placeholder="Host para enviar o e-mail" value="<?php
                            if (isset($data['host_server'])) {
                                echo $data['host_server'];
                            } elseif (isset($row_conf_email['host_server'])) {
                                echo $row_conf_email['host_server'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="username"><span class="text-danger">*</span>Usuário</label>
                            <input name="username" type="text" class="form-control" id="username" placeholder="Usuário do e-mail na maioria dos servidores é o próprio e-mail" value="<?php
                            if (isset($data['username'])) {
                                echo $data['username'];
                            } elseif (isset($row_conf_email['username'])) {
                                echo $row_conf_email['username'];
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
                            } elseif (isset($row_conf_email['password'])) {
                                echo $row_conf_email['password'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="smtpsecure"><span class="text-danger">*</span>SMTP</label>
                            <input name="smtpsecure" type="text" class="form-control" id="smtpsecure" placeholder="SMTP do servidor" value="<?php
                            if (isset($data['smtpsecure'])) {
                                echo $data['smtpsecure'];
                            } elseif (isset($row_conf_email['smtpsecure'])) {
                                echo $row_conf_email['smtpsecure'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="port"><span class="text-danger">*</span>Porta</label>
                            <input name="port" type="text" class="form-control" id="port" placeholder="Porta do servidor para enviar e-mail" value="<?php
                            if (isset($data['port'])) {
                                echo $data['port'];
                            } elseif (isset($row_conf_email['port'])) {
                                echo $row_conf_email['port'];
                            }
                            ?>" required>
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">*</span> Campo Obrigatório
                    </p>
                    
                    <input type="submit" value="Salvar" name="EditEmail" class="btn btn-outline-warning btn-sm">
                </form>
            </div>    
        </div>
        <?php
    }
