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
                <h2 class="display-4 title">Cadastrar Cor</h2>
            </div>
            <div class="p-2">
                <a href="list_colors" class="btn btn-outline-info btn-sm">Listar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['AddColor'])) {
            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_color = "INSERT INTO adms_colors (name, color, created) VALUES ('" . $data['name'] . "', '" . $data['color'] . "', NOW())";
                mysqli_query($conn, $query_color);

                if (mysqli_insert_id($conn)) {
                    $last_id = mysqli_insert_id($conn);
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cor cadastrada com sucesso!</div>";
                    $url_destination = URLADM . "/view_color?id=$last_id";
                    header("Location: $url_destination");
                    exit();
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Cor não cadastrada com sucesso!</div>";
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
        <form id="add_color" method="POST" action=""> 
            <div class="form-group">
                <label for="name"><span class="text-danger">*</span> Nome</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Nome da cor"  value="<?php
                if (isset($data['name'])) {
                    echo $data['name'];
                }
                ?>" autofocus required>
            </div>

            <div class="form-group">
                <label for="color"><span class="text-danger">*</span>Cor</label>
                <input name="color" type="text" class="form-control" id="color" placeholder="Seletor da cor do Bootstrap" value="<?php
                if (isset($data['color'])) {
                    echo $data['color'];
                }
                ?>" required>
            </div>


            <p>
                <span class="text-danger">*</span> Campo Obrigatório
            </p>

            <input type="submit" value="Cadastrar" name="AddColor" class="btn btn-outline-success btn-sm">
        </form>
    </div>
</div>