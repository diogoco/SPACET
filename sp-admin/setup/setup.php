<?php 
    // ========================================
    // setup
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 
    
    //verifica se a está definido na URL
    $a = '';
    if(isset($_GET['a'])){
        $a = $_GET['a'];
    }
   $mensagem = '';
   $erro = true;

    //route do setup
    switch ($a) {
        case 'setup_criar_bd':        
            //executa os procedimentos para criação da base de dados
            if(include('setup/setup_criar_bd.php')){
            
            $mensagem = 'Bases criadas com sucesso';
            $erro = false;
            }
            
            break;
        
        case 'setup_inserir_user':
            //inserir user
           if( include('setup/setup_inserir_user.php')){
           
            $mensagem = 'Users inseridos com sucesso';
            $erro = false;
            }
            break;
        case 'setup_inserir_clientes':
            //inserir user
        
           if(include('setup/setup_inserir_clientes.php')){
            
            $mensagem = 'Clientes inseridos com sucesso';
            $erro = false;
           }
            break;

      
           
    }
?>

<?php if($erro == false){ ?>
<div class="container-fluid alert alert-success text-center">
        <?php echo $mensagem; ?>
</div>
<?php } ?>
<div class="container-fluid pad-20">
    
    <!-- titulo -->
    <h2 class="text-center">SETUP</h2>

    <div class="text-center">

        
        <!-- criar ou zerar a base de dados -->
        <p><a href="?a=setup_criar_bd" class="btn btn-secondary btn-size-250">Criar a Base de Dados</a></p>
        <!-- inserir usuários/user -->
        <p><a href="?a=setup_inserir_user" class="btn btn-secondary btn-size-250">Inserir user</a></p>

        <p><a href="?a=setup_inserir_clientes" class="btn btn-secondary btn-size-250">Inserir clientes</a></p>
        <p><a href="?a=setup_inserir_imagens" class="btn btn-secondary btn-size-250">Inserir imagens</a></p>
        
        <hr>

        <p><a href="?a=inicio" class="btn btn-secondary btn-size-150">Voltar</a></p>
    </div>
</div>