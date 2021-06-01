<?php
session_start();
define('ACCESS', true);

include_once '../../connection.php';
include_once '../../validate.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="../../images/icon/favicon.ico" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Nails App - Clientes</title>
</head>
<body>
    <?php
    include_once 'menu.php';
    ?>
    <div class="container">
        <h2 class="display-4 mt-3 mb-3">Meus Clientes</h2>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Cadastar Cliente
        </button>
        <br/>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Informações Pessoais</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php include_once 'controllers/register-clients.php';?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        
        <hr>
        
        <?php 
        if (!empty($msg)) {
            echo $msg;
            $msg = "";
        }

        if (!isset($add_client)) {
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Tente novamente!</div>";
        } else {
            $msg = "<div class='alert alert-success' role='alert'>Cliente Cadastrado com Sucesso!</div>";        
        }
        
        echo $_GET['msg'] == 'error' ? "<div class='alert alert-danger' role='alert'>Error ao excluir!</div>" : "";
        echo $_GET['msg'] == 'success' ? "<div class='alert alert-success' role='alert'>Excluido com Sucesso!</div>" : "";

        ?>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefone</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>

            <?php
            $query_clients ="
            SELECT id_client,first_name,
            last_name,email,phone 
            FROM clients 
            WHERE excluded = 'N'
            ORDER BY id_client DESC";
            $result_clients = $conn->prepare($query_clients);
            $result_clients->execute();

            while ($row_clients = $result_clients->fetch(PDO::FETCH_ASSOC)) {
                extract($row_clients);
            ?>
                <tr>
                    <th><?=$id_client?></th>
                    <td><?=$first_name." ".$last_name?></td>
                    <td><?=$email?></td>
                    <td><?=$phone?></td>
                    <td class='text-center'>
                        <a href="controllers/edit-clients.php?id=<?=$id_client?>" type='button' class='btn btn-outline-warning btn-sm'>
                            Editar
                        </a> 
                        <a href="controllers/remove-register.php?id_client=<?=$id_client?>" type='button' class='btn btn-outline-danger btn-sm'>
                            Deletar
                        </a>
                    </td>
                </tr>

            <?php } ?>

        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../../js/custom.js"></script>

</body>
</html>

