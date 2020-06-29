<?php
    // ========================================
    // gestão de user
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

?>

<?php if($erro_permissao) : ?>
<?php include('../inc/sem_permissao.php') ?>
<?php else : ?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col card m-3 p-3">
        <h4 class="text-center">GESTÃO DE user</h4>
        
        <div class="text-center">
            <a href="?a=inicio" class="btn btn-primary btn-size-150">Voltar</a>
            <a href="?a=user_adicionar" class="btn btn-primary btn-size-150">Novo user...</a>
        </div>

        <?php //tabela dos user registados na base de dados ?>

            <div class="row m-3 p-3">            
                <table class="table">

                    <thead class="thead-dark">
                        <th></th>
                        <th>user</th>
                        <th>Nome completo</th>
                        <th>Email</th>
                        <th class="text-center">Ação</th>
                    </thead>

                    <?php 
                        $gestor = new cl_gestorBD();
                        $dados_user = $gestor->EXE_QUERY(
                            'SELECT * FROM user'
                        );                        
                    ?>

                    <?php foreach($dados_user as $user) : ?>                    
                        <tr>

                            <?php if(substr($user['permissoes'], 0, 1) == 1) : ?>
                                <td><i class="fa fa-user"></i></td>
                            <?php else : ?>
                                <td><i class="fa fa-user-o"></i></td>
                            <?php endif; ?>



                            <td><?php echo $user['user'] ?></td>
                            <td><?php echo $user['nome'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td>
                            <!-- dropdown -->
                            <?php 
                                $id = $user['id_user'] ;

                                //definir se o dropdown vai aparecer
                                $drop = true;
                                if($id == 1 || $id == $_SESSION['id_user'] ){
                                    $drop = false;
                                }
                            ?>


                            <?php if($drop) : ?>
                            <div class="dropdown text-center">
                                <i class="fa fa-cog" id="d1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                <div class="dropdown-menu" aria-labelledby="d1">
                                    <a class="dropdown-item" href="?a=editar_user&id=<?php echo $id ?>"><i class="fa fa-edit"></i> Editar user</a>
                                    <a class="dropdown-item" href="?a=editar_permissoes&id=<?php echo $id ?>"><i class="fa fa-list"></i> Editar permissões</a>
                                    <a class="dropdown-item" href="?a=eliminar_user&id=<?php echo $id ?>"><i class="fa fa-trash"></i> Eliminar</a>                                                                            
                                </div>
                            </div>

                            <?php else : ?>
                                <div class="text-center">
                                    <i class="fa fa-cog text-muted"></i>
                                </div>
                            <?php endif; ?>




                            </td>
                        </tr>
                    <?php endforeach; ?>


                </table>
            </div>

        </div>
    </div>
</div>




<?php endif; ?>