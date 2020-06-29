<?php 
    // ========================================
    // login
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }  
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    $gestor = new cl_gestorBD();
    $dados = null;
    $erro = false;

    $cliente = '';
    if($id != null){
        $parametros= [
            ':id_cliente' => $id
        ];
        $dados= $gestor->EXE_QUERY('SELECT * FROM 
        clientes WHERE id_cliente = :id_cliente', $parametros);

        if(count($dados)==0){
            $erro = true;
            $mensagem = '<p>Erro ao exibir dados do cliente informado!</p>';
        }else {
            $erro = false;
            $cliente = $dados[0];
            
           
        }
        
        
    }
   
?>
<div class = "container">
    <?php if($erro): ?>
        <div class="text-center alert alert-danger">
            <?php echo $mensagem; ?> 
            </div>
    <?php else : ?>
        <?php  echo $cliente['nome']; ?>
    
<?php endif;?>
</div>