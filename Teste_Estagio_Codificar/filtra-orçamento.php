<?php
if(!isset($_SESSION)){
    session_start();
  }
//recebe o filtro que foi passado pela url e seta os outros como null
 $nome_Vendedor = isset($_POST["filtro_Vendedor"])?$_POST["filtro_Vendedor"]:null;
 $nome_Cliente = isset($_POST["filtro_Cliente"])?$_POST["filtro_Cliente"]:null;
 $data_inicial = isset($_POST["filtro_Data_inicial"])?$_POST["filtro_Data_inicial"]:null;
 $data_final = isset($_POST["filtro_Data_final"])?$_POST["filtro_Data_final"]:null;
 //joga na sessão as variaveis encontradas
 $_SESSION["nome_Vendedor"]=$nome_Vendedor;
 $_SESSION["nome_Cliente"]=$nome_Cliente;
 $_SESSION["data_inicial"]=$data_inicial;
 $_SESSION["data_final"]=$data_final;

 header("Location:cadastro-orçamento.php");
?>