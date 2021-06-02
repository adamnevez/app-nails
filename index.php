<?php
define('ACCESS', true);
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
    <title>Nails App</title>
</head>
<body class="">
    <?php
    include_once './menu.php';
    ?>
    <div class="container">
        <h2 class="display-4 mt-5 mb-5">Serviços</h2>
        
        <?php
        $query_products = "SELECT id, name, price, image FROM products WHERE excluded = 'N' ORDER BY id ASC ";
        $result_products = $conn->prepare($query_products);
        $result_products->execute();
        ?>
        
        <div class="row row-cols-1 row-cols-md-3">
        
        <?php
            while ($row_product = $result_products->fetch(PDO::FETCH_ASSOC)) {
                extract($row_product);
        ?>
            <div class="col mb-4 text-center">
                <div class="card">
                    <img src='<?="./images/products/$id/$image"?>' class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title color-h3"> <?=$name;?> </h5>
                        <p class="card-text color-h3">R$ <?=number_format($price, 2, ",", ".");?> </p>
                        <a href="view-products.php?id=<?=$id;?>" class="btn btn-info">Detalhes</a>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
    </div>

    <?php include_once './footer.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>
</html>
