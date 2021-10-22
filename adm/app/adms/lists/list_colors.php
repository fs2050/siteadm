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

$query_colors = "SELECT id, name, color
        FROM adms_colors 
        ORDER BY id DESC
        LIMIT $start, $limit_result";
$result_colors = mysqli_query($conn, $query_colors);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 title">Listar Cores</h2>
            </div>
            <div class="p-2">
                <a href="add_color" class="btn btn-outline-success btn-sm">Cadastrar</a>
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
                        <th>Nome</th>
                        <th class="d-none d-sm-table-cell">Cor</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>

                <?php
                if (($result_colors) AND ($result_colors->num_rows != 0)) {
                    echo "<tbody>";
                    while ($row_color = mysqli_fetch_assoc($result_colors)) {
                        extract($row_color);
                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$name</td>";
                        echo "<td class='d-none d-lg-table-cell'><span class='badge badge-pill badge-$color'>$name</span></td>";
                        echo "<td class='text-center'>";
                        echo "<span class='d-none d-lg-block'>";
                        echo "<a href='view_color?id=$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                        echo "<a href='edit_color?id=$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        echo "<a href='delete_color?id=$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        echo "</span>";
                        echo "<div class='dropdown d-block d-lg-none'>";
                        echo "<button class='btn btn-outline-primary btn-sm dropdown-toggle' type='button' id='acoesListar' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Ações</button>";
                        echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='acoesListar'>";
                        echo "<a class='dropdown-item' href='view_color?id=$id'>Visualizar</a>";
                        echo "<a class='dropdown-item' href='edit_color?id=$id'>Editar</a>";
                        echo "<a class='dropdown-item' href='delete_color?id=$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";

                    //Contar a quantidade de registros no BD
                    $query_page = "SELECT COUNT(id) AS num_result FROM adms_colors";
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
                    echo "<a class='page-link' href='list_colors?page=1' tabindex='-1' aria-disabled='true'>Primeira</a>";
                    echo "</li>";

                    for ($previous_page = $page - $max_links; $previous_page <= $page - 1; $previous_page++) {
                        if ($previous_page >= 1) {
                            echo "<li class='page-item'><a class='page-link' href='list_colors?page=$previous_page'>$previous_page</a></li>";
                        }
                    }

                    echo "<li class='page-item active'>";
                    echo "<a class='page-link' href='#'>$page</a>";
                    echo "</li>";

                    for ($next_page = $page + 1; $next_page <= $page + $max_links; $next_page++) {
                        if ($next_page <= $page_quantity) {
                            echo "<li class='page-item'><a class='page-link' href='list_colors?page=$next_page'>$next_page</a></li>";
                        }
                    }
                    
                    $last_page = "";
                    if($page >= $page_quantity){
                        $last_page = "disabled";
                    }

                    echo "<li class='page-item $last_page'>";
                    echo "<a class='page-link' href='list_colors?page=$page_quantity'>Última</a>";
                    echo "</li>";

                    echo "</ul>";
                    echo "</nav>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erro: Nenhuma cor encontrada!</div>";
                }
                ?>

        </div>
    </div>
</div>