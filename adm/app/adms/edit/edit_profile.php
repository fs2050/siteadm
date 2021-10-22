<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$user_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Perfil</h2>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        if (isset($_SESSION['user_id'])) {
            $query_profile = "SELECT name, nickname, email, username  FROM adms_users WHERE id = " . $_SESSION['user_id'] . " LIMIT 1";
            $result_profile = mysqli_query($conn, $query_profile);
            if (($result_profile) AND ($result_profile->num_rows != 0)) {
                $row_profile = mysqli_fetch_assoc($result_profile);
                //var_dump($row_profile);
                $user_exist = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Perfil não encontrado!</div>";
                $url_destination = URLADM . "/login";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Perfil não encontrado!</div>";
            $url_destination = URLADM . "/login";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($data);
        if (!empty($data['EditProfile'])) {
            $empty_input = false;
            
            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            } elseif (stristr($data['name'], '"')) {
                $empty_input = true;
                $msg = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo nome inválido!</div>';
            } elseif (stristr($data['email'], "'")) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo e-mail inválido!</div>";
            } elseif (stristr($data['email'], '"')) {
                $empty_input = true;
                $msg = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo e-mail inválido!</div>';
            } elseif (stristr($data['email'], " ")) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo e-mail!</div>";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: E-mail inválido!</div>";
            } elseif (stristr($data['username'], " ")) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo usuário!</div>";
            } elseif (stristr($data['username'], '"')) {
                $empty_input = true;
                $msg = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo usuário inválido!</div>';
            } elseif (stristr($data['username'], "'")) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo usuário inválido!</div>";
            }
            include './lib/lib_email_single_edit.php';
            if(valUserEmailSingleEdit($data['email'], $_SESSION['user_id'])){
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Este e-mail já está sendo utilizando!</div>";
            }
            if(valUserEmailSingleEdit($data['username'], $_SESSION['user_id'])){
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Este usuário já está sendo utilizando!</div>";
            }


            if (!$empty_input) {
                $query_up_profile = "UPDATE adms_users SET name = '" . $data['name'] . "', nickname = '" . $data['nickname'] . "', email = '" . $data['email'] . "', username = '" . $data['username'] . "', modified = NOW() WHERE id = " . $_SESSION['user_id'] . " LIMIT 1";
                mysqli_query($conn, $query_up_profile);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['user_name']= $data['name'];
                    $_SESSION['user_nickname'] = $data['nickname'];
                    $_SESSION['user_email'] = $data['email'];
                    
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Perfil editado com sucesso!</div>";
                    $url_destination = URLADM . "/profile";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Perfil não editado com sucesso!</div>";
                }
            }
        }

        if ($user_exist) {
            if (!empty($msg)) {
                echo $msg;
                unset($msg);
            }
            ?>
            <span class="msg"></span>
                <form id="edit_profile" method="POST" action="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name"><span class="text-danger">*</span> Nome</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Nome o completo" value="<?php
                            if (isset($data['name'])) {
                                echo $data['name'];
                            } elseif (isset($row_profile['name'])) {
                                echo $row_profile['name'];
                            }
                            ?>" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nickname">Apelido</label>
                            <input name="nickname" type="text" class="form-control" id="nickname" placeholder="Como gostaria de ser chamado" value="<?php
                            if (isset($data['nickname'])) {
                                echo $data['nickname'];
                            } elseif (isset($row_profile['nickname'])) {
                                echo $row_profile['nickname'];
                            }
                            ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email"><span class="text-danger">*</span> E-mail</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="Seu melhor e-mail" value="<?php
                            if (isset($data['email'])) {
                                echo $data['email'];
                            } elseif (isset($row_profile['email'])) {
                                echo $row_profile['email'];
                            }
                            ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="username"><span class="text-danger">*</span> Usuário</label>
                            <input name="username" type="text" class="form-control" id="username" placeholder="Usuário acessar o administrativo" value="<?php
                            if (isset($data['username'])) {
                                echo $data['username'];
                            } elseif (isset($row_profile['username'])) {
                                echo $row_profile['username'];
                            }
                            ?>" required>
                        </div>
                    </div>

                    <p>
                        <span class="text-danger">*</span> Campo Obrigatório
                    </p>

                    <input type="submit" value="Salvar" name="EditProfile" class="btn btn-outline-warning btn-sm">

                </form>
            </div>    
        </div>  
        <?php
    }
