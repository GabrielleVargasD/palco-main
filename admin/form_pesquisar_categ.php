<?php
require_once('./verifica_sessao.php');
require_once('./conectar.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Shows por Categoria - Administração</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-gray-50 text-gray-900">

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
                Pesquisar shows por categoria
            </h2>

            <p class="text-gray-600 mb-6">
                Consulte os shows cadastrados no sistema por categoria.
            </p>

            <form name="pesquisar_categ"
                  action="form_pesquisar_categ.php"
                  method="POST"
                  class="flex flex-col md:flex-row gap-4">

                <input type="text"
                       name="nome_categoria"
                       size="50"
                       placeholder="Digite a categoria do show"
                       class="w-full md:flex-1 bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">

                <input type="submit"
                       value="Pesquisar"
                       class="bg-blue-800 text-white font-bold px-10 py-3 rounded-lg hover:bg-blue-900 cursor-pointer">

            </form>

        </section>

        <?php
        if (isset($_POST['nome_categoria']))
        {
            $nome_categoria = $_POST['nome_categoria'];

            if ($nome_categoria == "")
            {
                echo "<p class='text-blue-900 font-medium'>Informe a categoria para pesquisar.</p>";
            }
            else
            {
                $sql = "SELECT * FROM shows s INNER JOIN categoria c ON s.nome_categoria = c.nome_categoria WHERE c.nome_categoria LIKE '%$nome_categoria%'";

                $res = mysqli_query($conn, $sql)
                    or die(mysqli_error($conn));

                $num = mysqli_num_rows($res);

                if ($num > 0)
                {
                    echo "<h2 class='text-2xl font-bold mb-6'>Resultados da pesquisa</h2>";

                    echo "<div class='grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6'>";

                    while ($linha = mysqli_fetch_assoc($res))
                    {
                        echo "<div class='bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden'>";

                        $foto = '../fotos/' . $linha['id_show'] . '.jpg';

                        if (file_exists($foto))
                        {
                            echo "<div class='p-5 bg-gray-50'>";
                            echo "<img src='$foto' alt='Cartaz do show' class='block w-auto max-w-full max-h-[300px] object-contain mx-auto rounded-lg'>";
                            echo "</div>";
                        }

                        echo "<div class='p-6'>";

                        echo "<p class='text-blue-800 font-bold mb-2'>";
                        echo $linha['nome_categoria'];
                        echo "</p>";

                        echo "<h3 class='text-2xl font-bold mb-5'>";
                        echo $linha['titulo'];
                        echo "</h3>";

                        echo "<div class='border-t border-gray-200 pt-4'>";

                        echo "<p class='mb-3'>";
                        echo "<strong>ID do show:</strong> " . $linha['id_show'];
                        echo "</p>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Descrição:</strong> " . $linha['descricao'];
                        echo "</p>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Data:</strong> " . $linha['data_show'];
                        echo "</p>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Local:</strong> " . $linha['locals'];
                        echo "</p>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Preço:</strong> R$ " . number_format($linha['preco'], 2, ',', '.');
                        echo "</p>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Capacidade:</strong> " . $linha['capacidade'];
                        echo "</p>";

                        echo "<p class='mb-3'>";
                        echo "<strong>Ingressos disponíveis:</strong> " . $linha['ing_disponiveis'];
                        echo "</p>";

                        echo "</div>";

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