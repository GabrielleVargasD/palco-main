<?php

session_start();

//VERIFICAR SE A sessão já foi criada, SENÃO estiver logado, manda para form. login

if (!isset($_SESSION['usuario_id'])) {

header("Location: ./login.php");

exit();

}

//CONFIGURAÇÃO do tempo limite para sessão expirar em segundos (1 minuto = 60s)

$tempo_limite = 120;

//VERIFICAÇÃO DE TIMEOUT: Verifica o tempo de inatividade

if (isset($_SESSION['ultimo_acesso'])) {

$tempo_decorrido = time() - $_SESSION['ultimo_acesso'];

if ($tempo_decorrido > $tempo_limite) {

session_unset();

session_destroy();

header("Location: ./login.php?erro=expirada"); 
exit();

}

}

//ATUALIZAÇÃO DO TEMPO: Atualiza o horário da última ação do usuário

$_SESSION['ultimo_acesso'] = time(); 
?>