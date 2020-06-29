<?php 
    // ========================================
    // setup - inserir user
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    } 

    //inserir o user admin
    $gestor = new cl_gestorBD();

    //limpar os dados dos user
    $gestor->EXE_NON_QUERY('DELETE FROM user');
    $gestor->EXE_NON_QUERY('ALTER TABLE user AUTO_INCREMENT=1');

    $data = new DateTime();
    
    //---------------------------------------------------------
    //user 1 - admin
    //definição de parametros
    $parametros = [
        ':user'       => 'admin',
        ':palavra_passe'    => md5('admin'),
        ':nome'             => 'Administrador',
        ':email'            => 'spacetproject@gmail.com',
        ':permissoes'       => str_repeat('1', 100),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    //inserir o user
    $gestor->EXE_NON_QUERY(
        'INSERT INTO user(user, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:user, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //---------------------------------------------------------
    //user 2 - joao
    //definição de parametros
    $parametros = [
        ':user'             => 'joao',
        ':palavra_passe'    => md5('joao'),
        ':nome'             => 'João Ribeiro',
        ':email'            => 'joao.ribeiro@gmail.com',
        ':permissoes'       => str_repeat('1', 100),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    //inserir o user
    $gestor->EXE_NON_QUERY(
        'INSERT INTO user(user, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:user, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);


    //---------------------------------------------------------
    //user 3 - ana
    //definição de parametros
    $parametros = [
        ':user'       => 'ana',
        ':palavra_passe'    => md5('ana'),
        ':nome'             => 'Ana Cardoso',
        ':email'            => 'ana.cardoso@gmail.com',
        ':permissoes'       => '0'.str_repeat('1', 99),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    //inserir o user
    $gestor->EXE_NON_QUERY(
        'INSERT INTO user(user, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:user, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

    //---------------------------------------------------------
    //user 4 - antonio
    //definição de parametros
    $parametros = [
        ':user'       => 'antonio',
        ':palavra_passe'    => md5('antonio'),
        ':nome'             => 'António Santos',
        ':email'            => 'antonio.santos@gmail.com',
        ':permissoes'       => '0'.str_repeat('1', 99),
        ':criado_em'        => $data->format('Y-m-d H:i:s'),
        ':atualizado_em'    => $data->format('Y-m-d H:i:s')
    ];

    //inserir o user
    $gestor->EXE_NON_QUERY(
        'INSERT INTO user(user, palavra_passe, nome, email, permissoes, criado_em, atualizado_em)
         VALUES(:user, :palavra_passe, :nome, :email, :permissoes, :criado_em, :atualizado_em)',
         $parametros);

        
?>

