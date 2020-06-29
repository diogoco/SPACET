<?php
    // ========================================
    // gestão de user - eliminar user
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }
    
    //verificar permissão
    $erro_permissao = false;
    if(!funcoes::Permissao(0)){
        $erro_permissao = true;
    }
    $erro = false;
    $mensagem = '';
    $sucesso = false;

    //verifica se id_user está definido
    $id_user = -1;
    if(isset($_GET['id'])){
        $id_user = $_GET['id'];
    } else {
        $erro_permissao = true;
    }

    //verifica se pode avançar (id_user != 1 e != do da sessão)
    if($id_user == 1 || $id_user == $_SESSION['id_user']){
        $erro_permissao = true;
    }

    // ==============================================================
    $dados_user = null;
    $gestor = new cl_gestorBD();
    if(!$erro_permissao){
        //buscar os dados do user
        $parametros = [':id_user' => $id_user];
        $dados_user = $gestor->EXE_QUERY('SELECT * FROM user
                                                WHERE id_user = :id_user', $parametros);
    }

    // ==============================================================
    // verifica se foi dada resposta afirmativa para eliminação
  
    if(isset($_GET['r'])){
        if($_GET['r']==1){
            
            //remover o user da base de dados
            $parametros = [':id_user' => $id_user];            
            $gestor->EXE_NON_QUERY('DELETE FROM user WHERE id_user = :id_user', $parametros);

            //informa o sistema que a remoção do user aconteceu com sucesso.
            $mensagem = 'Usuario removido com sucesso';
            $sucesso = true;
        }
    }
?>

<!-- sem permissão -->
<?php if($erro_permissao) : ?>
    <?php include('../../inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- remoção com sucesso -->
    <?php if($sucesso){ ?>
        <div class="container-fluid alert text-center alert-success">
        <?php echo $mensagem ?>
        </div>
       <?php include('user_gerenciar.php') ?>
        
  

    <!-- erro de falta de dados -->
    <?php }else{ if($erro) { ?>
        <div class="container-fluid">
            <div class="row mt-5 mb-5">
                <div class="col-md-6 offset-md-3 text-center">
                    <p class="alert alert-danger"><?php echo $mensagem ?></p>
                    <a href="?a=user_gerenciar" class="btn btn-primary btn-size-100">Voltar</a>
                </div>
            </div>
        </div>
    <?php } ?>

   

        <!-- apresentação dos dados do user a remover -->
        <div class="container">
            <div class="mt-3 mb-3 p-3">
                <h4 class="text-center">REMOVER user</h4>                    

                <!-- dados do user -->    
                <div class="row">
                    <div class="col-md-8 offset-md-2 card mt-3 mb-3 p-3">

                        <p class="text-center">Tem a certeza que pretende eliminar o user:<br><strong><?php echo $dados_user[0]['nome'] ?></strong>, cujo email é <strong><?php echo $dados_user[0]['email'] ?></strong> ?</p>

                        <!-- botões não e sim -->
                        <div class="text-center mt-3 mb-3">
                            <a href="?a=user_gerenciar" class="btn btn-primary btn-size-100">Não</a>
                            <a href="?a=eliminar_user&id=<?php echo $id_user ?>&r=1" class="btn btn-primary btn-size-100">Sim</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    <?php } ?>

<?php endif; ?>