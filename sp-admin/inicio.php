<?php 
    // ========================================
    // inicio
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }    
?>

<div class="container pad-20">

    <!-- botão para aceder ao setup -->
    <div class="col-sm-4 justify-content-center text-center container-fluid">
        <a  style="margin-bottom: 10px;" href="?a=setup" class="btn btn-secondary">Setup</a>
        <a class = "btn btn-secondary btn-size-100"href="?a=clientes_listagem">Lista clientes </a>
    </div>

</div>