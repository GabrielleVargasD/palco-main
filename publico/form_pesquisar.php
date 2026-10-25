<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar por título</title>
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
                Pesquisar shows por título
            </h2>

            <p class="text-gray-600 mb-6">
                Encontre seus artistas e shows favoritos pesquisando pelo título.
            </p>

            <form name="pesquisar"
                  action="form_pesquisar.php"
                  method="POST"
                  class="flex flex-col md:flex-row gap-4">

                <input type="text"
                       name="titulo"
                       size="50"
                       placeholder="Digite o título do show"
                       class="w-full md:flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-red-700">

                <input type="submit"
                       value="Procurar"
                       class="bg-red-700 text-white font-bold px-10 py-3 rounded-lg hover:bg-red-800 cursor-pointer">

            </form>

        </section>

        <?php
        require_once('../admin/conectar.php');

        if (isset($_POST['titulo']))
        {
            $titulo = $_POST['titulo'];

            if ($titulo == "")
            {
                echo "<p class='text-red-700 font-medium'>Informe o título para pesquisar.</p>";
            }
            else
            {
                $sql = "SELECT * FROM shows WHERE titulo LIKE '%$titulo%'";

                $res = mysqli_query($conn, $sql)
                    or die(mysqli_error($conn));

                $num = mysqli_num_rows($res);

                if ($num > 0)
                {
                    echo "<h2 class='text-2xl font-bold mb-6'>Resultados da pesquisa</h2>";

                    echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>";

                    while ($linha = mysqli_fetch_assoc($res))
                    {
                        echo "<div class='bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden'>";

                        $foto = '../fotos/' . $linha['id_show'] . '.jpg';

                        if (file_exists($foto))
                        {
                            echo "<div class='p-5'>";
                            echo "<img src='$foto' alt='Cartaz do show' class='block w-auto max-w-full max-h-[300px] object-contain mx-auto rounded-lg'>";
                            echo "</div>";
                        }

                        echo "<div class='p-6'>";

                        echo "<p class='text-red-700 font-bold mb-2'>";
                        echo $linha['nome_categoria'];
                        echo "</p>";

                        echo "<h3 class='text-2xl font-bold mb-4'>";
                        echo $linha['titulo'];
                        echo "</h3>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Data:</strong> " . $linha['data_show'];
                        echo "</p>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Local:</strong> " . $linha['locals'];
                        echo "</p>";

                        echo "<a href='./detalhes_show.php?id_show=" . $linha['id_show'] . "'
                                 class='block bg-black text-white text-center font-bold px-6 py-3 rounded-lg hover:bg-gray-800 mt-6'>";
                        echo "Ver mais";
                        echo "</a>";

                        echo "</div>";
                        echo "</div>";
                    }

                    echo "</div>";
                }

                if ($num == 0)
                {
                    echo "<p class='text-gray-600 text-lg'>Nenhum show encontrado.</p>";
                }
            }
        }
        ?>

    </main>

</body>
</html>