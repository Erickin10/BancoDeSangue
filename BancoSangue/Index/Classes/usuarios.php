<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
    Class Usuario{

        private $pdo;
        public $msgError = '';
        
        //FUNÇÃO PARA CONECTAR COM O BANCO DE DADOS
        public function conectar ($nome,$host,$user,$senha){
            global $pdo; 
            global $msgError;
           try {
                 $pdo = new PDO('mysql:dbname='.$nome. '; host='.$host, $user, $senha);
            } catch (PDOException $th) {
                $msgError = $th -> getMessage();
            }
           
        }

        public function verificaDadosRecep ($idLogado){
            global $pdo; 

            $sql = $pdo->prepare("SELECT * FROM dadosreceptor WHERE idUsuarioR = $idLogado");
            $sql->execute();

            if ($sql->rowCount() > 0){
                return true;
            } else{
                return false;
            }
        }

        public function verificaDadosDoador ($idLogado){
            global $pdo; 

            $sql = $pdo->prepare("SELECT * FROM dadosdoador WHERE idUsuarioD = $idLogado");
            $sql->execute();

            if ($sql->rowCount() > 0){
                return true;
            } else{
                return false;
            }
        }

        //FUNÇÃO PARA CADASTRAR UM USUARIO
        public function cadastrar($nome,$user,$senha){
            global $pdo; 

            //verifica cadastro
            $sql = $pdo->prepare("SELECT idUsuario FROM usuario WHERE user = '$user' "); 
            $sql ->execute();   

            if ($sql->rowCount() > 0){  //rowCount vai contar quantas linhas do BD foram retornadas 
                return false; //se já for cadastrada
            } 

            else{ // se a pessoa não for cadastrada

                $senhac = password_hash($senha, PASSWORD_DEFAULT);
                $sql = $pdo->prepare("INSERT INTO usuario (nome, user, senha) VALUES ('$nome', '$user', '$senhac')"); 
                $sql ->execute();

                return true; //cadastrado com sucesso
            }

        }

        //FUNÇÃO PARA LOGAR UM USUARIO
        public function logar($user, $senha){
            global $pdo; 

            //verifica se usuario digitado é compativel com o do BD
            $sql = $pdo->prepare("SELECT idUsuario FROM usuario WHERE user = '$user'");
            $sql->execute();


            if($sql ->rowCount() > 0 ){

                // verifica se a senha digitada é compativel com a criptografada do BD
                $sql_code = "SELECT * FROM usuario WHERE user = '$user' LIMIT 1";
                $sql_exec = $pdo->query($sql_code) or die ($pdo->error);                
                $usuario = $sql_exec->fetch();
                if(password_verify($senha, $usuario['senha'])){  

                        //se o usuario estiver cadastrado devemos iniciar uma sessão que apenas ele podera acessar
                        //$dado = $sql->fetch();
                        session_start();
                        $_SESSION['idUsuario'] = $usuario['idUsuario'];
                        $_SESSION['user'] = $usuario['user'];
                        return true;  //login feito

                }
                else{

                    return false; //login não pode ser feito
                }
            } 
            else{   
                return false; //login não pode ser feito
            }  
        }
    }

                   

?>

</body>
</html>