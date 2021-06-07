<?php
define('ACCESS', true);

$id_client = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id_client)) {
    header("Location: index.php");
    die("Erro: página encontrada!<br>");
}

include_once '../../../connection.php';
include_once '../validate.php';

$query_products ="SELECT id, name, description, price FROM products WHERE id = :id_client LIMIT 1";
$result_products = $conn->prepare($query_products);
$result_products->bindParam(':id_client', $id_client, PDO::PARAM_INT);
$result_products->execute();
$row_products = $result_products->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['nameService'])) {
    $query_up_products ="UPDATE products SET name='".$_POST['nameService']."', 
    description='".$_POST['description']."', price=".$_POST['price'].", modified=NOW()  
    WHERE id=".$id_client." LIMIT 1";
    $update_products = $conn->prepare($query_up_products);
    $update_products->execute();

    if (!isset($update_products)) {
        header("Refresh: 0; url = edit-services.php?id=".$id_client."&msg=error");
    } else {
        header("Refresh: 0; url = edit-services.php?id=".$id_client."&msg=success");       
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="images/icon/favicon.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <link rel="stylesheet" href="../../css/layout.css" integrity="" crossorigin="">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Nails App - Detalhes</title>
</head>
<body>   
    
    <?php 
    include_once './menu.php'
    ?>
    
    <div class="container">
        <h2 class="display-4 mt-3 mb-3">Editar Informações Cliente</h2>
        <hr>

        <?php 
        echo $_GET['msg'] == 'error' ? "<div class='alert alert-danger' role='alert'>Error ao alterar informações!</div>" : "";
        echo $_GET['msg'] == 'success' ? "<div class='alert alert-success' role='alert'>Informações alterada com sucesso!</div>" : "";
        ?>
        
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nameService">Nome do Serviço</label>
                            <input type="text" name="nameService" id="nameService" class="form-control" placeholder="Nome do Serviço" value="<?=$row_products['name']?>" autofocus required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Preço do Serviço</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder="Digite o valor" value=
                            "<?=number_format($row_products['price'],2,".")?>" onKeyPress="return(moeda(this,'.','.',event))" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Digite o texto de descrição do serviço" rows="3"><?=$row_products['description']?></textarea>
                    </div>
                    <div class="modal-footer">
                        <a href="../view-product.php" type="button" name="BtnSuccess" class="btn btn-info">Voltar</a>
                        <button type="submit" name="BtnSuccess" class="btn btn-success" value="Enviar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../../../js/custom.js" type="text/javascript"></script>

</body>
</html>