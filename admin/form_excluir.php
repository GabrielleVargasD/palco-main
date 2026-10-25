
<?php
require_once './verifica_sessao.php';
require_once './conectar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Shows - Administração</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">

    <header class="bg-blue-900">
        <nav class="w-full px-6 md:px-10 lg:px-16 py-5 flex flex-wrap justify-between items-center gap-4">

            <h1 class="text-white text-2xl font-bold">
                Painel Administrativo
            </h1>

            <a href="./painel_adm.php"
               class="bg-white text-blue-900 font-medium px-5 py-2 rounded-lg hover:bg-blue-50">
                Voltar ao painel
            </a>

        </nav>
    </header>
    <main class="w-full px-6 md:px-10 lg:px-16 py-12">
        <section class="mb-10">
            <h2 class="text-blue-900 text-3xl font-bold mb-3">
                Excluir shows
            </h2>

            <p class="text-gray-600">
                Selecione um show cadastrado para realizar sua exclusão.
            </p>

        </section>
        <?php
        if (isset($_GET['retorno']))
        {
            echo "<div class='bg-blue-50 border border-blue-200 text-blue-900 px-5 py-4 rounded-lg mb-8'>";
            echo $_GET['retorno'];
            echo "</div>";
        }
        ?>
        <section class="mb-12">

            <h3 class="text-2xl font-bold mb-6">
                Shows cadastrados
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                <?php
                $sql = "SELECT * FROM shows";
                $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                while ($linha = mysqli_fetch_assoc($res))
                {
                    $id_show = $linha['id_show'];
                    $titulo = $linha['titulo'];

                    echo "<div class='bg-white border border-gray-200 rounded-lg shadow-sm p-6'>";

                    echo "<p class='text-blue-800 text-sm font-bold mb-2'>";
                    echo "ID do show: " . $id_show;
                    echo "</p>";

                    echo "<h4 class='text-xl font-bold mb-5'>";
                    echo $titulo;
                    echo "</h4>";

                    echo "<a href='form_excluir.php?id_show=$id_show'
                             class='block bg-blue-800 text-white text-center font-bold px-6 py-3 rounded-lg hover:bg-blue-900'>";
                    echo "Selecionar";
                    echo "</a>";

                    echo "</div>";
                }
                ?>
            </div>
        </section>

        <?php
        if (isset($_GET['id_show']))
        {
            $id_show = $_GET['id_show'];

            $sql = "SELECT * FROM shows WHERE id_show='$id_show'";
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            $linha = mysqli_fetch_assoc($res);

            if ($linha)
            {
        ?>
        <section class="max-w-2xl">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-blue-900 px-6 py-5">
                    <h3 class="text-white text-xl font-bold">
                        Confirmar exclusão
                    </h3>
                </div>

                <div class="p-6">

                    <p class="text-gray-600 mb-6">
                        Confira o show selecionado antes de confirmar a exclusão.
                    </p>
                    <form name="dados"
                          action="./exec_excluir.php"
                          method="POST">

                        <input type="hidden"
                               name="id_show"
                               value="<?php echo $linha['id_show']; ?>">

                        <div class="mb-6">

                            <label for="titulo"
                                   class="block font-medium text-gray-700 mb-2">
                                Título do show
                            </label>

                            <input type="text"
                                   id="titulo"
                                   name="titulo"
                                   size="50"
                                   readonly
                                   value="<?php echo $linha['titulo']; ?>"
                                   class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-3 text-gray-700">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <input type="submit"
                                   name="excluir"
                                   value="Excluir show"
                                   onclick="return confirm('Tem certeza que deseja excluir este show?');"
                                   class="bg-red-700 text-white font-bold px-8 py-3 rounded-lg hover:bg-red-800 cursor-pointer">

                            <a href="./form_excluir.php"
                               class="bg-gray-200 text-gray-800 text-center font-medium px-8 py-3 rounded-lg hover:bg-gray-300">
                                Cancelar
                            </a>

                        </div>
                    </form>

                </div>
            </div>

        </section>

        <?php
            }
        }
        ?>

    </main>

</body>
</html>