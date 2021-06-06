<?php
session_start();
define('ACCESS', true);

include_once '../connection.php';

require 'phpmailer/includes/PHPMailer.php';
require 'phpmailer/includes/SMTP.php';
require 'phpmailer/includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$query_checkout="SELECT DISTINCT(sc.cpf),sc.first_name,sc.last_name,sc.email,
DATE_FORMAT(hs.date_weekly,'%d/%m/%Y') AS date_weekly, 
TIME_FORMAT(hs.time_weekly,'%H:%i') AS time_weekly,sc.created 
FROM schedule_client AS sc
LEFT JOIN products AS ps ON ps.id = sc.product_id
JOIN schedule_status AS ss ON ss.id_status = sc.schedule_status_id
JOIN hour_schedule AS hs ON hs.id_weekly = sc.id_weekly
WHERE sc.cpf = '".$_GET['cpf']."'
ORDER BY sc.id_client_sch DESC LIMIT 1";
$result_checkout = $conn->prepare($query_checkout);
$result_checkout->execute();
$row_checkout = $result_checkout->fetch(PDO::FETCH_ASSOC);

$email = $row_checkout['email'];
$client = $row_checkout['first_name']." ".$row_checkout['last_name'];
$data_weekly = $row_checkout['date_weekly'];
$time_weekly = $row_checkout['time_weekly'];

## post email confirm schedule ##

if(isset($_GET['cpf'])) {

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->isHTML(true);
	$mail->Host = "smtp-vip-02-farm16.kinghost.net";
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	$mail->Port = "587";
	$mail->Username = "sistema@ciesa.br";
	$mail->Password = "MS2020";
	$mail->Subject = "DETALHES DO AGENDAMENTO";
	$mail->setFrom("someguy@whatever.com");
	$mail->FromName = "Nails App";
	$mail->addAttachment('../images/logo/logonaills.jpeg');
	$msg ="<br/><span style='font-style:bold;color:#FF0000'> POR FAVOR, NÃO RESPONDA ESTE EMAIL! </span><br/>
	<br/>Prezado(a) Cliente(a): ".strtoupper($client).", sua confirmação de agendamento para 
	<b>".$data_weekly."</b> às <b>".$time_weekly."</b>.<br/>
	<br/><b>Link de agendamento:</b><a href='http://164.90.252.12/' target='_blank' title='Acesso'> http://nailsapp.com </a><br/>
	<br/>Atenciosamente,<br/><br/><b>Jess`Nails Design</b><br/>";
	$mail->Body = $msg;
	$mail->addAddress($email);

	if ($mail->send()) {
		echo "E-mail Send..!";
	} else {
		echo "Don't Send..!";
	}
	$mail->smtpClose();
	header("Refresh:5; url=index.php");
}

?>

