<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}
$company_exist = false;
$msg = "";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Sobre Empresa</h2>
            </div>
            <div class="p-2">
                <a href="list_companies" class="btn btn-outline-info btn-sm">Listar</a>
                <a href="view_company?id=<?php echo $id ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (!empty($id)) {
            $query_ab_company = "SELECT title, description, image, sts_situation_id
                    FROM sts_abouts_companies
                    WHERE id = $id 
                    LIMIT 1";
            $result_ab_company = mysqli_query($conn, $query_ab_company);
            if (($result_ab_company) AND ($result_ab_company->num_rows != 0)) {
                $row_ab_company = mysqli_fetch_assoc($result_ab_company);
                //var_dump($row_user);
                $company_exist = true;
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

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditCompany'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            //var_dump($data);

            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            $data_image = $_FILES['new_image'];

            include './lib/lib_val_ext_img.php';

            if (!empty($data_image['name'])) {
                if (!valExtensionImg($data_image['type'])) {
                    $empty_input = true;
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário selecionar uma imagem JPEG ou PNG!</div>";
                } else {
                    include './lib/lib_special_characters.php';
                    $data_image['name'] = specialCharacters($data_image['name']);
                    $col_image = "image";
                    $val_image = " = '" . $data_image['name'] . "',";
                }
            } else {
                $col_image = "";
                $val_image = "";
            }

            if (!$empty_input) {

                $query_up_ab_company = "UPDATE sts_abouts_companies SET title = '" . $data['title'] . "', description = '" . $data['description'] . "', $col_image $val_image sts_situation_id = '" . $data['sts_situation_id'] . "', modified = NOW() WHERE id = $id LIMIT 1";
                mysqli_query($conn, $query_up_ab_company);

                if (mysqli_affected_rows($conn)) {

                    if (!empty($data_image['name'])) {
                        $destiny = "app/sts/assets/images/sobre/$id/";
                        if (!empty($row_ab_company['image'])) {
                            include './lib/lib_delete_file.php';
                            deleteFile($destiny . $row_ab_company['image']);
                        }
                        //var_dump($data_image);
                        include './lib/lib_upload_img_resize.php';
                        if (uploadImgResize($data_image, $destiny, 500, 500)) {
                            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Sobre empresa editado com sucesso!</div>";
                            $url_destination = URLADM . "/view_company?id=$id";
                            header("Location: $url_destination");
                        } else {
                            $msg = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não foi editado com sucesso!</div>";
                        }
                    } else {
                        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Sobre empresa editado com sucesso!</div>";
                        $url_destination = URLADM . "/view_company?id=$id";
                        header("Location: $url_destination");
                    }
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Sobre empresa não foi não editado com sucesso!</div>";
                }
            }
        }

        if ($company_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_company" method="POST" action="" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="title"><span class="text-danger">*</span> Título</label>
                        <input name="title" type="text" class="form-control" id="title" placeholder="Título"  value="<?php
                        if (isset($data['title'])) {
                            echo $data['title'];
                        } elseif (isset($row_ab_company['title'])) {
                            echo $row_ab_company['title'];
                        }
                        ?>" autofocus required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Descrição</label>
                        <textarea name="description" class="form-control" id="description" rows="3" required><?php
                            if (isset($data['description'])) {
                                echo $data['description'];
                            } elseif (isset($row_ab_company['description'])) {
                                echo $row_ab_company['description'];
                            }
                            ?></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="image">Foto 500x500<span class="text-danger">*</span> Imagem</label>
                        <input type="file" name="new_image" class="form-control-file" id="new_image" onchange="previewImage();">
                        <?php 
                                                                
                        if ((isset($row_ab_company['image'])) AND (!empty($row_ab_company['image'])) AND (file_exists("app/sts/assets/images/sobre/$id/" . $row_ab_company['image']))) {
                            $image_old = "app/sts/assets/images/sobre/$id/" . $row_ab_company['image'];
                        } else {
                            $image_old = "app/sts/assets/images/sobre/icon_sobre.jpg";
                        }//http://localhost/celke/adm/app/sts/assets/images/sobre/7/
                        ?>
                    </div>
                    <div class="form-group col-md-6">
                        <img src="<?php echo $image_old; ?>" alt="Imagem" id="preview-image" style="width: 150px; height: 150px;" class="img-thumbnail view-img-size">
                    </div>
                </div>

                <?php
                $query_sits = "SELECT id, name FROM sts_situations ORDER BY name ASC";
                $result_sits = mysqli_query($conn, $query_sits);
                ?>
                <div class="form-group">
                    <label for="sts_situation_id"><span class="text-danger">*</span> Situação</label>
                    <select name="sts_situation_id" id="sts_situation_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php
                        while ($row_sit = mysqli_fetch_assoc($result_sits)) {
                            $select_sits = "";
                            if (isset($data['sts_situation_id']) AND ($data['sts_situation_id'] == $row_sit['id'])) {
                                $select_sits = "selected";
                            } elseif (isset($row_ab_company['sts_situation_id']) AND ($row_ab_company['sts_situation_id'] == $row_sit['id'])) {
                                $select_sits = "selected";
                            }
                            echo "<option value='" . $row_sit['id'] . "' $select_sits>" . $row_sit['name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditCompany" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}
