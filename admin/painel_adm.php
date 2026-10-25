<?php
require_once './verifica_sessao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Palco</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">

    <header class="bg-blue-900">
        <nav class="w-full px-6 md:px-10 lg:px-16 py-5 flex flex-wrap justify-between items-center gap-4">

            <h1 class="text-white text-2xl font-bold">
                Painel Administrativo
            </h1>

            <div class="flex flex-wrap items-center gap-3">

                <a href="../publico/painel_pub.php"
                   class="bg-white text-blue-900 font-medium px-5 py-2 rounded-lg hover:bg-blue-50">
                    Página pública
                </a>

                <a href="./logout.php"
                   class="bg-blue-800 text-white font-medium px-5 py-2 rounded-lg hover:bg-blue-700">
                    Sair da conta
                </a>

            </div>

        </nav>
    </header>

    <main class="w-full px-6 md:px-10 lg:px-16 py-12">
        <section class="mb-12">
            <h2 class="text-blue-900 text-3xl font-bold mb-3">
                Área Restrita
            </h2>

            <p class="text-xl text-gray-800 mb-3">
                Olá, <strong><?php echo $_SESSION['usuario_nome']; ?></strong>!
            </p>

            <p class="text-gray-600">
                Bem-vindo ao painel administrativo do Palco.
                Selecione uma das opções abaixo para gerenciar os shows do festival.
            </p>

        </section>

        <section>
            <h2 class="text-2xl font-bold mb-6">
                Gerenciamento de shows
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <a href="./form_cadastrar.php"
                   class="block bg-white border border-gray-200 rounded-xl shadow-sm p-7 hover:shadow-md hover:border-blue-300 transition">
                    <h3 class="text-xl font-bold mb-3">
                        Cadastrar show
                    </h3>

                    <p class="text-gray-600 mb-5">
                        Adicione novos shows ao festival, informando seus dados e cartaz.
                    </p>

                    <span class="text-blue-800 font-semibold">
                        Acessar →
                    </span>

                </a>
                <a href="./form_atualizar.php"
                   class="block bg-white border border-gray-200 rounded-xl shadow-sm p-7 hover:shadow-md hover:border-blue-300 transition">
                    <h3 class="text-xl font-bold mb-3">
                        Atualizar show
                    </h3>

                    <p class="text-gray-600 mb-5">
                        Edite as informações de um show que já está cadastrado no sistema.
                    </p>

                    <span class="text-blue-800 font-semibold">
                        Acessar →
                    </span>

                </a>

                <a href="./form_excluir.php"
                   class="block bg-white border border-gray-200 rounded-xl shadow-sm p-7 hover:shadow-md hover:border-blue-300 transition">
                    <h3 class="text-xl font-bold mb-3">
                        Excluir show
                    </h3>

                    <p class="text-gray-600 mb-5">
                        Remova shows cadastrados que não devem mais aparecer no festival.
                    </p>

                    <span class="text-blue-800 font-semibold">
                        Acessar →
                    </span>

                </a>
                <a href="./form_pesquisar.php"
                   class="block bg-white border border-gray-200 rounded-xl shadow-sm p-7 hover:shadow-md hover:border-blue-300 transition">

                    <h3 class="text-xl font-bold mb-3">
                        Pesquisar por título
                    </h3>

                    <p class="text-gray-600 mb-5">
                        Consulte os shows cadastrados utilizando o título como filtro.
                    </p>

                    <span class="text-blue-800 font-semibold">
                        Acessar →
                    </span>

                </a>
                <a href="./form_pesquisar_categ.php"
                   class="block bg-white border border-gray-200 rounded-xl shadow-sm p-7 hover:shadow-md hover:border-blue-300 transition">

                    <h3 class="text-xl font-bold mb-3">
                        Pesquisar por categoria
                    </h3>

                    <p class="text-gray-600 mb-5">
                        Encontre os shows cadastrados de acordo com sua categoria.
                    </p>

                    <span class="text-blue-800 font-semibold">
                        Acessar →
                    </span>

                </a>

                <a href="./relatorio_shows.php"
                   class="block bg-white border border-gray-200 rounded-xl shadow-sm p-7 hover:shadow-md hover:border-blue-300 transition">
                    <h3 class="text-xl font-bold mb-3">
                        Gerar relatório
                    </h3>

                    <p class="text-gray-600 mb-5">
                        Gere um relatório com as informações dos shows cadastrados.
                    </p>

                    <span class="text-blue-800 font-semibold">
                        Acessar →
                    </span>

                </a>

            </div>

        </section>

    </main>

</body>
</html>