<?php
    // ========================================
    // gestão de user - editar user
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
    $gestor = new cl_gestorBD();
    $dados_user = null;  
   
    $erro = false;
    $sucesso = false;
    $mensagem = '';  
    
    if(!$erro_permissao){
        //buscar os dados do user
        $parametros = [':id_user' => $id_user];
        $dados_user = $gestor->EXE_QUERY('SELECT * FROM user 
                                                WHERE id_user = :id_user', $parametros);                                                
        //verifica se existem dados do user
        if(count($dados_user)==0){
            $erro = true;
            $mensagem = 'Não foram encontrados dados do user.';
        }
    }  
    
    // ==============================================================
    // POST
    // ==============================================================
    if($_SERVER['REQUEST_METHOD']== 'POST'){
        
        //buscar os dados das texts
        $nome = $_POST['text_nome'];
        $email = $_POST['text_email'];

        //verificações - verifica se existe outro user com o mesmo email
        $parametros = [
            ':id_user' => $id_user,
            ':email'         => $email
        ];        

        $temp = $gestor->EXE_QUERY('SELECT * FROM user
                                    WHERE id_user <> :id_user
                                    AND email = :email', $parametros);
        if(count($temp) != 0){
            $erro = true;
            $mensagem = 'Já existe outro user com o mesmo email.';
        }

        // ========================================
        // atualiza os dados na base de dados
        if(!$erro){
            $parametros = [
                ':id_user' => $id_user,
                ':nome'          => $nome,
                ':email'         => $email,
                ':atualizado_em' => DATAS::DataHoraAtualBD()
            ];  
            
            $gestor->EXE_NON_QUERY(
                'UPDATE user SET
                nome  = :nome,
                email = :email,
                atualizado_em = :atualizado_em
                WHERE id_user = :id_user',$parametros);
            
            //sucesso
            $sucesso = true;
            $mensagem = 'Dados atualizados com sucesso.';

            $parametros = [':id_user' => $id_user];
            $dados_user = $gestor->EXE_QUERY('SELECT * FROM user WHERE id_user = :id_user', $parametros);
        }
    }
?>

<!-- erro de permissão -->
<?php if($erro_permissao){  ?>
    <?php include('../inc/sem_permissao.php') ?>
<?php }else{?>
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
    <!-- formulário com os dados para alteração -->
    <div class="container">
        <div class="row card mt-3 mb-3">
            <h4 class="text-center mt-4">EDITAR DADOS DO user</h4>

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="mt-3 mb-3">
                        <form action="?a=editar_user&id=<?php echo $id_user ?>" method="post">
                            <div class="form-group">
                                <label>user:</label>
                                <p><strong><?php echo $dados_user[0]['user'] ?></strong></p>

                                <!-- nome completo -->
                                <div class="form-group">
                                    <label>Nome:</label>
                                    <input type="text"
                                        name="text_nome"
                                        class="form-control"
                                        pattern=".{3,50}"
                                        title="Entre 3 e 50 caracteres."
                                        placeholder="<?php echo $dados_user[0]['nome'] ?>"
                                        required>
                                </div>

                                <!-- email -->
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email"
                                        name="text_email"
                                        class="form-control"
                                        pattern=".{3,50}"
                                        title="Entre 3 e 50 caracteres."
                                        placeholder="<?php echo $dados_user[0]['email'] ?>"
                                        required>
                                </div>

                                <div class="text-center">
                                    <a href="?a=user_gerenciar" class="btn btn-primary btn-size-150">Cancelar</a>
                                    <button class="btn btn-primary btn-size-150">Atualizar</button>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php }?>

<?php }?>