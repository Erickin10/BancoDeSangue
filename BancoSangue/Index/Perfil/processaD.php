<?php

    session_start();

    require_once '../Classes/usuarios.php';
    $usuario = new Usuario;
    global $pdo;

    $idLogado = $_SESSION['idUsuario'];

    $usuario ->conectar('banco-sangue','localhost','root','');
    
    if($usuario-> msgError == '' ){ 

        $tipoSangueD = filter_input(INPUT_POST, 'tipoSangueD', FILTER_SANITIZE_STRING);
        $idadeD = filter_input(INPUT_POST, 'idadeD', FILTER_SANITIZE_NUMBER_INT);
        $tatuagem = filter_input(INPUT_POST, 'tatuagem', FILTER_DEFAULT);
        $peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_NUMBER_FLOAT);
        $hepatite = filter_input(INPUT_POST, 'hepatite', FILTER_DEFAULT);
        $dst = filter_input(INPUT_POST, 'dst', FILTER_DEFAULT);
        $htlv = filter_input(INPUT_POST, 'htlv', FILTER_DEFAULT);

        if($tatuagem == 'Sim'){
            $tatuagemD = true;
        } else{
            $tatuagemD = false;
        }

        if($hepatite == 'Não' && $dst == 'Não' && $htlv == 'Não'){

            $doencasD = false;

        } else{

            $doencasD = true;

        }

        
        $sql = $pdo->prepare("INSERT INTO dadosdoador (tipoSangueD, tatuagem, doencas, peso, idadeD, idUsuarioD) 
        VALUES ('$tipoSangueD', '$tatuagemD', '$doencasD', '$peso', $idadeD, $idLogado)"); 
        $sql ->execute();

        header('location: perfil.php');
    } else{
        ?>
        <div class="error_msg">  <?php echo "Erro :" .$usuario -> msgError; ?> </div>    
        <?php
    }