<?php
define('ACCESS', true);

$id_client = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id_client)) {
    header("Location: index.php");
    die("Erro: página encontrada!<br>");
}

include_once '../../../connection.php';
include_once '../validate.php';

$query_clients ="SELECT id_client,first_name,last_name,cpf,phone,email 
FROM clients WHERE id_client =:id_client LIMIT 1";
$result_clients = $conn->prepare($query_clients);
$result_clients->bindParam(':id_client', $id_client, PDO::PARAM_INT);
$result_clients->execute();
$row_clients = $result_clients->fetch(PDO::FETCH_ASSOC);
extract($row_clients);

if (isset($_POST['email'])) {
    $query_up_client ="
    UPDATE clients SET first_name ='".$_POST['first_name']."',
    last_name ='".$_POST['last_name']."', cpf ='".$_POST['cpf']."', 
    phone ='".$_POST['phone']."', email ='".$_POST['email']."', modified = NOW()
    WHERE id_client = ".$id_client." LIMIT 1";
    $update_client = $conn->prepare($query_up_client);
    $update_client->execute();

    if (!isset($update_client)) {
        header("Refresh: 0; url = edit-clients.php?id=".$id_client."&msg=error");  
    } else {
        header("Refresh: 0; url = edit-clients.php?id=".$id_client."&msg=success");  
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
    include_once '../../menu.php' 
    ?>
    
    <div class="container">
        <h2 class="display-4 mt-3 mb-3">Editar Informações Cliente</h2>
        <hr>

        <?php 
        echo $_GET['msg'] == 'error' ? "<div class='alert alert-danger' role='alert'>Error ao excluir!</div>" : "";
        echo $_GET['msg'] == 'success' ? "<div class='alert alert-success' role='alert'>Informações alterada com sucesso!</div>" : "";
        ?>
        
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">Primeiro Nome</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Primeiro nome" value="<?=$first_name?>" autofocus>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Último Nome</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Último nome" value="<?=$last_name?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Somente número do CPF" maxlength="14" oninput="maskCPF(this)" value="<?=$cpf?>" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Telefone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Telefone com o DDD" maxlength="14" oninput="maskPhone(this)" value="<?=$phone?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Digite o seu melhor e-mail" value="<?=$email?>">
                    </div>
                    <div class="footer">
                        <a href="../view-client.php" type="button" name="BtnSuccess" class="btn btn-info">Voltar</a>
                        <button type="submit" name="BtnSuccess" class="btn btn-success" value="Enviar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>