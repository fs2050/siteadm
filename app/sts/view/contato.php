<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}
?>
<div class="jumbotron head-contato">
    <div class="container">
        <h1 class="text-center">Contato</h1>
    </div>            
</div>
<?php
//Variável para receber a mensagem PHP de sucesso ou erro
$msg = "";

$query_contact = "SELECT title_opening_hours, opening_hours, title_address, address, address_two, phone
        FROM sts_contacts
        LIMIT 1";
$result_contact = mysqli_query($conn, $query_contact);
while ($row_contact = mysqli_fetch_assoc($result_contact)) {
    //var_dump($row_about);
    extract($row_contact);
}

$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//var_dump($data);

if (!empty($data['SendAddMsg'])) {

    $empty_input = false;

    //Validar todos os campos
    $data = array_map('trim', $data);
    if (in_array("", $data)) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Preencha todos os campos!</div>";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $empty_input = true;
        $msg = "<div class='alert alert-danger' role='alert'>Preencha o campo com e-mail válido!</div>";
    }

    if (!$empty_input) {
        $query_cont_msg = "INSERT INTO sts_contacts_msgs (name, email, subject, content, created) VALUES ('" . $data['name'] . "', '" . $data['email'] . "', '" . $data['subject'] . "', '" . $data['content'] . "', NOW())";
        mysqli_query($conn, $query_cont_msg);

        if (mysqli_insert_id($conn)) {
            $msg = "<div class='alert alert-success' role='alert'>Mensagem de contato enviada com sucesso!</div>";
            unset($data);
        } else {
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Mensagem de contato não enviada com sucesso!</div>";
        }
    }
}
?>

<div class="jumbotron contato">
    <div class="container">
        <div class="row featurette">
            <div class="col-md-6 mb-4">
                <?php
                if(!empty($msg)){
                    echo $msg;
                    unset($msg);
                }
                ?>
                <span class="msg"></span>
                <form id="new_contacts_msgs" method="POST" action="">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Digite o nome completo" value="<?php
                        if (isset($data['name'])) {
                            echo $data['name'];
                        }
                        ?>" autofocus required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Digite o seu melhor e-mail"  value="<?php
                        if (isset($data['email'])) {
                            echo $data['email'];
                        }
                        ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Assunto</label>
                        <input type="text" name="subject" class="form-control" id="subject" placeholder="Digite o assunto da mensagem"  value="<?php
                        if (isset($data['subject'])) {
                            echo $data['subject'];
                        }
                        ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Mensagem</label>
                        <textarea name="content" class="form-control" id="content" rows="4" cols="50" placeholder="Digite o conteúdo da mensagem" required><?php
                            if (isset($data['content'])) {
                                echo $data['content'];
                            }
                            ?></textarea>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Cadastrar" name="SendAddMsg">
                </form>
            </div>
            <div class="col-md-6">
                <h3><?php echo $title_opening_hours; ?></h3>
                <p class="lead"><?php echo $opening_hours; ?></p>
                <hr>
                <address>
                    <strong><?php echo $title_address; ?></strong>
                    <?php echo $address; ?><br>
                    <?php echo $address_two; ?><br>
                    <?php echo $phone; ?><br>
                </address>
            </div>
        </div>
    </div>            
</div>


