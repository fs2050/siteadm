<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$user_exist = false;
$msg = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Cor</h2>
            </div>
            <div class="p-2">
                <a href="list_colors" class="btn btn-outline-info btn-sm">Listar</a>
                <a href="view_color?id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">

        <?php
        if (!empty($id)) {
            $query_color = "SELECT name, color
                    FROM adms_colors
                    WHERE id = $id 
                    LIMIT 1";
            $result_color = mysqli_query($conn, $query_color);
            if (($result_color) AND ($result_color->num_rows != 0)) {
                $row_color = mysqli_fetch_assoc($result_color);
                //var_dump($row_user);
                $color_exist = true;
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
                $url_destination = URLADM . "/list_colors";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Cor não encontrada!</div>";
            $url_destination = URLADM . "/list_colors";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditColor'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_color = "UPDATE adms_colors SET name = '" . $data['name'] . "', color = '" . $data['color'] . "', modified = NOW() WHERE id = $id LIMIT 1";
                mysqli_query($conn, $query_up_color);

                if (mysqli_affected_rows($conn)) {

                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Cor editada com sucesso!</div>";
                    $url_destination = URLADM . "/view_color?id=$id";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Cor não editada com sucesso!</div>";
                }
            }
        }

        if ($color_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="add_color" method="POST" action="">
                <div class="form-group">
                    <label for="name"><span class="text-danger">*</span> Nome</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Nome da cor"  value="<?php
                    if (isset($data['name'])) {
                        echo $data['name'];
                    } elseif (isset($row_color['name'])) {
                        echo $row_color['name'];
                    }
                    ?>" autofocus required>
                </div>
                <div class="form-group">
                    <label for="color">Cor</label>
                    <input name="color" type="text" class="form-control" id="color" placeholder="Seletor da cor do Bootstrap" value="<?php
                    if (isset($data['color'])) {
                        echo $data['color'];
                    } elseif (isset($row_color['color'])) {
                        echo $row_color['color'];
                    }
                    ?>" required>
                </div>

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditColor" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}