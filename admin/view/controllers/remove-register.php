<?php
define('ACCESS', true);

$id_client = filter_input(INPUT_GET, "id_client", FILTER_SANITIZE_NUMBER_INT);

if (empty($id_client)) {
    header("Location: index.php");
    die("Erro: página encontrada!<br>");
}

include_once '../../../connection.php';
include_once '../validate.php';

$query_delete_client ="UPDATE clients SET excluded = 'S', modified_delete = NOW() WHERE id_client = ".$id_client."";
$delete_client = $conn->prepare($query_delete_client);
$delete_client->execute();

if ($delete_client->rowCount() == 0) {
    header('Location: ../view-client.php?msg=error');
} else {
    header('Location: ../view-client.php?msg=success');        
}

?>

