<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$msg = "";
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//var_dump($data);

if (!empty($data['AddNewUser'])) {
    $empty_input = false;

    $data = array_map('trim', $data);
    if (in_array("", $data)) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
    } elseif (stristr($data['name'], "'")) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo nome inválido!</div>";
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
    } elseif (stristr($data['password'], "'")) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no campo senha inválido!</div>";
    } elseif (stristr($data['password'], '"')) {
        $empty_input = true;
        $msg = '<div class="alert alert-danger" role="alert">Erro: Caracter ( " ) utilizado no campo senha inválido!</div>';
    } elseif (stristr($data['password'], " ")) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no campo senha!</div>";
    } elseif ((strlen($data['password'])) < 6) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter no mínimo 6 caracteres!</div>";
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%&*()]{6,}$/', $data['password'])) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Erro: A senha deve ter letras e números!</div>";
    }

    if (!$empty_input) {
        include './lib/lib_val_user_email_single.php';
        if (valUserEmailSingle($data['email'])) {
            $empty_input = true;
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Este e-mail já está cadastrado!</div>";
        }
    }


    if (!$empty_input) {
        $format_a = '"!@#$%*()+{[}];:,\\\'<>°ºª';
        $format_b = '                            ';
        $data['name'] = strtr($data['name'], $format_a, $format_b);

        $password_encrypted = password_hash($data['password'], PASSWORD_DEFAULT);
        include './lib/lib_conf_email_single.php';
        $conf_email= keyConfEmailSingle();
        /*$conf_email = password_hash($data['password'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);*/
        $query_user = "INSERT INTO adms_users (name, email, username, password, conf_email, created)
            VALUES ('" . $data['name'] . "', '" . $data['email'] . "', '" . $data['email'] . "', '$password_encrypted', '$conf_email', NOW())";
        mysqli_query($conn, $query_user);

        if (mysqli_insert_id($conn)) {
            $name = explode(" ", $data['name']);
            $first_name = $name[0];

            include './lib/lib_send_email.php';

            $email_data['to_email'] = $data['email'];
            $email_data['to_name'] = $first_name;

            $url = URLADM . "/login_conf_email?key=" . $conf_email;

            $email_data['subject'] = "Confirmar sua conta";
            $email_data['content_html'] = "Prezado(a) $first_name <br><br>";
            $email_data['content_html'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!<br><br>";
            $email_data['content_html'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
            $email_data['content_html'] .= "<a href='$url'>$url</a><br><br>";
            $email_data['content_html'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";

            $email_data['content_text'] = "Prezado(a) $first_name \n\n";
            $email_data['content_text'] .= "Agradecemos a sua solicitação de cadastramento em nosso site!\n\n";
            $email_data['content_text'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo ou cole o link no navegador: \n\n";
            $email_data['content_text'] .= "$url\n\n";
            $email_data['content_text'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";

            if (sendEmail($email_data, 2)) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso. Necessário acessar a caixa de e-mail para confimar o e-mail!</div>";
                $url_destination = URLADM . "/login";
                header("Location: $url_destination");
            } else {
                $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>Usuário cadastrado com sucesso. Houve erro ao enviar o e-mail de confirmação, entre em contado com " . EMAILADM . " para mais informações!</div>";
                $url_destination = URLADM . "/login";
                header("Location: $url_destination");
            }
            unset($data);
        } else {
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Cadastrado não realizado com sucesso. Tente mais tarde!</div>";
        }
    }
}
?>

<form class="form-signin" id="login_new_user" method="POST" action="">
    <div class="text-center mb-4">
        <img class="mb-4" src="app/adms/assets/images/logo/logo.png" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal text-light">Novo Usuário</h1>
    </div>
    <span class="msg"></span>
    <?php
    if (!empty($msg)) {
        echo $msg;
        unset($msg);
    }
    ?>
    
    <div class="form-label-group">
        <input type="text" name="name" id="name" class="form-control" placeholder="Digite o nome completo" value="<?php
    if (isset($data['name'])) {
        echo $data['name'];
    }
    ?>" autofocus required>
        <label for="name">Nome</label>
    </div>    
    
    <div class="form-label-group">
        <input type="text" name="email" id="email" class="form-control" placeholder="Digite o seu melhor e-mail" value="<?php
    if (isset($data['email'])) {
        echo $data['email'];
    }
    ?>" required>
        <label for="email">E-mail</label>
    </div>

    <div class="form-label-group">
        <input type="password" name="password" id="password" class="form-control" placeholder="Digite a senha" onkeyup="passwordStrength()" value="<?php
        if (isset($data['password'])) {
            echo $data['password'];
        }
    ?>" required>
        <label for="username">Senha</label>
    </div>
    <span id="msgviewStrength"></span>

    <input type="submit" name="AddNewUser" class="btn btn-lg btn-primary btn-block" value="Cadastrar">
    
    <p class="mt-2 mb-3 text-muted text-center">
        <a href="<?php echo URLADM . '/login'; ?>" class="text-decoration-none">Clique aqui</a> para acessar
    </p>
</form>
<p>
    <a href=""></a> 
</p>