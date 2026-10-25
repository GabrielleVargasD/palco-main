
<?php
require_once('../admin/conectar.php');

$sql = "SELECT * FROM shows WHERE data_show > CURDATE() ORDER BY data_show ASC";

$res = mysqli_query($conn, $sql)
    or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festival de Música Japonesa!</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
</head>

<body>

    <header class="bg-red-700 border-b border-gray-200">
        <nav class="w-full px-6 md:px-10 lg:px-16 py-5 flex flex-wrap justify-between items-center gap-4">

            <h1 class="text-white text-2xl">
                Festival de Música Japonesa!
            </h1>

            <a href="../admin/login.php"
               class="bg-black text-white px-5 py-2 rounded">
                Administração
            </a>

        </nav>
    </header>


    <section class="banner-festival flex items-center justify-center">
        <div class="p-6 flex items-center justify-center">

            <img src="../fotos/festival_logo.png"
                alt="Logo do Festival de Música Japonesa"
                class="w-64 md:w-80 lg:w-96 h-auto">

        </div>
    </section>

    <main class="w-full px-6 md:px-10 lg:px-16 py-12">
        <section class="mb-12">

            <h2 class="titulo-festival text-2xl mb-5">
                Pesquisar shows
            </h2>

            <div class="flex flex-wrap gap-4">

                <a href="./form_pesquisar.php"
                   class="border border-red-700 text-red-700 px-5 py-3 rounded hover:bg-red-700 hover:text-white">
                    Pesquisar por título
                </a>

                <a href="./form_pesquisar_categ.php"
                   class="border border-red-700 text-red-700 px-5 py-3 rounded hover:bg-red-700 hover:text-white">
                    Pesquisar por categoria
                </a>

            </div>

        </section>

        <section>

            <h2 class="titulo-festival text-3xl mb-8">
                Próximos shows
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <?php
                $num = mysqli_num_rows($res);

                if ($num == 0) {
                    echo "<p>Nenhum show futuro disponível no momento.</p>";
                }

                while ($linha = mysqli_fetch_assoc($res)) {
                    $foto = '../fotos/' . $linha['id_show'] . '.jpg';
                ?>

                    <article class="card-show bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">

                        <?php
                        if (file_exists($foto)) {
                        ?>
                            <img src="<?php echo $foto; ?>"
                                 alt="Cartaz do show"
                                 class="w-full h-52 object-cover">
                        <?php
                        }
                        ?>

                        <div class="p-5">

                            <p class="text-red-700 text-sm font-bold mb-2">
                                <?php echo $linha['nome_categoria'] ?? ''; ?>
                            </p>

                            <h3 class="text-xl font-bold mb-3">
                                <?php echo $linha['titulo']; ?>
                            </h3>

                            <p class="text-gray-600 mb-1">
                                Data: <?php echo $linha['data_show']; ?>
                            </p>

                            <p class="text-gray-600 mb-4">
                                Local: <?php echo $linha['locals']; ?>
                            </p>

                            <div class="flex flex-wrap gap-3">

                                <a href="./detalhes_show.php?id_show=<?php echo $linha['id_show']; ?>"
                                   class="border border-red-700 text-red-700 px-4 py-2 rounded hover:bg-red-50">
                                    Ver mais
                                </a>

                                <a href="./comprar.php?id_show=<?php echo $linha['id_show']; ?>"
                                   class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
                                    Comprar ingresso
                                </a>

                            </div>

                        </div>

                    </article>

                <?php
                }
                ?>

            </div>

        </section>

    </main>

</body>
</html>