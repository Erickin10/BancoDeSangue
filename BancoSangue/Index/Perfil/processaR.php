<?php

    session_start();

    require_once '../Classes/usuarios.php';
    $usuario = new Usuario;
    global $pdo;

    $idLogado = $_SESSION['idUsuario'];

    $usuario ->conectar('banco-sangue','localhost','root','');
    
    if($usuario-> msgError == '' ){ 

        $tipoSangueR = filter_input(INPUT_POST, 'tipoSangueR', FILTER_SANITIZE_STRING);
        $idadeR = filter_input(INPUT_POST, 'idadeR', FILTER_SANITIZE_NUMBER_INT);
        
        $sql = $pdo->prepare("INSERT INTO dadosreceptor (tipoSangueR, idadeR, idUsuarioR) 
        VALUES ('$tipoSangueR', $idadeR, $idLogado)"); 
        $sql ->execute();

        header('location: perfil.php');

    } else{
        ?>
        <div class="error_msg">  <?php echo "Erro :" .$usuario -> msgError; ?> </div>    
        <?php
    }
/*

    $usuario ->conectar('banco-sangue','localhost','root','');
                    
    if($usuario-> msgError == '' ){ 
    
        codigos

    } else{
        ?>
        <div class="error_msg">  <?php echo "Erro :" .$usuario -> msgError; ?> </div>    
        <?php
    }

*/