<?php 
    // ========================================
    // perfil - menu inicial
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $mensagem = '';

    //verifica se tem permissão para aceder ao sistema
    if(!funcoes::Permissao(4)){
        $erro = true;
        $mensagem = 'Não tem permissão.';
    }

    //vai buscar todas as informações do user
    $gestor = new cl_gestorBD();
    $parametros = [
        ':id_user' => $_SESSION['id_user']
    ];
    $dados = $gestor->EXE_QUERY(
        'SELECT * FROM user 
         WHERE id_user = :id_user',$parametros);
         
          $dir = "http://localhost/SPACET/images/upload/";
        
        
         $imagem = $dir.$dados[0]["imagem_perfil"];
      
?>

<?php if($erro) :?>
    <div class="text-center">
        <h3><?php echo $mensagem ?></h3>
        <a href="?a=inicio" class="btn btn-primary btn-size-150 ">Voltar</a>
    </div>
<?php else :?>
<div class="container-fluid card">
    <div class="row justify-content-center ">
        <div class="col row card m-3 p-3 center">
        <h4 class="text-center">PERFIL DE user</h4> <br>
        <div class="container-fluid text-center perfil">

       <div class="container" style="border-radius:15%;"> <img src=<?php echo $imagem ?> style="width: 150px; height:150px; border: 5px; border-color:antiquewhite"></div>
        <!-- dados do user -->
        <h5><i class="fa fa-user"></i> <?php echo $dados[0]['nome'] ?></h5>
        <p><i class="fa fa-envelope"></i> <?php echo $dados[0]['email'] ?></p>
        </div>
        </div>          
    </div>
    <div class="text-center">
        <!-- voltar -->
        <a href="?a=inicio" class="btn btn-primary btn-size-150 m-3">Voltar</a>
    </div>
</div>

<?php endif; ?>