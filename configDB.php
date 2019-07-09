<?php

//Variaveis de conexão com o banco de dados
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "sistemaLogin";

//objeto Mysqli de conexão com o bando
$conexão = new mysqli($dbhost,$dbuser,$dbpass,$dbname );

if ($conexão->connect_error){
    // se deu erro, mata a aplicação
    die("Não foi possível conectar ao banco de dados: " . $conexão ->connect_error );
} else{
    //só pra debug
    echo "Conectado com sucesso";
}