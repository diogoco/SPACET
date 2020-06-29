<?php 
    // ========================================

    // ========================================

    // verificar a sessão
    $gestor = new cl_gestorBD();
    $erro = false;
    $mensagem = '';
    $sucesso = false;
    $id = -1;
    if(!isset($_SESSION['a'])){
        exit();
    }  
  
   
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    
        $parametros = [
            ':id_cliente'   => $id
        ];
        $dados = $gestor->EXE_QUERY('SELECT * FROM clientes WHERE id_cliente = :id_cliente', $parametros);
        if(count($dados)==0){
            $erro = true;
            $mensagem = 'Erro ao eliminar usuário.';
        }
        if(!$erro){
            if(isset($_GET['eliminar'])){
                $eliminar = $_GET['eliminar'];
                if($eliminar){
                    $gestor->EXE_NON_QUERY('DELETE FROM clientes where id_cliente = :id_cliente', $parametros);
                    $sucesso = true;
                    $mensagem= 'Cliente eliminado com sucesso';
                    
                }
            }
        }
    

       

    

?>


<div class="text-center container">
    
            <?php if($erro):?>
                <div class="alert alert-danger mb-1">
                <p><?php echo $mensagem ?></p>
                </div>
                <?php include_once('clientes_listagem.php'); ?>
              
            <?php else:?>
                    <?php if($sucesso): ?>
                    <div class="alert alert-success text-center">
                    <?php echo $mensagem; ?>
                    </div>
                    <?php include_once('clientes_listagem.php');?>
                    <?php else: ?>
                    <p>Tem certeza que deseja eliminar o cliente? <strong><?php echo $dados[0]['nome'] ?> </strong></p>
                    <a href = "?a=clientes_listagem" class="btn btn-primary btn-size-100">Não</a>
                    <a href = "?a=clientes_eliminar&id=<?php echo $id?>&eliminar=true" class="btn btn-primary btn-size-100">Sim</a>
               
                <?php endif;?> 
    <?php endif;?>

</div>
