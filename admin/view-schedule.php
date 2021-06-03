<?php
session_start();

define('ACCESS', true);
include_once '../connection.php';
include_once './validate.php';

$query_payments ="SELECT sc.id_client_sch,sc.first_name,sc.phone,
DATE_FORMAT(hs.date_weekly,'%d/%m/%Y') AS date_weekly, 
TIME_FORMAT(hs.time_weekly,'%H:%i') AS time_weekly,
ps.name,ps.price 
FROM schedule_client AS sc
LEFT JOIN products AS ps ON ps.id = sc.product_id
JOIN schedule_status AS ss ON ss.id_status = sc.schedule_status_id
JOIN hour_schedule AS hs ON hs.id_weekly = sc.id_weekly
GROUP BY sc.id_client_sch 
ORDER BY sc.id_client_sch DESC";
$result_payments = $conn->prepare($query_payments);
$result_payments->execute();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="../images/icon/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/layout.css" integrity="" crossorigin="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Nails App - Agendamentos</title>
</head>
<body>
    <?php
    include_once './menu.php';
    
    ?>
    <div class="container">
        <h2 class="display-4 mt-3 mb-3">Meus Agendamentos</h2>
        
        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        
        <hr>
        
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col" class="text-center">Agendamento</th>
                    <th scope="col" class="text-center">Servicos</th>
                    <th scope="col" class="text-center">Valor</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>

            <?php
                while ($row_payment = $result_payments->fetch(PDO::FETCH_ASSOC)) {
                    extract($row_payment);    
            ?>
                <tr>
                    <th><?=$id_client_sch?></th>
                    <td><?=strtoupper($first_name)?></td>
                    <td><?=$phone?></td>
                    <td><?=$date_weekly.' às '.$time_weekly?></td>
                    <td><?=$name?></td>
                    <td><?='R$ '.number_format($price,2,",",".")?></td>
                    <td class='text-center'>
                        <a href='payment-status.php?id=$id' class='btn btn-outline-primary btn-sm'>Status</a> 
                        <a href='cancel-payment.php?id=$id' class='btn btn-outline-danger btn-sm'>Cancelar</a>
                    </td>
                </tr>

            <?php } ?>

        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    
</body>
</html>
