<?php
if (!defined('R4F5CC')) {
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/framework">Framework</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLSITE; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLSITE . '/sobre'; ?>">Sobre Empresa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLSITE . '/contato'; ?>">Contato</a>
                </li>
            </ul>                    
        </div>
    </div>
</nav>