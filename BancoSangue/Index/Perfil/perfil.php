<?php 
    session_start();
    
    if(!isset($_SESSION['idUsuario']) == true && !isset($_SESSION['user']) == true){
        
        unset($_SESSION['idUsuario']);
        unset($_SESSION['user']);
        header('location: index.php ');   
    } else{
        
        //print_r ($_SESSION);
        $idLogado = $_SESSION['idUsuario'];
        $userLogado = $_SESSION['user'];
        
        require_once '../Classes/usuarios.php';
        $usuario = new Usuario;

        $usuario ->conectar('banco-sangue','localhost','root','');
        if($usuario-> msgError == '' ){ 
    
            //echo "segue a vida";
    
        } else{
            ?>
            <div class="error_msg">  <?php echo "Erro :" .$usuario -> msgError; ?> </div>    
            <?php
        }

        //echo "Olá " . $userLogado;
    }      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-perfil.css">
    <title>Document</title>
</head>
<body>
    
    <h1> Bem vindo, <?php echo $userLogado ?> </h1>

    <?php
    //DADOS RECEPTOR
    if($usuario ->verificaDadosRecep($idLogado) == false){
    ?>
        <div>
            <table border="2px" class="tabela_add_recep"> <?php //TABELA ADICIONAR RECEPTOR ?>
            <tr>
                    <th>
                        Adicione seus dados como Receptor:
                    </th>    
                </tr>
                
                <tr> 
                    <td>    
                        <form method="POST" action="processaR.php">
                            
                            <div id="dadosReceptorDiv">

                                <p><label for="ctipoSangueR">Tipo Sanguineo: </label> 
                                    <input type="text" name="tipoSangueR" id="ctipoSangueR" placeholder="Ex: AB-"></p>
                                                
                                <p><label for="cidadeR">Idade: </label> 
                                    <input type="number" name="idadeR" id="cidadeR" placeholder="Ex: 23"></p>
                                <input type="submit" value="Cadastrar">
                            </div>
                            
                        </form>
                    </td>
                </tr>
            </table> 
        </div>
    <?php
    } else{
        global $pdo;

        $sql = $pdo->prepare("SELECT * FROM dadosreceptor WHERE idUsuarioR = $idLogado ");
        $sql ->execute();

        $sql_code = "SELECT * FROM dadosreceptor WHERE idUsuarioR = $idLogado LIMIT 1";
        $sql_exec = $pdo->query($sql_code) or die ($pdo->error);                
        $usuario = $sql_exec->fetch();

        if( is_array($usuario) ) {

            $tipoSangueR = $usuario['tipoSangueR'];
            $idadeR = $usuario['idadeR'];
            ?>

            <div>
                <table border="2px" class="tabela_mostra_recep"> <?php //TABELA MOSTRAR RECEPTOR ?>

                    <tr>
                        <th>
                            Seus dados de Receptor
                        </th>    
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Tipo Sanguineo: <?php echo $tipoSangueR;?></p>  
                            <p>Idade: <?php echo $idadeR;?></p>
                        </td>
                    </tr>

                </table>
            </div>

        <?php
        }
        ?>

    <?php    
    }
    ?>
        
    <?php
    // DADOS DOADOR
    $usuario = new Usuario;  
    if($usuario ->verificaDadosDoador($idLogado) == false){
    ?>
        <div>
        <table border="2px" class="tabela_add_doador"> <?php //TABELA ADICIONAR DOADOR ?>
            <tr>
                <th>
                    Adicione seus dados como Doador:
                </th>    
            </tr>

            <tr>
                <td>
                    <form method="POST" action="processaD.php"> 
                            
                        <p><label for="ctipoSangueD">Tipo Sanguineo: </label> 
                            <input type="text" name="tipoSangueD" id="ctipoSangueD" placeholder="Ex: AB-"></p>

                        <p><label for="cidadeD">Idade: </label> 
                            <input type="number" name="idadeD" id="cidadeD" placeholder="Ex: 23"></p>

                        <p><label for="cPeso">Peso: </label> 
                            <input type="float" name="peso" id="cPeso" placeholder="Ex: 73.4"></p>

                        <fieldset id="tatuagem">
                            <legend>Possui tatuagem?</legend> 
                                <input type="radio" name="tatuagem" id="cSimt"> <label for="cSimt"> Sim </label>
                                <input type="radio" name="tatuagem" id="cNaot"> <label for="cNaot"> Não </label>
                        </fieldset>
                                                    
                        <fieldset id="hepatite">
                            <legend>Já teve hepatite após os 11 anos?</legend> 
                                <input type="radio" name="hepatite" id="cSimh"> <label for="cSimh"> Sim </label>
                                <input type="radio" name="hepatite" id="cNaoh"> <label for="cNaoh"> Não </label>
                        </fieldset>
                                            
                        <fieldset id="dst">
                            <legend>Possui alguma DST?</legend> 
                                <input type="radio" name="dst" id="cSimd"> <label for="cSimd"> Sim </label>
                                <input type="radio" name="dst" id="cNaod"> <label for="cNaod"> Não </label>
                        </fieldset>
                                            
                        <fieldset id="htlv">
                            <legend>Possui alguma doença ligada ao viruz HTLV 1 e 2?</legend> 
                                <input type="radio" name="htlv" id="cSimv"> <label for="cSimv"> Sim </label>
                                <input type="radio" name="htlv" id="cNaov"> <label for="cNaov"> Não </label>
                        </fieldset>

                        <input type="submit" value="Cadastrar">                       
                            
                    </form>
                </td>
            </tr>
        </table>
        </div>
        
    <?php
    } else{
        global $pdo;

        $sql = $pdo->prepare("SELECT * FROM dadosdoador WHERE idUsuarioD = $idLogado ");
        $sql ->execute();

        $sql_code = "SELECT * FROM dadosdoador WHERE idUsuarioD = $idLogado LIMIT 1";
        $sql_exec = $pdo->query($sql_code) or die ($pdo->error);                
        $usuario = $sql_exec->fetch();

        if( is_array($usuario) ) {

            $tipoSangueD = $usuario['tipoSangueD'];
            $idadeD = $usuario['idadeD'];
            $peso = $usuario['peso'];
            $tatuagemD = $usuario['tatuagem'];
            $doencas = $usuario['doencas'];

            if($tatuagemD == 1){
                $tatuagemD = 'Sim';
            } else{
                $tatuagemD = 'Não';
            }

            if($doencas == 1){
                $doencas = 'Sim';
            } else{
                $doencas = 'Não';
            }
            ?>
            <div>  
            <table border="2px" class="tabela_mostra_doador"> <?php //TABELA MOSTRAR DOADOR ?>

                <tr>
                    <th>
                        Seus dados de Doador
                    </th>    
                </tr>

                <tr> 
                    <td>
                        <p>Tipo Sanguineo: <?php echo $tipoSangueD;?></p>  
                        <p>Idade: <?php echo $idadeD;?></p>
                        <p>Peso: <?php echo $peso;?></p>
                        <p>Possui tatuagem: <?php echo $tatuagemD;?></p>
                        <p>Possui alguma doença: <?php echo $doencas;?></p>
                    </td>
                </tr>    
            </table>

            
            </div>  
        <?php
        }
        ?>
            
    
    <?php    
    }
    ?>
    <a href="sair.php" class="btn"> Sair </a>
  

</body>
</html>