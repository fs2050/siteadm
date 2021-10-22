<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Visualizar o Sobre Empresa</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-lg-block">
                    <a href="list_companies" class="btn btn-outline-info btn-sm">Listar</a>
                    <a href="<?php echo 'edit_company?id=' . $id; ?>" class="btn btn-outline-warning btn-sm">Editar</a>                    
                    <a href="<?php echo 'delete_company?id=' . $id; ?>" class="btn btn-outline-danger btn-sm" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> 
                </span>
                <div class="dropdown d-block d-lg-none">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <a class="dropdown-item" href="list_companies">Listar</a>
                        <a class="dropdown-item" href="<?php echo 'edit_company?id=' . $id; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo 'delete_company?id=' . $id; ?>" data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        if (!empty($id)) {
            $query_about_company = "SELECT ab_comp.id, ab_comp.title, ab_comp.description, ab_comp.image, ab_comp.sts_situation_id, ab_comp.created, ab_comp.modified,
            sit.name name_sit
            FROM sts_abouts_companies ab_comp
            LEFT JOIN sts_situations AS sit ON sit.id=ab_comp.sts_situation_id
            WHERE ab_comp.id = $id 
            LIMIT 1";
            
            $result_about_company = mysqli_query($conn, $query_about_company);
            if (($result_about_company) AND ($result_about_company->num_rows != 0)) {
                $row_about_company = mysqli_fetch_assoc($result_about_company);
                extract($row_about_company);
                //var_dump($row_about_company);
                echo "<dl class='row'>";
                echo "<dt class='col-sm-3'>Imagem:</dt>";

                if (!empty($image) and (file_exists("app/sts/assets/images/sobre/$id/$image"))) {
                    $image = "app/sts/assets/images/sobre/$id/$image";
                } else {
                    $image = "app/sts/assets/images/sobre/icon_sobre.jpg";
                }
                ?>
                <dd class="col-sm-9 mb-4">
                    <div class="img-edit">
                        <img src="<?php echo $image; ?>" alt="Sobre Empresa" class="img-thumbnail view-img-size">
                    </div>
                </dd>
                <?php
                echo "<dt class='col-sm-3'>ID:</dt>";
                echo "<dd class='col-sm-9'>$id</dd>";

                echo "<dt class='col-sm-3'>Título:</dt>";
                echo "<dd class='col-sm-9'>$title</dd>";

                echo "<dt class='col-sm-3'>Descrição:</dt>";
                echo "<dd class='col-sm-9'>$description</dd>";

                echo "<dt class='col-sm-3'>Situação:</dt>";
                echo "<dd class='col-sm-9'>$name_sit</dd>";

                echo "<dt class='col-sm-3'>Cadastrado:</dt>";
                echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($created)) . "</dd>";

                echo "<dt class='col-sm-3'>Editado:</dt>";
                if (!empty($modified)) {
                    echo "<dd class='col-sm-9'>" . date("d/m/Y H:i:s", strtotime($modified)) . "</dd>";
                }
                echo "</dl>";
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não encontrado!</div>";
                $url_destination = URLADM . "/list_companies";
                header("Location: $url_destination");
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não encontrado!</div>";
            $url_destination = URLADM . "/list_companies";
            header("Location: $url_destination");
        }
        ?>
    </div>
</div>