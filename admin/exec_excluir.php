<?php
require_once './verifica_sessao.php';
require_once('./conectar.php');

$id_show = $_POST['id_show'];
$imagem = '../fotos/' . $id_show . '.jpg';

if (file_exists($imagem))
{
    unlink($imagem);
}

$sql = "DELETE FROM shows WHERE id_show='$id_show'";


mysqli_query($conn, $sql) or die(mysqli_error($conn));

$msg = urlencode('Show excluído com sucesso!');

header("Location: ./form_excluir.php?retorno=$msg");
exit();
?>
