<?php
require_once('../admin/conectar.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Acesso inválido.");
}

$id_show = $_POST['id_show'] ?? '';
$nome_comprador = $_POST['nome_comprador'] ?? '';
$email = $_POST['email'] ?? '';
$cpf = $_POST['cpf'] ?? '';
$qtd_ing = $_POST['qtd_ing'] ?? '';

$sucesso = false;
$mensagem = '';
$valor_total = 0;
$show = null;

if ($nome_comprador == "" || $email == "" || $cpf == "") {
    $mensagem = "Preencha todos os campos.";
} elseif (filter_var($id_show, FILTER_VALIDATE_INT) === false ||
          filter_var($qtd_ing, FILTER_VALIDATE_INT) === false ||
          $id_show <= 0 || $qtd_ing <= 0) {
    $mensagem = "Dados da compra inválidos.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mensagem = "E-mail inválido.";
} else {

    $id_show = (int) $id_show;
    $qtd_ing = (int) $qtd_ing;

    $sql = "SELECT * FROM shows WHERE id_show = $id_show";
    $res = mysqli_query($conn, $sql);

    if (!$res || mysqli_num_rows($res) == 0) {
        $mensagem = "Show não encontrado.";
    } else {

        $show = mysqli_fetch_assoc($res);

        if ($qtd_ing > $show['ing_disponiveis']) {
            $mensagem = "Ingressos insuficientes.";
        } else {

            $valor_total = $show['preco'] * $qtd_ing;

            mysqli_begin_transaction($conn);

            $sql = "INSERT INTO vendas
                    (nome_comprador, email, cpf, qtd_ing, valor_total, data_compra, id_show)
                    VALUES (?, ?, ?, ?, ?, NOW(), ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sssidi",
                $nome_comprador,
                $email,
                $cpf,
                $qtd_ing,
                $valor_total,
                $id_show
            );

            $venda = mysqli_stmt_execute($stmt);

            $sql = "UPDATE shows
                    SET ing_disponiveis = ing_disponiveis - $qtd_ing
                    WHERE id_show = $id_show
                    AND ing_disponiveis >= $qtd_ing";

            $atualizacao = mysqli_query($conn, $sql);

            if ($venda && $atualizacao && mysqli_affected_rows($conn) == 1) {
                mysqli_commit($conn);
                $sucesso = true;
                $mensagem = "Compra realizada com sucesso!";
            } else {
                mysqli_rollback($conn);
                $mensagem = "Erro ao realizar a compra.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação da compra</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-white text-black">

    <header class="bg-red-700">
        <nav class="w-full px-6 md:px-10 lg:px-16 py-5">

            <h1 class="text-white text-2xl">
                Festival de Música Japonesa!
            </h1>

        </nav>
    </header>

    <main class="max-w-2xl mx-auto px-6 py-16">

        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 md:p-10 text-center">

            <?php if ($sucesso) { ?>
                <h2 class="text-3xl font-bold mb-4">
                    <?php echo $mensagem; ?>
                </h2>

                <p class="text-gray-600 mb-8">
                    Seus ingressos foram registrados com sucesso!
                </p>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-left mb-8">

                    <h3 class="text-xl font-bold mb-5">
                        Resumo da compra
                    </h3>

                    <p class="mb-3">
                        <strong>Show:</strong>
                        <?php echo $show['titulo']; ?>
                    </p>

                    <p class="mb-3">
                        <strong>Comprador:</strong>
                        <?php echo $nome_comprador; ?>
                    </p>

                    <p class="mb-3">
                        <strong>Quantidade de ingressos:</strong>
                        <?php echo $qtd_ing; ?>
                    </p>

                    <div class="border-t border-gray-300 pt-5 mt-5">

                        <p class="text-gray-600 mb-2">
                            Valor total
                        </p>

                        <p class="text-red-700 text-3xl font-bold">
                            R$ <?php echo number_format($valor_total, 2, ',', '.'); ?>
                        </p>

                    </div>

                </div>

            <?php } else { ?>

                <div class="text-red-700 text-6xl mb-5">
                    !
                </div>

                <h2 class="text-3xl font-bold mb-4">
                    Não foi possível realizar a compra
                </h2>

                <p class="text-gray-600 mb-8">
                    <?php echo $mensagem; ?>
                </p>

            <?php } ?>

            <a href="./painel_pub.php"
               class="w-full bg-red-700 text-white text-xl font-bold px-8 py-5 rounded-lg hover:bg-red-800 cursor-pointer">
                Voltar aos shows
            </a>

        </div>

    </main>

</body>
</html>