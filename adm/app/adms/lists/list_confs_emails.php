<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao econtrada!<br>");
}

//Receber o número da página
$current_page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
$page = (!empty($current_page)) ? $current_page : 1;

//Setar a quantidade de itens por página
$limit_result = 40;

//Calcular o inicio da visualização
$start = ($limit_result * $page) - $limit_result;

$query_confs_emails = "SELECT id, title, name, email FROM adms_confs_emails ORDER BY id DESC LIMIT $start, $limit_result";
$result_confs_emails = mysqli_query($conn, $query_confs_emails);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Listar E-mail</h2>
            </div>
            <div class="p-2">
                <a href="add_conf_email" class="btn btn-outline-success btn-sm">Cadastrar</a>
            </div>
        </div>
        <hr class="hr-title">
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th class="d-none d-sm-table-cell">Nome</th>
                        <th class="d-none d-lg-table-cell">E-mail</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <?php
                if (($result_confs_emails) AND ($result_confs_emails->num_rows != 0)) {
                    echo "<tbody>";
                    while ($row_conf_email = mysqli_fetch_assoc($result_confs_emails)) {
                        extract($row_conf_email);
                        
                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$title</td>";
                        echo "<td class='d-none d-sm-table-cell'>$name</td>";
                        echo "<td class='d-none d-lg-table-cell'>$email</td>";
                        echo "<td class='text-center'>";
                        echo "<span class='d-none d-lg-block'>";
                        echo "<a href='view_conf_email?id=$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        echo "<a href='edit_conf_email?id=$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        echo "<a href='delete_conf_email?id=$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        echo "</span>";
                        echo "<div class='dropdown d-block d-lg-none'>";
                        echo "<button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='acoesListar' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Ações</button>";
                        echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='acoesListar'>";
                        echo "<a class='dropdown-item' href='view_conf_email?id=$id'>Visualizar</a>";
                        echo "<a class='dropdown-item' href='edit_conf_email?id=$id'>Editar</a>";
                        echo "<a class='dropdown-item' href='delete_conf_email?id=$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</tbody>";
                    echo "</table>";

                    //Contar a quantidade de registros no BD
                    $query_page = "SELECT COUNT(id) AS num_result FROM adms_confs_emails";
                    $result_page = mysqli_query($conn, $query_page);
                    $row_page = mysqli_fetch_assoc($result_page);

                    //Quantidade página
                    $page_quantity = ceil($row_page['num_result'] / $limit_result);

                    //Máximo de links
                    $max_links = 2;
                    
                    echo "<nav aria-label='paginacao'>";
                    echo "<ul class='pagination pagination-sm justify-content-center'>";
                    
                    $first_page = "";
                    if($page <= 1){
                        $first_page = "disabled";
                    }
                    echo "<li class='page-item $first_page'>";
                    echo "<a class='page-link' href='list_confs_emails?page=1' tabindex='-1' aria-disabled='true'>Primeira</a>";
                    echo "</li>";

                    for ($previous_page = $page - $max_links; $previous_page <= $page - 1; $previous_page++) {
                        if ($previous_page >= 1) {
                            echo "<li class='page-item'><a class='page-link' href='list_confs_emails?page=$previous_page'>$previous_page</a></li>";
                        }
                    }

                    echo "<li class='page-item active'>";
                    echo "<a class='page-link' href='#'>$page</a>";
                    echo "</li>";

                    for ($next_page = $page + 1; $next_page <= $page + $max_links; $next_page++) {
                        if ($next_page <= $page_quantity) {
                            echo "<li class='page-item'><a class='page-link' href='list_confs_emails?page=$next_page'>$next_page</a></li>";
                        }
                    }
                    
                    $last_page = "";
                    if($page >= $page_quantity){
                        $last_page = "disabled";
                    }

                    echo "<li class='page-item $last_page'>";
                    echo "<a class='page-link' href='list_confs_emails?page=$page_quantity'>Última</a>";
                    echo "</li>";

                    echo "</ul>";
                    echo "</nav>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erro: Nenhum e-mail encontrado!</div>";
                }
                ?>
        </div>
    </div>
</div>