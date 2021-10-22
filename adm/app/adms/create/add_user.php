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
                <h2 class="display-4 title">Cadastrar Usuário</h2>
            </div>
            <div class="p-2">
                <a href="list_users" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['AddUser'])) {
            $empty_input = false;

            include './lib/lib_val_email.php';
            include './lib/lib_val_user_email_single.php';
            include './lib/lib_val_username.php';
            include './lib/lib_val_password.php';

            $data = array_map('trim', $data);
            $remove_val['nickname'] = $data['nickname'];
            unset($data['nickname']);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            } elseif (stristr($data['name'], '"')) {
                $empty_input = true;
                $msg = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo nome inválido!</div>';
            } elseif (!valEmail($data['email'])) {
                $empty_input = true;
            } elseif (valUserEmailSingle($data['email'])) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Este e-mail já está sendo utilizando!</div>";
            } elseif (valUserEmailSingle($data['username'])) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Este usuário já está sendo utilizando!</div>";
            } elseif (!valUsername($data['username'])) {
                $empty_input = true;
            } elseif (!valPassword($data['password'])) {
                $empty_input = true;
            }

            $data['nickname'] = $remove_val['nickname'];
            if (!$empty_input) {
                $password_encrypted = password_hash($data['password'], PASSWORD_DEFAULT);
                $query_user = "INSERT INTO adms_users (name, nickname, email, username, password, adms_sits_user_id, created) VALUES ('" . $data['name'] . "', '" . $data['nickname'] . "', '" . $data['email'] . "', '" . $data['username'] . "', '$password_encrypted', '" . $data['adms_sits_user_id'] . "', NOW())";
                mysqli_query($conn, $query_user);

                if (mysqli_insert_id($conn)) {
                    $last_id = mysqli_insert_id($conn);
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso!</div>";
                    $url_destination = URLADM . "/view_user?id=$last_id";
                    header("Location: $url_destination");
                    exit();
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Usuário não cadastrado com sucesso!</div>";
                }
            }
        }

        if (!empty($msg)) {
            echo $msg;
            $msg = "";
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <span class="msg"></span>
        <form id="add_user" method="POST" action=""> 
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name"><span class="text-danger">*</span> Nome</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Nome completo"  value="<?php
                    if (isset($data['name'])) {
                        echo $data['name'];
                    }
                    ?>" autofocus >
                </div>
                <div class="form-group col-md-6">
                    <label for="nickname">Apelido</label>
                    <input name="nickname" type="text" class="form-control" id="nickname" placeholder="Apelido" value="<?php
                    if (isset($data['nickname'])) {
                        echo $data['nickname'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="email"><span class="text-danger">*</span> E-mail</label>
                <input name="email" type="email" class="form-control" id="email" placeholder="Melhor e-mail" value="<?php
                if (isset($data['email'])) {
                    echo $data['email'];
                }
                ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username"><span class="text-danger">*</span> Usuário</label>
                    <input name="username" type="text" class="form-control" id="username" placeholder="Usuário para acessar o administrativo"  value="<?php
                    if (isset($data['username'])) {
                        echo $data['username'];
                    }
                    ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="password"><span class="text-danger">*</span> Senha</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="A senha deve ter no minimo 6 caracteres" value="<?php
                    if (isset($data['password'])) {
                        echo $data['password'];
                    }
                    ?>" onkeyup="passwordStrength()" required>
                </div>
            </div>

            <span id="msgviewStrength"></span>

            <?php
            $query_sits_users = "SELECT id, name FROM adms_sits_users ORDER BY name ASC";
            $result_sits_users = mysqli_query($conn, $query_sits_users);
            ?>
            <div class="form-group">
                <label for="adms_sits_user_id"><span class="text-danger">*</span> Situação</label>
                <select name="adms_sits_user_id" id="adms_sits_user_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php
                    while ($row_sit_user = mysqli_fetch_assoc($result_sits_users)) {
                        $select_sits_user = "";
                        if (isset($data['adms_sits_user_id']) AND ($data['adms_sits_user_id'] == $row_sit_user['id'])) {
                            $select_sits_user = "selected";
                        }
                        echo "<option value='" . $row_sit_user['id'] . "' $select_sits_user>" . $row_sit_user['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>


            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>
            
            <input type="submit" value="Cadastrar" name="AddUser" class="btn btn-outline-success btn-sm">
        </form>
    </div>
</div>