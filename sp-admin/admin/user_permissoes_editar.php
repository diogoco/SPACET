<?php
    // ========================================
    // gestão de user - editar permissoes de user
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    //sucesso ou erro    
    $sucesso = false;
    $mensagem = '';
    
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
    if(!$erro_permissao){
        //vamos buscar os dados do user
        $parametros = [':id_user' => $id_user];
        $dados_user = $gestor->EXE_QUERY('SELECT * FROM user 
                                                WHERE id_user = :id_user', $parametros);
    }

    // ==============================================================
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

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

        //atualizar as permissões na base de dados
        $parametros = [
            ':id_user'    => $id_user,
            ':permissoes'       => $permissoes_finais,
            ':atualizado_em'    => DATAS::DataHoraAtualBD()
        ];

        $gestor->EXE_NON_QUERY('UPDATE user SET 
                                permissoes = :permissoes,
                                atualizado_em = :atualizado_em
                                WHERE id_user = :id_user',$parametros);
        
        //recarregar os dados do user
        $parametros = [':id_user' => $id_user];
        $dados_user = $gestor->EXE_QUERY('SELECT * FROM user 
                                                WHERE id_user = :id_user', $parametros);

        $sucesso = true;
        $mensagem = 'Dados atualizados com sucesso.';
    }
?>

<?php if($erro_permissao) : ?>
    <?php include('../inc/sem_permissao.php') ?>
<?php else : ?>

    <!-- mensagem de sucesso -->
    <?php if($sucesso) :?>
    <div class="alert alert-success text-center"><?php echo $mensagem ?></div>
    <?php endif; ?>


    <div class="container">    
        <div class="row mt-3 mb-3 p-3">
            <div class="col-8 offset-2 card p-4">
                <h4 class="text-center">Editar Permissões</h4>

                <!-- dados do user -->
                <hr>
                <p>user: <b><?php echo $dados_user[0]['nome'] ?></b> </p>
                <hr>


                <!-- caixa permissões -->
                <form action="?a=editar_permissoes&id=<?php echo $id_user ?>" method="post">
                <div class="caixa-permissoes">                                    
                    <?php 
                        $permissoes = include('../inc/permissoes.php');
                        $id=0;
                        foreach($permissoes as $permissao){ ?>                    
                        <div class="checkbox">
                            <label>

                                <?php 
                                    //vamos buscar o valor da permissão no user
                                    $ptemp = substr($dados_user[0]['permissoes'], $id, 1);
                                    $checked = $ptemp == '1' ? 'checked' : '';
                                ?>                    
                                <input type="checkbox" name="check_permissao[]" id="check_permissao" value="<?php echo $id ?>" <?php echo $checked ?> >                                                                                    
                            
                                <span class="permissao-titulo"><?php echo $permissao['permissao'] ?></span>
                            </label>
                            <p class="permissao-sumario"><?php echo $permissao['sumario'] ?></p>
                        </div>
                    <?php $id++; } ?>
                        
                    <!-- todas | nenhuma -->
                    <div>
                        <a href="#" onclick="checks(true); return false">Todas</a> | <a href="#" onclick="checks(false); return false">Nenhumas</a>
                    </div>                    
                </div>

                <!-- botões -->
                <div class="text-center mt-5">
                    <a href="?a=user_gerenciar" class="btn btn-primary btn-size-150">Cancelar</a>
                    <button type="submit" class="btn btn-primary btn-size-150">Atualizar</button>
                </div>

                </form>

            </div>
        </div>
    </div>

<?php endif; ?>