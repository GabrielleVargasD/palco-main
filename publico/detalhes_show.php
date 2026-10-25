
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Show</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
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
        <div class="mb-8">
            <h2 class="text-red-700 text-3xl font-bold">
                Detalhes do show
            </h2>
        </div>
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <div>
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
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6 md:p-8 shadow-sm">

                <p class="text-red-700 font-bold mb-2">
                    <?php echo $show['nome_categoria'] ?? ''; ?>
                </p>

                <h3 class="text-3xl font-bold mb-6">
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
                        <strong>Capacidade:</strong>
                        <?php echo $show['capacidade']; ?>
                    </p>

                    <p class="mb-4">
                        <strong>Ingressos disponíveis:</strong>
                        <?php echo $show['ing_disponiveis']; ?>
                    </p>

                </div>

                <div class="border-t border-gray-200 pt-5 mt-5">

                    <p class="text-gray-600 mb-2">
                        Preço do ingresso
                    </p>

                    <p class="text-red-700 text-3xl font-bold mb-6">
                        R$ <?php echo number_format ($show['preco'], 2, ',', '.'); ?>
                    </p>
                        <br><br>
                    <?php if ($show['ing_disponiveis'] > 0) { ?>

                        <a href="./comprar.php?id_show=<?php echo $show['id_show']; ?>"
                        class="w-full bg-red-700 text-white text-xl font-bold px-8 py-5 rounded-lg hover:bg-red-800 cursor-pointer">
                            Comprar ingresso
                        </a>

                    <?php } else { ?>

                        <p class="bg-gray-200 text-gray-600 text-center font-bold px-6 py-4 rounded">
                            Ingressos esgotados
                        </p>

                    <?php } ?>

                </div>

            </div>

        </section>
                <br><br>
        <section class="mt-12 border-t border-gray-200 pt-8">

            <h2 class="text-red-700 text-2xl font-bold mb-4">
                Sobre o show
            </h2>

            <p class="text-gray-700 leading-relaxed">
                <?php echo ($show['descricao'] ?? ''); ?>
            </p>

        </section>

    </main>

</body>
</html>
