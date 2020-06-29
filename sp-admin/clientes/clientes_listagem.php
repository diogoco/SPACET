<?php 
    // ========================================
    // login
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }  
    if(isset($_GET['clear'])){
        if(isset($_SESSION['texto_pesquisa'])){
            unset($_SESSION['texto_pesquisa']);
        }
    }
  

    if($_SERVER['REQUEST_METHOD']== 'POST'){
        if($_POST['text_pesquisa'] != ''){
            $_SESSION['texto_pesquisa'] = $_POST['text_pesquisa'];
        }

    }
    $gestor = new cl_gestorBD();
    $cliente = null;
    $total_clientes = 0;
    $itens_pagina = 12;
    $pagina = 1;
    if(isset($_GET['pagina'])){
        $pagina = $_GET['pagina'];
    }
    $item_inicial = ($pagina * $itens_pagina) - $itens_pagina;
    if(isset($_SESSION['texto_pesquisa'] )){
       $texto=$_SESSION['texto_pesquisa'];
       $parametros = [':pesquisa' => "%$texto%"];
      
       $clientes = $gestor->EXE_QUERY('SELECT * FROM clientes WHERE nome or email 
                                       LIKE :pesquisa  ORDER BY nome asc LIMIT '.$item_inicial.','.$itens_pagina , $parametros); 
        $total_clientes = count($gestor->EXE_QUERY('SELECT * FROM clientes WHERE nome or email LIKE :pesquisa',$parametros ));
    }else{

        $clientes = $gestor->EXE_QUERY('SELECT * FROM clientes ORDER BY nome asc  LIMIT '.$item_inicial.',' .$itens_pagina);
        $total_clientes = count($gestor->EXE_QUERY('SELECT * FROM clientes'));
    }  
    
    
?>
 <div class="container ">
            <div class="row">

                 <div class="col-sm-8 col-4">
                     <h4 class="pt-3 pb-3">Lista de Clientes</h4>
                 </div>
         
                 <div class="col-sm-4 col-12 align-self-center">
                     <form action="?a=clientes_listagem" method="post">
                        <div class="form-inline">
                        <input type="text" 
                        name="text_pesquisa" 
                        class="form_control" 
                        placeholder="<?php if(isset($_SESSION['texto_pesquisa'])){ echo $_SESSION['texto_pesquisa'];}else echo 'Pesquisa'; ?>"
                        value="<?php if(isset($_SESSION['texto_pesquisa'])){ echo $_SESSION['texto_pesquisa'];}else echo ''; ?>">
                       <button class="btn btn-primary " > <i class="fa fa-search ml-3" aria-hidden="true"></i>  </button>
                       <a href="?a=clientes_listagem&clear=true" class="btn btn-primary " > <i class="fa fa-eraser ml-3" aria-hidden="true"></i>  </a>

                        </div>
                     </form>
                     
                 </div>
                   
    </div>
</div>
    
    <div class="container">
       
     
        <table class="container-fluid table table-striped table-dark">
            
        <?php funcoes::Paginacao('?a=clientes_listagem',$pagina,$itens_pagina,$total_clientes);?>
            <thead>
                <tr>
               
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Usuário</th>
                <th scope="col"></th>
               
                </tr>
            </thead>
            <tbody>
            <?php foreach ($clientes as $cliente): ?>
        
                <tr>

                <td><a href= "?a=clientes_dados&id=<?php echo $cliente['id_cliente'];?>"<i class="fa fa-info-circle"></i><?php echo' '.$cliente['nome']; ?></a></td>
                <td><?php echo $cliente['email']; ?></td>
                <td><?php echo $cliente['user']; ?></td>
                <td><a href="?a=clientes_eliminar&id=<?php echo $cliente['id_cliente'];?>"<i class="fa fa-trash"></a>

                </tr>
            <?php endforeach; ?>
                
            </tbody>
            </table>
                    
                
  
</div>