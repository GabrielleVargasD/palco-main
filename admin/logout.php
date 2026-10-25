<?php

session_start();

//Limpar todas as variáveis de sessão da memoria

session_unset();

//Destrói a sessão no servidor

session_destroy();

//Redireciona para o login

header("Location: ./login.php");

exit();

?>
