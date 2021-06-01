<?php
define('ACCESS', true);

$id_client = filter_input(INPUT_GET, "id_client", FILTER_SANITIZE_NUMBER_INT);
// $id_client = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
// $id_client = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
// $id_client = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id_client)) {
    header("Location: index.php");
    die("Erro: página encontrada!<br>");
}

include_once '../../../connection.php';
include_once '../validate.php';

$query_delete_client ="UPDATE clients SET excluded = 'S', modified_delete = NOW() WHERE id_client = ".$id_client."";
$result_client = $conn->prepare($query_delete_client);
$result_client->bindParam(':id_client', $id_client, PDO::PARAM_INT);
$result_client->execute();
$row_client = $result_client->fetch(PDO::FETCH_ASSOC);
extract($row_client); 

if ($result_client->rowCount() == 0) {
    header('Location: ../view-client.php?msg=error');
} else {
    header('Location: ../view-client.php?msg=success');        
}

?>

