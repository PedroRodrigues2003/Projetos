<?php
 if(!isset($_SESSION)){
    session_start();
  }
  
 try{
     //configuração da conexão
    $host_config = 'mysql:host=localhost;port=3306;dbname=oficina';
    $dbusername = 'root';
    $dbpassword = '';
 
    //instancia um objeto PDO, conectando no MySQL
    $pdo = new PDO($host_config,$dbusername,$dbpassword);
    
    //montar a consulta SQL para recuperar todos os orçamentos cadastrados
    $sql = "SELECT *FROM orcamentos";

    //executar o comando sql e retorna para a $consulta
    $consulta = $pdo->query($sql);

    $lista_orcamentos = $consulta->fetchAll(PDO::FETCH_ASSOC);
 
    $pdo = null;
    }catch(PDOException $e){
         print "Erro! ".$e->getMessage()."<br>\n";
     }
     ?>
 