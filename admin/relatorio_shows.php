<?php
require_once './verifica_sessao.php';
require_once './conectar.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$sql = "SELECT titulo, data_show, locals, nome_categoria,preco, capacidade, ing_disponiveis FROM shows
ORDER BY data_show ASC";

$resultado = mysqli_query($conn, $sql);

if (!$resultado){
    die("Erro ao consultar os shows: " . mysqli_error($conn));
}

$html = '
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #999;
            padding: 5px;
            text-align: left;
            font-size: 9px;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Palco - Relatório de Shows</h1>
    <p>Lista completa de shows cadastrados</p>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Data</th>
                <th>Local</th>
                <th>Categoria</th>
                <th>Preço (R$)</th>
                <th>Capacidade</th>
                <th>Ingressos disponíveis</th>
            </tr>
        </thead>
        <tbody>';

while ($show = mysqli_fetch_assoc($resultado)) {
    $html .= '<tr>
        <td>' . $show['titulo'] . '</td>
        <td>' . $show['data_show'] . '</td>
        <td>' . $show['locals'] . '</td>
        <td>' . $show['nome_categoria'] . '</td>
        <td>R$ ' . number_format($show['preco'], 2, ',', '.') . '</td>
        <td>' . $show['capacidade'] . '</td>
        <td>' . $show['ing_disponiveis'] . '</td>
    </tr>';
}


$html .= '
        </tbody>
    </table>
</body>
</html>';

$options = new Options();
$options->set('isRemoteEnabled', false);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('relatorio_shows.pdf', [
    'Attachment' => false
]);

exit;
?>