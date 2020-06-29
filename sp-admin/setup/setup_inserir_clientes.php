<?php 
    // ========================================
    // setup - inserir user
    // ========================================

    // verificar a sessao
    if(!isset($_SESSION['a'])){
        exit();
    } 

    //inserir o user admin
    $gestor = new cl_gestorBD();

    //limpar os dados dos user
    $gestor->EXE_NON_QUERY('DELETE FROM clientes');
    $gestor->EXE_NON_QUERY('ALTER TABLE clientes AUTO_INCREMENT=1');

    $data = new DateTime();
    
    $numero_clientes =1000;

    $femininos = [
   'Alana', 'Beatriz','Ana Vitoria','Maria Luiza','Bianca','Beatriz',
   'Camila','Milena','Elisa', 'Helena','Esther', 'Miriam','Giulia', 'Giovana',
   'Lauren', 'Sophia','Larissa',  'Melissa','Leticia', 'Alicia','Lia' , 'Lis','Livia' , 
   'Laila','Lavinia' ,'Lara','Luana', 'Giovana', 'Marcela' ,'Amelia','Manuela', 'Heloisa',
   'Mirela' , 'Milena', 'Olivia' , 'Sophia'
    ];

    $masculinos=['Alexandre','Eduardo','Henrique','Murilo','Theo',
    'Andre','Enrico','Henry','Nathan','Thiago',
    'Antônio','Enzo','Ian','Otávio','Thomas',
    'Augusto','Erick','Isaac','Pietro','Vicente',
    'Breno','Felipe','Joao','Rafael','Vinicius',
    'Bruno','Fernando','Kaique','Raul','Vitor',
    'Caio','Francisco','Leonardo','Rian','Yago',
    'Caua','Frederico','Luan','Ricardo','Ygor',
    'Daniel','Guilherme','Lucas','Rodrigo','Yuri',
    'Danilo','Gustavo','Mathias','Samuel'];
        
    $sobrenomes = [
   'Souza',
   'Costa',
   'Santos',
   'Oliveira',
   'Pereira',
   'Rodrigues',
   'Almeida',
   'Nascimento',
   'Lima',
   'Araújo',
   'Fernandes',
   'Carvalho',
   'Gomes',
   'Martins',
   'Rocha',
   'Ribeiro',
   'Alves',
   'Monteiro',
   'Mendes',
   'Barros',
   'Freitas',
   'Barbosa',
   'Pinto',
   'Moura',
   'Cavalcanti',
   'Dias',
   'Castro',
   'Campos',
   'Cardoso',
   'Silva'];

   for($i=0; $i < $numero_clientes; $i++){
       $genero = rand(1,2);

       $nome = '';
        
       if($genero==1){
           $nome = $masculinos[rand(0,count($masculinos)-1)];
           $nome.=' '.$sobrenomes[rand(0,count($sobrenomes)-1)];
           $nome.=' '.$sobrenomes[rand(0,count($sobrenomes)-1)];
       }
       if($genero==2){
          $nome = $femininos[rand(0,count($femininos)-1)];
          $nome.=' '.$sobrenomes[rand(0,count($sobrenomes)-1)];
          $nome.=' '.$sobrenomes[rand(0,count($sobrenomes)-1)];
        }

        $email = strtolower(substr($nome,0,10)). rand(1,100) . "gmail.com";
        $email = str_replace(' ', '.', $email);

        $user = str_replace(' ','',strtolower(substr($nome,0,6)).rand(1,1230));
        $senha = md5("123");
        $codigo_validacao = funcoes::CriarCodigoAlfanumericoSemSinais(10);
        $validada = 1;

        $parametros = [
            ':nome'             =>$nome,
            ':email'            =>$email,
            ':user'             =>$user,
            ':palavra_passe'    =>$senha,
            ':codigo_validacao' =>$codigo_validacao,
            ':validada'         =>$validada,
            ':criado_em'        =>DATAS::DataHoraAtualBD(),
            ':atualizado_em'    =>DATAS::DataHoraAtualBD()
           
           
            

        ];

        $gestor->EXE_NON_QUERY('INSERT INTO clientes (nome,email,user,palavra_passe,codigo_validacao,validada,criado_em,atualizado_em) 
        VALUES (:nome,:email,:user,:palavra_passe,:codigo_validacao,:validada,:criado_em,:atualizado_em)',$parametros); 
   }    

        
?>


<?php include_once('setup/setup.php'); ?>