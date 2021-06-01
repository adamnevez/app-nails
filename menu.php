<?php
if(!defined('ACCESS')){
    header("Location: /");
    die("Erro: Pagina nao encontrada!<br>");
}
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">      
        <a class="navbar-brand" href="index.php">
            <img class="" src="./images/icon/favicon.ico" width="120" height="120"> 
            <span class="text-label">Jess Design Nails</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php"></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
