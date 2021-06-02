<?php
define('ACCESS', true);
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

include_once './connection.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/icon/favicon.ico" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="admin/css/layout.css" integrity="" crossorigin="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">        
    <title>Nails App - Detalhes</title>
</head>
<body>
    <?php
    include_once './menu.php';

    $query_products = "SELECT id, name, description, price, image FROM products WHERE id =:id LIMIT 1";
    $result_products = $conn->prepare($query_products);
    $result_products->bindParam(':id', $id, PDO::PARAM_INT);
    $result_products->execute();
    $row_product = $result_products->fetch(PDO::FETCH_ASSOC);
    extract($row_product);

    ?>
    <div class="container">
        <h1 class="display-4 mt-5 mb-5"><?=$name?></h1>
        <div class="row">
            <div class="col-md-6">
                <img src='<?="./images/products/$id/$image"?>' class="card-img-top">
            </div>
            <div class="col-md-6">
                <p class="color-h3 font-weight-normal">Valor: R$ <?=number_format($price, 2, ",", ".");?></p>
                <p>
                    <!-- <a href="checkout-form.php?id=<?=$id;?>" class="btn btn-success">Pagar Via PicPay</a> -->
                    <a href="checkout-form.php?id=<?=$id;?>" class="btn btn-primary">Agendamento</a>
                    <a href="./" class="btn btn-info">Voltar</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-5">
                <!-- <?=$description?> -->
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>
</html>