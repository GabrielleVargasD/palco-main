<?php
require_once('../admin/conectar.php');

if (!isset($_GET['id_show']) || !is_numeric($_GET['id_show'])) {
    die("Show não informado.");
}

$id_show = (int) $_GET['id_show'];

$sql = "SELECT * FROM shows WHERE id_show = $id_show";

$res = mysqli_query($conn, $sql)
    or die(mysqli_error($conn));

if (mysqli_num_rows($res) == 0) {
    die("Show não encontrado.");
}

$show = mysqli_fetch_assoc($res);

$foto = '../fotos/' . $show['id_show'] . '.jpg';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar ingressos</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-white text-black">

    <header class="bg-red-700">
        <nav class="w-full px-6 md:px-10 lg:px-16 py-5 flex flex-wrap justify-between items-center gap-4">

            <h1 class="text-white text-2xl">
                Festival de Música Japonesa!
            </h1>

            <a href="./painel_pub.php"
               class="bg-black text-white px-5 py-2 rounded hover:bg-gray-800">
                Voltar aos shows
            </a>

        </nav>
    </header>

    <main class="w-full px-6 md:px-10 lg:px-16 py-12">

        <section class="mb-10">

            <h2 class="text-red-700 text-3xl font-bold mb-3">
                Finalizar compra
            </h2>

            <p class="text-gray-600">
                Confira as informações do show e preencha seus dados para comprar os ingressos.
            </p>
                <br>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            <div class="bg-white border border-gray-200 rounded-lg p-6 md:p-8 shadow-sm">
                <?php if (file_exists($foto)) { ?>
                    <img src="<?php echo $foto; ?>"
                        alt="Cartaz do show"
                        class="block w-auto max-w-full max-h-[500px] object-contain mx-auto rounded-lg shadow-md">
                <?php } else { ?>
                    <div class="bg-gray-100 p-10 rounded-lg text-center">
                        <p class="text-gray-500">
                            Imagem não disponível.
                        </p>
                    </div>

                <?php } ?>
                <br><br>
                <p class="text-red-700 font-bold mb-2">
                    <?php echo $show['nome_categoria'] ?? ''; ?>
                </p>

                <h3 class="text-2xl font-bold mb-5">
                    <?php echo $show['titulo']; ?>
                </h3>

                <div class="border-t border-gray-200 pt-5">

                    <p class="mb-4">
                        <strong>Data:</strong>
                        <?php echo $show['data_show']; ?>
                    </p>

                    <p class="mb-4">
                        <strong>Local:</strong>
                        <?php echo $show['locals']; ?>
                    </p>

                    <p class="mb-4">
                        <strong>Ingressos disponíveis:</strong>
                        <?php echo $show['ing_disponiveis']; ?>
                    </p>

                </div>

                <div class="border-t border-gray-200 pt-5 mt-5">

                    <p class="text-gray-600 mb-2">
                        Preço por ingresso
                    </p>

                    <p class="text-red-700 text-3xl font-bold">
                        R$ <?php echo number_format($show['preco'], 2, ',', '.'); ?>
                    </p>

                </div>

            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6 md:p-8 shadow-sm">

                <h2 class="text-2xl font-bold mb-6">
                    Dados do comprador
                </h2>

                <?php if ($show['ing_disponiveis'] > 0) { ?>

                    <form action="./exec_comprar.php" method="POST">

                        <input type="hidden"
                               name="id_show"
                               value="<?php echo $show['id_show']; ?>">

                        <div class="mb-5">

                            <label for="nome_comprador" class="block font-medium mb-2">
                                Nome completo
                            </label>

                            <input type="text"
                                   id="nome_comprador"
                                   name="nome_comprador"
                                   maxlength="200"
                                   placeholder="Digite seu nome completo"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-red-700"
                                   required>

                        </div>

                        <div class="mb-5">

                            <label for="email" class="block font-medium mb-2">
                                E-mail
                            </label>

                            <input type="email"
                                   id="email"
                                   name="email"
                                   maxlength="300"
                                   placeholder="Digite seu e-mail"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-red-700"
                                   required>

                        </div>

                        <div class="mb-5">

                            <label for="cpf" class="block font-medium mb-2">
                                CPF
                            </label>

                            <input type="text"
                                   id="cpf"
                                   name="cpf"
                                   maxlength="14"
                                   placeholder="000.000.000-00"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-red-700"
                                   required>

                        </div>

                        <div class="mb-8">

                            <label for="qtd_ing" class="block font-medium mb-2">
                                Quantidade de ingressos
                            </label>

                            <input type="number"
                                   id="qtd_ing"
                                   name="qtd_ing"
                                   min="1"
                                   max="<?php echo $show['ing_disponiveis']; ?>"
                                   step="1"
                                   value="1"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-red-700"
                                   required>

                        </div>
                        <button type="submit"
                                class="w-full bg-red-700 text-white text-xl font-bold px-8 py-5 rounded-lg hover:bg-red-800 cursor-pointer">
                            Confirmar compra
                        </button>

                    </form>

                <?php } else { ?>

                    <p class="bg-gray-100 text-gray-600 text-center font-bold px-6 py-5 rounded-lg">
                        Ingressos esgotados para este show.
                    </p>

                <?php } ?>

            </div>

        </section>

    </main>

</body>
</html>