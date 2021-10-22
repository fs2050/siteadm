<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

$footer_exist = false;
$msg = "";

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Editar Rodapé</h2>
            </div>
            <div class="p-2">
                <a href="view_footer" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php

        $query_footer = "SELECT title_site, title_contact, phone, address, url_address, cnpj, url_cnpj, title_social_networks, txt_one_social_networks, link_one_social_networks, txt_two_social_networks, link_two_social_networks, txt_three_social_networks, link_three_social_networks, txt_four_social_networks, link_four_social_networks FROM sts_footers LIMIT 1";
        $result_footer = mysqli_query($conn, $query_footer);
        if (($result_footer) AND ($result_footer->num_rows != 0)) {
            $row_footer = mysqli_fetch_assoc($result_footer);
            //var_dump($row_sit_user);
            $footer_exist = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Rodapé não encontrado!</div>";
            $url_destination = URLADM . "/view_footer";
            header("Location: $url_destination");
        }

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['EditFooter'])) {

            $empty_input = false;

            $data = array_map('trim', $data);
            if (in_array("", $data)) {
                $empty_input = true;
                $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
            }

            if (!$empty_input) {
                $query_up_footer = "UPDATE sts_footers SET title_site = '" . $data['title_site'] . "', title_contact = '" . $data['title_contact'] . "', phone = '" . $data['phone'] . "', address = '" . $data['address'] . "', url_address = '" . $data['url_address'] . "', cnpj = '" . $data['cnpj'] . "', url_cnpj = '" . $data['url_cnpj'] . "', title_social_networks = '" . $data['title_social_networks'] . "', txt_one_social_networks = '" . $data['txt_one_social_networks'] . "', link_one_social_networks = '" . $data['link_one_social_networks'] . "', txt_two_social_networks = '" . $data['txt_two_social_networks'] . "', link_two_social_networks = '" . $data['link_two_social_networks'] . "', txt_three_social_networks = '" . $data['txt_three_social_networks'] . "', link_three_social_networks = '" . $data['link_three_social_networks'] . "', txt_four_social_networks = '" . $data['txt_four_social_networks'] . "', link_four_social_networks = '" . $data['link_four_social_networks'] . "', modified = NOW() LIMIT 1";
                mysqli_query($conn, $query_up_footer);

                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Rodapé editado com sucesso</div>";
                    $url_destination = URLADM . "/view_footer";
                    header("Location: $url_destination");
                } else {
                    $msg = "<div class='alert alert-danger' role='alert'>Erro: Rodapé não foi editado com sucesso!</div>";
                }
            }
        }

        if ($footer_exist) {
            if (!empty($msg)) {
                echo $msg;
                $msg = "";
            }
            ?>
            <span class="msg"></span>
            <form id="edit_footer" method="POST" action="">
                <div class="form-group">
                    <label for="title_site"><span class="text-danger">*</span> Título do contato</label>
                    <input name="title_site" type="text" class="form-control" id="title_site" placeholder="Digite o título do site" value="<?php
                    if (isset($data['title_site'])) {
                        echo $data['title_site'];
                    } elseif (isset($row_footer['title_site'])) {
                        echo $row_footer['title_site'];
                    }
                    ?>" autofocus required>
                </div>

                <div class="form-group">
                    <label for="title_contact"><span class="text-danger">*</span> Título do contato</label>
                    <input name="title_contact" type="text" class="form-control" id="title_contact" placeholder="Digite o título do contato" value="<?php
                    if (isset($data['title_contact'])) {
                        echo $data['title_contact'];
                    } elseif (isset($row_footer['title_contact'])) {
                        echo $row_footer['title_contact'];
                    }
                    ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone"><span class="text-danger">*</span> Telefone</label> 
                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Digite o telefone" value="<?php
                    if (isset($data['phone'])) {
                        echo $data['phone'];
                    } elseif (isset($row_footer['phone'])) {
                        echo $row_footer['phone'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="address"><span class="text-danger">*</span> Endereço</label> 
                    <input name="address" type="text" class="form-control" id="address" placeholder="Digite o endereço" value="<?php
                    if (isset($data['address'])) {
                        echo $data['address'];
                    } elseif (isset($row_footer['address'])) {
                        echo $row_footer['address'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="url_address"><span class="text-danger">*</span> Url 1</label> 
                    <input name="url_address" type="text" class="form-control" id="url_address" placeholder="Digite a Url " value="<?php
                    if (isset($data['url_address'])) {
                        echo $data['url_address'];
                    } elseif (isset($row_footer['url_address'])) {
                        echo $row_footer['url_address'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="cnpj"><span class="text-danger">*</span> Cnpj</label> 
                    <input name="cnpj" type="text" class="form-control" id="cnpj" placeholder="Digite o cnpj" value="<?php
                    if (isset($data['cnpj'])) {
                        echo $data['cnpj'];
                    } elseif (isset($row_footer['cnpj'])) {
                        echo $row_footer['cnpj'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="url_cnpj"><span class="text-danger">*</span> Url 2</label> 
                    <input name="url_cnpj" type="text" class="form-control" id="url_cnpj" placeholder="Digite a url do cnpj" value="<?php
                    if (isset($data['url_cnpj'])) {
                        echo $data['url_cnpj'];
                    } elseif (isset($row_footer['url_cnpj'])) {
                        echo $row_footer['url_cnpj'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="title_social_networks"><span class="text-danger">*</span> Título rede social</label> 
                    <input name="title_social_networks" type="text" class="form-control" id="title_social_networks" placeholder="Título rede social" value="<?php
                    if (isset($data['title_social_networks'])) {
                        echo $data['title_social_networks'];
                    } elseif (isset($row_footer['title_social_networks'])) {
                        echo $row_footer['title_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="txt_one_social_networks"><span class="text-danger">*</span> Título rede social 1</label> 
                    <input name="txt_one_social_networks" type="text" class="form-control" id="txt_one_social_networks" placeholder="Título rede social 1" value="<?php
                    if (isset($data['txt_one_social_networks'])) {
                        echo $data['txt_one_social_networks'];
                    } elseif (isset($row_footer['txt_one_social_networks'])) {
                        echo $row_footer['txt_one_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="link_one_social_networks"><span class="text-danger">*</span> Link rede social 1</label> 
                    <input name="link_one_social_networks" type="text" class="form-control" id="link_one_social_networks" placeholder="Link rede social 1" value="<?php
                    if (isset($data['link_one_social_networks'])) {
                        echo $data['link_one_social_networks'];
                    } elseif (isset($row_footer['link_one_social_networks'])) {
                        echo $row_footer['link_one_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="txt_two_social_networks"><span class="text-danger">*</span> Título rede social 2</label> 
                    <input name="txt_two_social_networks" type="text" class="form-control" id="txt_two_social_networks" placeholder="Título rede social 2" value="<?php
                    if (isset($data['txt_two_social_networks'])) {
                        echo $data['txt_two_social_networks'];
                    } elseif (isset($row_footer['txt_two_social_networks'])) {
                        echo $row_footer['txt_two_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="link_two_social_networks"><span class="text-danger">*</span> Link rede social 2</label> 
                    <input name="link_two_social_networks" type="text" class="form-control" id="link_two_social_networks" placeholder="Texto rede social 2" value="<?php
                    if (isset($data['link_two_social_networks'])) {
                        echo $data['link_two_social_networks'];
                    } elseif (isset($row_footer['link_two_social_networks'])) {
                        echo $row_footer['link_two_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="txt_three_social_networks"><span class="text-danger">*</span> Título rede social 3</label> 
                    <input name="txt_three_social_networks" type="text" class="form-control" id="txt_three_social_networks" placeholder="Título rede social 3" value="<?php
                    if (isset($data['txt_three_social_networks'])) {
                        echo $data['txt_three_social_networks'];
                    } elseif (isset($row_footer['txt_three_social_networks'])) {
                        echo $row_footer['txt_three_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="link_three_social_networks"><span class="text-danger">*</span> Link rede social 3</label> 
                    <input name="link_three_social_networks" type="text" class="form-control" id="link_three_social_networks" placeholder="Texto rede social 3" value="<?php
                    if (isset($data['link_three_social_networks'])) {
                        echo $data['link_three_social_networks'];
                    } elseif (isset($row_footer['link_three_social_networks'])) {
                        echo $row_footer['link_three_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="txt_four_social_networks"><span class="text-danger">*</span> Título rede social 4</label> 
                    <input name="txt_four_social_networks" type="text" class="form-control" id="txt_four_social_networks" placeholder="Título rede social 4" value="<?php
                    if (isset($data['txt_four_social_networks'])) {
                        echo $data['txt_four_social_networks'];
                    } elseif (isset($row_footer['txt_four_social_networks'])) {
                        echo $row_footer['txt_four_social_networks'];
                    }
                    ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="link_four_social_networks"><span class="text-danger">*</span> Link rede social 4</label> 
                    <input name="link_four_social_networks" type="text" class="form-control" id="link_four_social_networks" placeholder="Texto rede social 4" value="<?php
                    if (isset($data['link_four_social_networks'])) {
                        echo $data['link_four_social_networks'];
                    } elseif (isset($row_footer['link_four_social_networks'])) {
                        echo $row_footer['link_four_social_networks'];
                    }
                    ?>" required>
                </div>

                <p>
                    <span class="text-danger">*</span> Campo Obrigatório
                </p>
                <input type="submit" value="Salvar" name="EditFooter" class="btn btn-outline-warning btn-sm">
            </form>
        </div>    
    </div>
    <?php
}