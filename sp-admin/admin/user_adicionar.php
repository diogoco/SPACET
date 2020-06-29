<?php
    // ========================================
    // gestão de user - adicionar novo user
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
    
    $gestor = new cl_gestorBD();
    $erro = false;
    $sucesso = false;
    $mensagem = '';


    //==================================================================================
    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
      
        //vai buscar os valores do formulário
        $user =             $_POST['text_user'];
        $password  =        $_POST['text_password'];
        $nome_completo =    $_POST['text_nome'];
        $email =            $_POST['text_email'];
        if(isset($_FILES['imagem'])){
            $ext = strtolower((substr($_FILES['imagem']['name'],-4)));
            
            $perfil = $user.'perfil'.$ext;
            $dir = '../images/upload/';
            move_uploaded_file($_FILES['imagem']['tmp_name'], $dir.$perfil);
        }
        //permissoes
        $total_permissoes = (count(include('../inc/permissoes.php')));
        $permissoes = [];
        if(isset($_POST['check_permissao'])){
            $permissoes = $_POST['check_permissao'];
        }
        $permissoes_finais = '';
        for ($i=0; $i < 100; $i++) { 
            if($i<$total_permissoes){
                if(in_array($i, $permissoes)){
                    $permissoes_finais.='1';        
                } else {
                    $permissoes_finais.='0';
                }
            } else {
                $permissoes_finais.='1';
            }        
        }
        
        //------------------------------------------------------
        // verifica os dados na base de dados

        //------------------------------------------------------
        // verfica se existe user com nome igual
        $parametros = [
            ':user' => $user
        ];

        $dtemp = $gestor->EXE_QUERY('SELECT user 
                                     FROM user
                                     WHERE user = :user', $parametros);
        if(count($dtemp)!=0){
            $erro = true;
            $mensagem = 'Já existe um user com o mesmo nome.';
        }

        //------------------------------------------------------
        //verifica se existe outro user com o mesmo email
        if(!$erro){
            $parametros = [
                ':email' => $email
            ];

            $dtemp = $gestor->EXE_QUERY('SELECT email 
                                         FROM user
                                         WHERE email = :email', $parametros);
            if(count($dtemp)!=0){
                $erro = true;
                $mensagem = 'Já existe outro user com o mesmo email.';
            }                          
        }
        
        //------------------------------------------------------
        //guardar na base de dados
        if(!$erro){
            $parametros = [
                ':user'             => $user,
                ':palavra_passe'    => md5($password),
                ':nome'             => $nome_completo,
                ':email'            => $email,
                ':permissoes'       => $permissoes_finais,
                ':criado_em'        => DATAS::DataHoraAtualBD(),
                ':atualizado_em'    => DATAS::DataHoraAtualBD(),
                ':imagem_perfil'    =>$perfil
            ];

            $gestor->EXE_NON_QUERY('
                INSERT INTO user
                    (user, palavra_passe, nome, email, permissoes, criado_em, atualizado_em,imagem_perfil)
                VALUES
                    (:user, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em, :imagem_perfil)',$parametros);

            //enviar o email para o novo user            
            $mensagem = [
                $email,
                'SPACET - Criação de nova conta de user',
                "<p>Foi criada a nova conta de user com os seguintes dados:<p><p>user: $user <p><p>Password: $password </p>"
            ];
            $mail = new emails();
            $mail->EnviarEmail($mensagem);
            

            //apresentar um alerta de sucesso
            echo '<div class="alert alert-success text-center">Novo user adicionado com sucesso.</div>';
        }
        
    }    
    //==================================================================================
?>

<!-- apresenta o erro no caso de existir -->
<?php 
    if($erro){
        echo '<div class="alert alert-danger text-center">'.$mensagem.'</div>';
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8 card m-3 p-3">
        <h4 class="text-center">ADICIONAR NOVO USUARIO</h4>
        <hr>
        
        <!-- formulário para adicionar novo user -->
        <form action="?a=user_adicionar" method="post" enctype="multipart/form-data">
        
            <!-- user -->
            <div class="form-group">
                <label>user:</label>
                <input type="text"
                       name="text_user"
                       class="form-control"
                       pattern=".{3,50}"
                       title="Entre 3 e 50 caracteres."
                       required>
            </div>
            <!-- password -->
            <div class="form-group">
                <label>Password:</label>

                <div class="row">                    
                    <div class="col">
                        <input type="text"
                            name="text_password"
                            id="text_password"
                            class="form-control"
                            pattern=".{3,30}"
                            title="Entre 3 e 30 caracteres."
                            required>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary" onclick="gerarPassword(10)">Gerar password</button>
                    </div>
                </div>
            </div>

            <!-- nome completo -->
            <div class="form-group">
                <label>Nome:</label>
                <input type="text"
                       name="text_nome"
                       class="form-control"
                       pattern=".{3,50}"
                       title="Entre 3 e 50 caracteres."
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
                       required>
            </div>
            <div class="form-group">
                <label>Imagem Perfil:</label>
                <input
                       name="imagem"
                       type="file"/>
                       
            </div>
            <div class="text-center m-3">
                <button type="button" 
                        class="btn btn-primary btn-size-150"
                        data-toggle="collapse" 
                        data-target="#caixa_permissoes">Definir permissões
                </button>
            </div>

            <!-- caixa permissões -->
            <div class="collapse" id="caixa_permissoes">
                <div class="card p-3 caixa-permissoes">                                    
                    <?php 
                        $permissoes = include_once('../inc/permissoes.php');
                        $id=0;
                        foreach($permissoes as $permissao){ ?>                    
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="check_permissao[]" id="check_permissao" value="<?php echo $id ?> ">
                                <span class="permissao-titulo"><?php echo $permissao['permissao'] ?></span>
                            </label>
                            <p class="permissao-sumario"><?php echo $permissao['sumario'] ?></p>
                        </div>
                    <?php $id++; } ?>
            
                </div>
            </div>

            <div class="text-center">
                <a href="?a=user_gerenciar" class="btn btn-primary btn-size-150">Cancelar</a>
                <button class="btn btn-primary btn-size-150">Criar user</button>
            </div>

            <hr>

            
        </form>

        </div>        
    </div>
</div>
