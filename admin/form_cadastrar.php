<?php
require_once './verifica_sessao.php';
require_once './conectar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Shows - Administração</title>
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
                Cadastrar show
            </h2>

            <p class="text-gray-600">
                Preencha as informações abaixo para cadastrar um novo show no festival.
            </p>

        </section>

        <?php
        if (isset($_GET['retorno']))
        {
            echo "<div class='bg-blue-50 border border-blue-200 text-blue-900 px-5 py-4 rounded-lg mb-6'>";
            echo $_GET['retorno'];
            echo "</div>";
        }

        if (isset($_GET['erro']))
        {
            echo "<div class='bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-lg mb-6'>";
            echo $_GET['erro'];
            echo "</div>";
        }
        ?>

        <section class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 md:p-10">
            <form name="dados"
                  action="./exec_cadastrar.php"
                  method="POST"
                  enctype="multipart/form-data">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">

                        <label for="titulo"
                               class="block font-medium text-gray-700 mb-2">
                            Título do show
                        </label>

                        <input type="text"
                               id="titulo"
                               name="titulo"
                               maxlength="50"
                               size="50"
                               required
                               placeholder="Digite o título do show"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">

                    </div>

                    <div class="md:col-span-2">

                        <label for="descricao"
                               class="block font-medium text-gray-700 mb-2">
                            Descrição
                        </label>

                        <textarea id="descricao"
                                  name="descricao"
                                  maxlength="200"
                                  rows="4"
                                  placeholder="Descreva o show"
                                  class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700"></textarea>

                    </div>

                    <div>

                        <label for="data_show"
                               class="block font-medium text-gray-700 mb-2">
                            Data do show
                        </label>

                        <input type="date"
                               id="data_show"
                               name="data_show"
                               required
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">

                    </div>

                    <div>

                        <label for="locals"
                               class="block font-medium text-gray-700 mb-2">
                            Local
                        </label>

                        <input type="text"
                               id="locals"
                               name="locals"
                               maxlength="200"
                               size="50"
                               required
                               placeholder="Informe o local do show"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">

                    </div>

                    <div>
                        <label for="preco"
                               class="block font-medium text-gray-700 mb-2">
                            Preço (R$)
                        </label>

                        <input type="number"
                               id="preco"
                               name="preco"
                               min="0"
                               required
                               placeholder="0,00"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">

                    </div>
                    <div>

                        <label for="capacidade"
                               class="block font-medium text-gray-700 mb-2">
                            Capacidade
                        </label>

                        <input type="number"
                               id="capacidade"
                               name="capacidade"
                               min="1"
                               step="1"
                               required
                               placeholder="Quantidade máxima de pessoas"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">

                    </div>

                    <div>
                        <label for="ing_disponiveis"
                               class="block font-medium text-gray-700 mb-2">
                            Ingressos disponíveis
                        </label>

                        <input type="number"
                               id="ing_disponiveis"
                               name="ing_disponiveis"
                               min="0"
                               step="1"
                               required
                               placeholder="Quantidade de ingressos"
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">
                    </div>
                    <div>

                        <label for="nome_categoria"
                               class="block font-medium text-gray-700 mb-2">
                            Categoria
                        </label>

                        <select id="nome_categoria"
                                name="nome_categoria"
                                required
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">

                            <option value="">Selecione uma categoria</option>

                            <?php
                            $sql_cat = "SELECT * FROM categoria";
                            $res_cat = mysqli_query($conn, $sql_cat);

                            while ($cat = mysqli_fetch_assoc($res_cat))
                            {
                                echo "<option value='" . $cat['nome_categoria'] . "'>"
                                    . $cat['nome_categoria']
                                    . "</option>";
                            }
                            ?>

                        </select>

                    </div>
                    <div class="md:col-span-2">

                        <label for="imagem"
                               class="block font-medium text-gray-700 mb-2">
                            Imagem do show
                        </label>

                        <input type="file"
                               id="imagem"
                               name="imagem"
                               accept=".jpg"
                               class="block w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 cursor-pointer">

                    </div>

                </div>

                <div class="border-t border-gray-200 mt-8 pt-6 flex flex-col sm:flex-row gap-4">

                    <input type="submit"
                           name="btn"
                           value="Cadastrar show"
                           class="bg-blue-800 text-white font-bold px-10 py-3 rounded-lg hover:bg-blue-900 cursor-pointer">

                    <a href="./painel_adm.php"
                       class="bg-gray-200 text-gray-800 text-center font-medium px-10 py-3 rounded-lg hover:bg-gray-300">
                        Cancelar
                    </a>

                </div>
            </form>
        </section>
    </main>

</body>
</html>
