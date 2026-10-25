<?php
require_once './verifica_sessao.php';
require_once('./conectar.php');

$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$data_show = $_POST['data_show'];
$locals = $_POST['locals'];
$preco = $_POST['preco'];
$capacidade = $_POST['capacidade'];
$ing_disponiveis = $_POST['ing_disponiveis'];
$nome_categoria = $_POST['nome_categoria'];
$imagem = null;

if (isset($_FILES['imagem']) &&
    $_FILES['imagem']['error'] != UPLOAD_ERR_NO_FILE) {

    if ($_FILES['imagem']['error'] != UPLOAD_ERR_OK) {
        die('Erro ao enviar a imagem.');
    }

    $imagem = $_FILES['imagem']['tmp_name'];

if (getimagesize($imagem) === false) {
    $msg = urlencode('O arquivo enviado não é uma imagem válida. O cadastro foi cancelado');
    header("Location: ./form_cadastrar.php?erro=$msg");
    exit();
}
}


$sql = "INSERT INTO shows (titulo, descricao, data_show, locals, preco, capacidade, ing_disponiveis, imagem, nome_categoria) 
VALUES ('$titulo', '$descricao', '$data_show', '$locals', '$preco', '$capacidade', '$ing_disponiveis', '', '$nome_categoria')";


mysqli_query($conn,$sql) or die(mysqli_error($conn));

$ultimocod = mysqli_insert_id($conn);

if ($imagem != null) {
    $arquivo = '../fotos/' . $ultimocod . '.jpg';

    if (!move_uploaded_file($imagem, $arquivo)) {
        $sql = "DELETE FROM shows WHERE id_show='$ultimocod'";
        mysqli_query($conn, $sql);

        die('Não foi possível salvar a imagem. O cadastro foi cancelado.');
    }
}

$msg= urlencode('Show Cadastrado com Sucesso!');
header("location: ./form_cadastrar.php?retorno=$msg");
?>   
