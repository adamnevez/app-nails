<?php
if(!defined('ACCESS')){
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand color-h3" href="view-schedule.php">J`Design Nails</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07"
        aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link color-h3" href="view/view-client.php">Clientes</a>
                </li>
                
                <li class="nav-item active">
                    <a class="nav-link color-h3" href="view/view-product.php">Serviços</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link color-h3" href="view/view-schedule.php">Agendamentos</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link color-h3" href="view-schedule.php"></a>
                </li>
            </ul>
        </div>
        <button type="button" class="btn btn-danger my-2 my-sm-0" id="logout" name="logout" onclick="confirmLogout()">Logout</button>
    </div>
</nav>
