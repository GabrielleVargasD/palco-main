<?php
require_once './verifica_sessao.php';
require_once('./conectar.php');

$id_show = $_POST['id_show'];
$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$data_show = $_POST['data_show'];
$locals = $_POST['locals'];
$preco = $_POST['preco'];
$capacidade = $_POST['capacidade'];
$ing_disponiveis = $_POST['ing_disponiveis'];
$nome_categoria = $_POST['nome_categoria'];
$destino = '../fotos/' . $id_show . '.jpg';

if ($_FILES['imagem']['error'] != UPLOAD_ERR_NO_FILE) {

    $arquivo_temporario = $_FILES['imagem']['tmp_name'];

    if (getimagesize($arquivo_temporario) === false) {
        die('O arquivo enviado não é uma imagem valida');
    }

    if (!move_uploaded_file($arquivo_temporario, $destino)) {
        die('Não foi possível atualizar a imagem');
    }
}

$sql = "UPDATE shows SET titulo='$titulo', descricao='$descricao', data_show='$data_show', locals='$locals', preco='$preco', capacidade='$capacidade', ing_disponiveis='$ing_disponiveis', 
nome_categoria='$nome_categoria' WHERE id_show='$id_show'";

mysqli_query($conn, $sql) or die(mysqli_error($conn));


$msg = urlencode('Show atualizado com sucesso!');
header("Location: ./form_atualizar.php?retorno=$msg");
exit();
?>