<?php

//importando as configur~çãoes de banco de dados 
require_once 'configDB.php';

function verirficar_entrada($entrada){
    
    $saida = trim($entrada); // remove os espaçoes
    $saida = htmlspecialchars($saida);// Remove html
    $saida = strip_tags($saida); // remove as barras
    return $saida;
}

if (isset($_POST['action']) && $_POST['action'] == 'resgitro'){
    
    $nomeCompleto = verirficas_entrada($_POST['nomeCompleto']);
    $nomeUsuario = verificar_entrada($_POST['nomeUsuario']);
    $emailUsuario = verificar_entrada($_POST['emailUsuario']);
    $senhaUsuario = verificar_entrada ($_POST['senhaUsuario']);
    $senhaUsuarioConfirmar = verificar_entrada ($_POST['senhaUsuarioConfirmar']);
    $criado = date ("Y-m-d"); // Cria uma data ano
    
    //Gerar um has para senha
    $senha = sha1($senhaUsuario);
    $senhaConfirmar = sha1($senhaUsuarioConfirmar);
    
    echo "Hash: " . $senha;
    
    //Conferencia da senha back-end, javascript
    // estar desabilitado
    if($senha !=  $senhaConfirmar){
        echo "as senhas não conferem";
        exit();
    } else{
        //Verificando se o usuario existe no banco de dados
        //usando Mysqli prepared statment
        $sql = $conexão->prepare ("SELECT nomeUsuario, email FROM" .
                "usuario WHERE nomeUsuario = ? OR" . "email = ?"); //Evitar sql injection
        $sql-> bind_param("ss", $nomeUsuario, $emailUsuario);
        $sql->execute(); //Método do objeto $sql
        $resultado = $sql->get_result();//Tabela do banco
        $linha = $resultado-> fetch_array(MYSQLI_ASSOC);
        if($linha['nomeUsuario'] == $nomeUsuario)
            echo "Nome {$nomeUsuario} indisponivel.";
            elseif($linha['email'] == $emailUsuario)
                echo "e-mail {$emailUsuario} indisponivel.";
            else{
                //Preparar a inserção no banco de dados
                $sql = $conexão->prepare("INSERT INTO usuario" . "(nome, nomeUsuario, email, senha, criado)"
                        . "VALUES(?, ?, ?, ?, ?)");
                $sql->bind_param("sssss", $nomeCompleto, $nomeUsuario, $emailUsuario, $senha, $criado);
                
                if($sql->execute()){
                    echo "Cadastrado com sucesso";
                } else{
                    echo "algo de errado não ta certo";
                }
            }
        
        
    }
    
    
}

