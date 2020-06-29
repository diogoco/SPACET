<?php 
    // ========================================
    // funçõe estáticas
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    // ===========================================================
    class funcoes{

        // =======================================================
        public static function VerificarLogin(){
            //verifica se o user tem sessão ativa
            $resultado = false;
            if(isset($_SESSION['id_user'])){
                $resultado = true;
            }
            return $resultado;
        }

        // =======================================================
        public static function VerificarLoginCliente(){
            //verifica se o cliente tem sessão ativa
            $resultado = false;
            if(isset($_SESSION['id_cliente'])){
                $resultado = true;
            }
            return $resultado;
        }

        // =======================================================
        public static function IniciarSessao($dados){
            //iniciar a sessão
            $_SESSION['id_user'] = $dados[0]['id_user'];
            $_SESSION['nome'] = $dados[0]['nome'];
            $_SESSION['email'] = $dados[0]['email'];
            $_SESSION['permissoes'] = $dados[0]['permissoes'];
        }

        // =======================================================
        public static function IniciarSessaoCliente($dados){
            //iniciar a sessão do cliente
            $_SESSION['id_cliente'] = $dados[0]['id_cliente'];
            $_SESSION['nome_cliente'] = $dados[0]['nome'];
            $_SESSION['email_cliente'] = $dados[0]['email'];
        }

        // =======================================================
        public static function DestroiSessao(){
            //destroi as variáveis da sessão
            unset($_SESSION['id_user']);
            unset($_SESSION['nome']);
            unset($_SESSION['email']);
            unset($_SESSION['permissoes']);
        }

        // =======================================================
        public static function DestroiSessaoCliente(){
            //destroi as variáveis da sessão do cliente
            unset($_SESSION['id_cliente']);
            unset($_SESSION['nome_cliente']);
            unset($_SESSION['email_cliente']);
        }

        // =======================================================
        public static function CriarCodigoAlfanumerico($numChars){
            //cria um código aleatório alfanumérico
            $codigo='';
            $caracteres = 'abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ0123456789!?()-%';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0,strlen($caracteres)) , 1 );
            }
            return $codigo;
        }

        // =======================================================
        public static function CriarCodigoAlfanumericoSemSinais($numChars){
            //cria um código aleatório alfanumérico
            $codigo='';
            $caracteres = 'abcdefghijklmnoprstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ0123456789';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0,strlen($caracteres)) , 1 );
            }
            return $codigo;
        }

        // =======================================================
        public static function CriarLOG($mensagem, $user){
            //cria um registo em LOGS
            $gestor = new cl_gestorBD();
            $data_hora = new DateTime();
            $parametros = [
                ':data_hora'        => $data_hora->format('Y-m-d H:i:s'),
                ':user'             => $user,
                ':mensagem'         => $mensagem
            ];
            $gestor->EXE_NON_QUERY(
                'INSERT INTO logs(data_hora, user, mensagem)
                 VALUES(:data_hora, :user, :mensagem)', $parametros);
        }

        // =======================================================
        public static function Permissao($index){
            //verifica se o user com sessão ativa, tem permissão para a funcionalidade
            if(substr($_SESSION['permissoes'], $index, 1) == 1){
                return true;
            } else{
                return false;
            }
        }
        public static function Paginacao($source, $pagina_atual, $itens_pagina, $total_itens){
            //criar e controlar o mecanismo de paginaçao para as apresentaçoes de tabelas 
            $max_paginas =ceil($total_itens/$itens_pagina);
    
            
          echo '<div>';
          //pagina anterior
                  if($pagina_atual==1){
                     echo '<a href="'.$source.'&pagina='.($pagina_atual).'"><i class="fa fa-backward text-muted"></i></a>';
                  }else {
                      echo '<a href="'.$source.'&pagina='.($pagina_atual-1).'"><i class="fa fa-backward"></i></a>';
                  }
                  echo ' | ';
                  //pagina seguinte
                  if($pagina_atual == $max_paginas){

                    echo '<a href="'.$source.'&pagina='.($pagina_atual).'"><i class="fa fa-forward text-muted"></i></a>';
                }else {
                    echo '<a href="'.$source.'&pagina='.($pagina_atual+1).'"><i class="fa fa-forward"></i></a>';
                }



          // << | >>
          echo '</div';

        }
    }
     

?>