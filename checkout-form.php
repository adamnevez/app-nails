<?php
ob_start();
define('ACCESS', true);

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    header("Location: index.php");
    die("Erro: página encontrada!<br>");
}

include_once './connection.php';

$query_products = "SELECT id, name, price FROM products WHERE id =:id LIMIT 1";
$result_products = $conn->prepare($query_products);
$result_products->bindParam(':id', $id, PDO::PARAM_INT);
$result_products->execute();
if ($result_products->rowCount() == 0) {
    header("Location: index.php");
    die("Erro: página encontrada!<br>");
}
$row_product = $result_products->fetch(PDO::FETCH_ASSOC);
extract($row_product);

$query_schedule ="SELECT hs.id_weekly,
DATE_FORMAT(hs.date_weekly,'%d/%m/%Y') AS date_weekly, 
DATE_FORMAT(hs.time_weekly,'%H:%m') AS time_weekly,
hs.vagancy
FROM hour_schedule AS hs 
WHERE vagancy = 'S' 
ORDER BY date_weekly DESC";
$result_schedule = $conn->prepare($query_schedule);
$result_schedule->execute();

$result_schedule_msg = $conn->prepare($query_schedule);
$result_schedule_msg->execute();
$row_msg_vagancy = $result_schedule_msg->fetch(PDO::FETCH_ASSOC);

if ($row_msg_vagancy['vagancy'] == null) {
    $msgAgendamento ="<div class='alert alert-danger' role='alert'>Estamos sem VAGAS no momento!</div>";
}   

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
    <title>Nails App - Formulario de Agendamento</title>
</head>
<body>        

    <?php
    include_once './menu.php';

    $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $msg = "";

    if (isset($data['BtnPicPay'])) {
        $empty_input = false;
        $data = array_map('trim', $data);
        if (in_array("", $data)) {
            $empty_input = true;
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher todos os campos!</div>";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $empty_input = true;
            $msg = "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher com e-mail válido!</div>";
        }

        if (!$empty_input) {

            $data['created'] = date('Y-m-d H:i:s');
            $data['due_date'] = date('Y-m-d H:i:s', strtotime($data['created'] . '+3days'));
            $due_date = date(DATE_ATOM, strtotime($data['due_date']));

            $query_schedule = "INSERT INTO schedule_client 
            (first_name, last_name, cpf, phone, email, expires_at, id_weekly, product_id, created) 
            VALUES (:first_name, :last_name, :cpf, :phone, :email, :expires_at, :id_weekly, :product_id, :created)";
            $add_schedule = $conn->prepare($query_schedule);

            $add_schedule->bindParam(":first_name", $data['first_name'], PDO::PARAM_STR);
            $add_schedule->bindParam(":last_name", $data['last_name']);
            $add_schedule->bindParam(":cpf", $data['cpf']);
            $add_schedule->bindParam(":phone", $data['phone']);
            $add_schedule->bindParam(":email", $data['email']);
            $add_schedule->bindParam(":expires_at", $data['due_date']);
            $add_schedule->bindParam(":id_weekly", $data['agendamento']);
            $add_schedule->bindParam(":product_id", $id);
            $add_schedule->bindParam(":created", $data['created']);
            $add_schedule->execute();

            if (isset($data['agendamento'])) {

                $query_up_hour_schedule ="UPDATE hour_schedule SET vagancy='N' WHERE id_weekly = ".$data['agendamento']." LIMIT 1";
                $update_hour_schedule = $conn->prepare($query_up_hour_schedule);
                $update_hour_schedule->execute();

                $query_verify_max ="SELECT MAX(id_client_sch) AS id_client_sch FROM schedule_client";
                $result_verify_max = $conn->prepare($query_verify_max);
                $result_verify_max->execute();
                $row_max = $result_verify_max->fetch(PDO::FETCH_ASSOC);

                if($row_max['id_client_sch'] != 0) {

                    $data['created'] = date('Y-m-d H:i:s');

                    $query_checkout_schedule="INSERT INTO checkout_schedule (created,id_weekly,id_client_sch) VALUES(:created,:id_weekly,:id_client_sch)";
                    $add_checkout_schedule = $conn->prepare($query_checkout_schedule);

                    $add_checkout_schedule->bindParam(":created", $data['created'],PDO::PARAM_STR);
                    $add_checkout_schedule->bindParam(":id_weekly", $data['agendamento']);
                    $add_checkout_schedule->bindParam(":id_client_sch", $row_max['id_client_sch']);
                    $add_checkout_schedule->execute();

                    if (!isset($add_checkout_schedule)) {
                        $msg = "<div class='alert alert-danger' role='alert'>Erro: Tente novamente!</div>";                                    
                    } else {
                        $msg = "<div class='alert alert-success' role='alert'>Agendamento Cadastrado com sucesso</div>";
                        header("Refresh: 1; url = index.php"); 
                    }
                } else {
                    die("Error: Procure o Administrador!");
                }
            }
        }
    }
    
    ?>
    <div class="container">
        <div class="py-5 text-center">
            <h2 class="color-h3">Formulário de Agendamento</h2>
            <p class="lead"></p>
        </div>

        <div class="row mb-5">
            <div class="col-md-8">
                <h3><?=$name?></h3>
            </div>
            <div class="col-md-4">
                <div class="mb-1 text-muted">R$ <?=number_format($price, 2, ",", ".")?></div>
            </div>
        </div>

        <hr>

        <div class="row mb-5">
            <div class="col-md-12">
                <h4 class="mb-3">Informações Pessoais</h4>
                <?php
                if (!empty($msg)) {
                    echo $msg;
                    $msg = "";
                }

                if (!empty($msgAgendamento)) {
                    echo $msgAgendamento;
                    $msgAgendamento = "";
                }

                ?>
                <form method="POST" action="checkout-form.php?id=<?=$id?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">Primeiro Nome</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Primeiro nome" value="<?php if (isset($data['first_name'])) { echo $data['first_name']; } ?>" autofocus>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="last_name">Último Nome</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Último nome" value=
                            "<?php if (isset($data['last_name'])) { echo $data['last_name']; }?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Somente número do CPF" maxlength="14" oninput="maskCPF(this)" value="<?php if (isset($data['cpf'])) { echo $data['cpf']; } ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Telefone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="(99)9999-9999" maxlength="14" oninput="maskPhone(this)" value="<?php if (isset($data['phone'])) { echo $data['phone']; } ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Digite o seu melhor e-mail" value="<?php if (isset($data['email'])) { echo $data['email']; } ?>" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">Agendamento</label>
                            <select class="form-control" name="agendamento" id="agendamento" value=
                            "<?php if (isset($data['agendamento'])) { echo $data['agendamento']; } ?>" required>
                            <option value="">Selecione Data</option>
                            <?php
                            while ($row_schedule = $result_schedule->fetch(PDO::FETCH_ASSOC)) {
                                extract($row_schedule);

                                ?>             
                                <option value="<?=$id_weekly?>"><?=$date_weekly.' - '.$time_weekly?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <a href="./" type="button" name="" class="btn btn-info btn-group-sm" value="Enviar">Voltar</a>
                <button type="submit" name="BtnPicPay" class="btn btn-primary btn-group-sm" value="Enviar">Enviar</button>

            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="js/custom.js"></script>


</body>
</html>