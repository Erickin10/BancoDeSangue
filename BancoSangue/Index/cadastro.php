<?php
    require_once 'Classes/usuarios.php';
    $usuario = new Usuario; //instanciando
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="cbc-cad">
        <img class="cbc-cad-img" src="Imagens/trans.png" alt="">
        <h1>Cadastro</h1>
    </header>
    <div class="estrutura-cad">
          <form method="POST">

              <input type="text" name="nome" placeholder="Nome Completo" maxlength="30">
              <input type="text" name="user" placeholder="Nome de usuário" maxlength="30">
              <input type="password" name="senha" placeholder="Senha" maxlength="15">
              <input type="password" name="confirmarSenha" placeholder="Confirmar Senha" maxlength="15">
              <input type="submit" value="Cadastrar!">  <br>

         </form>
    </div>
<?php
// vamos verificar se o usuario clicou em "cadastrar"
if (isset($_POST['nome']))
{
    $nome = addslashes($_POST['nome']); //usamos addslashes para passar esses dados com mais segurança

    $user = addslashes($_POST['user']); 

    $senha = addslashes($_POST['senha']);

    $confirmarSenha = addslashes($_POST['confirmarSenha']);
   
    // agora vamos verificar se o usuario deixou algum campo em branco

    if(!empty($nome) && !empty($user) && 
    !empty($senha) && !empty($confirmarSenha) ){ // usamos !empty para saber se os dados recebidos estao vazios ou não   

        $usuario ->conectar('banco-sangue','localhost','root','');
        if($usuario-> msgError == '' ){// se a mensagem estiver vazia, deu tudo certo
            if($senha == $confirmarSenha){
                if($usuario ->cadastrar($nome,$user, $senha)){
                    ?>
                    <div class="sucess_msg"> Cadastrado com sucesso! </div>
                    <?php
                     header("refresh: 2; url=index.php");
                } else{
                    ?>
                    <div class="error_msg"> Você ja está cadastrado! </div>
                    <?php
                }
            } else {
                ?>
                <div class="error_msg"> As senhas não coincidem!   </div>
                <?php
            }
           
        } else {
            ?>
            <div class="error_msg"> <?php echo "Erro: ".$usuario->msgError; ?>  </div>
            <?php
            
        }

}   

else{
     ?>
    <div class="error_msg">Por favor, Preecha todos os campos! </div>
    <?php
}
}

?>

</body> 
</html>