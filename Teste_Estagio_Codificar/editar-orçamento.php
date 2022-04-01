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

   //recuperar o id que será atualizado
   $id = isset($_GET['id'])  ? $_GET['id'] : null;
   if($id!=null){
        //comando sql para buscar o registro de id especifico
        $sql = "SELECT *FROM orcamentos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        //executa o comando

        $registro = $stmt->execute(["id" => $id]);

        //retornar um registro em forma de array associativo
        $orcamento = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //envia os dados do orçamento para a sessao.Se row count conseguir encontrar,vai dar 1
        if($stmt->rowCount()>0){
            $_SESSION["orcamento"] = $orcamento;
        }
      
        header("Location:cadastro-orçamento.php");


   }else{
       echo "Dados invalidos";
   }
   

    $pdo = null;
    }catch(PDOException $e){
         print "Erro! ".$e->getMessage()."<br>\n";
     }
     ?>