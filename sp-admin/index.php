<?php

    // ========================================
    // index do backend
    // ========================================    
    
    //controlo de sessão
    session_start();
    if(!isset($_SESSION['a'])){
        $_SESSION['a'] = 'inicio';
    }

    //inclui as funcoes necessárias do sistema 
    include_once('../inc/funcoes.php');
    include_once('../inc/datas.php');
    include_once('../inc/emails.php');
    include_once('../inc/gestorBD.php');    

    //barra do user
    include_once('users/barra_user.php');

    include_once('_cabecalho.php');    

    include_once('routes.php');

    include_once('_rodape.php');
?>