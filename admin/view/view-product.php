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
    <link rel="shortcut icon" href="images/icon/favicon.ico" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/layout.css" integrity="" crossorigin="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Nails App - Meus Serviços</title>
</head>
<body>
    <?php
    include_once 'menu.php';
    ?>
    <div class="container">
        <h2 class="display-4 mt-3 mb-3">Meus Serviços</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Cadastar Serviços
        </button>
        <br/>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Informações do Serviço</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php include_once 'controllers/register-product.php';?>
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

        if ($_GET['msg']){
            echo $msg;
            $msg = "";
        }

        ?>

        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Produtos</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Preco</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <?php
            $query_product ="SELECT id,name,price,image FROM products WHERE excluded ='N'";
            $result_product = $conn->prepare($query_product);
            $result_product->execute();
            while ($row_product = $result_product->fetch(PDO::FETCH_ASSOC)) {
                extract($row_product);
            ?>
                
            <tr>
                <th><?=$id?></th>
                <td><?=$name?></td>
                <td><?=$image?></td>
                <td>R$ <?=number_format($price,2,',','.')?></td>
                <td class='text-center'>
                    <a href="controllers/edit-services.php?id=<?=$id?>" type='button' class='btn btn-outline-warning btn-sm'>
                        Editar
                    </a> 
                    <a href="controllers/remove-register.php?id_client=<?=$id?>" type='button' class='btn btn-outline-danger btn-sm'>
                        Deletar
                    </a>
                </td>
            </tr>

            <?php } ?>

        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../../js/custom.js" type="text/javascript"></script>
    
</body>
</html>

