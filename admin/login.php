<?php
session_start();
require_once './conectar.php';
$erro = "";

if (isset($_GET['erro']) && $_GET['erro'] == 'expirada')
{
    $erro = "Sua sessão expirou por inatividade (2 minutos). Faça login novamente.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = '$email' AND senha = '$senha'";

    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0)
    {
        $usuario = $resultado->fetch_assoc();

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['ultimo_acesso'] = time();

        header("Location: ./painel_adm.php");
        exit();
    }
    else
    {
        $erro = "E-mail ou senha incorretos!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração Palco</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">

    <main class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="bg-white w-full max-w-md rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-blue-900 px-8 py-8 text-center">

                <h1 class="text-white text-3xl font-bold mb-2">
                    Painel Administrativo
                </h1>

                <p class="text-blue-100">
                    Festival de Música Japonesa
                </p>

            </div>

            <div class="px-8 py-10">

                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Área de Login
                </h2>

                <p class="text-gray-600 mb-7">
                    Informe suas credenciais para acessar o sistema.
                </p>

                <?php if ($erro): ?>

                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <?php echo $erro; ?>
                    </div>

                <?php endif; ?>

                <form method="POST" action="./login.php" class="space-y-5">

                    <div>
                        <label for="email" class="block font-medium text-gray-700 mb-2">
                            E-mail
                        </label>

                        <input type="email"
                               id="email"
                               name="email"
                               placeholder="Digite seu e-mail"
                               required
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">
                    </div>

                    <div>
                        <label for="senha" class="block font-medium text-gray-700 mb-2">
                            Senha
                        </label>

                        <input type="password"
                               id="senha"
                               name="senha"
                               placeholder="Digite sua senha"
                               required
                               class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-blue-700">
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-800 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-900 cursor-pointer">
                        Entrar
                    </button>

                </form>

                <div class="border-t border-gray-200 mt-8 pt-6 text-center">

                    <a href="../publico/painel_pub.php"
                       class="text-blue-800 font-medium hover:text-blue-900 hover:underline">
                        Voltar à página pública
                    </a>

                </div>
            </div>
        </div>
                </main>

</body>
</html>