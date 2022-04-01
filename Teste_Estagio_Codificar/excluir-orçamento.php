<?php
try{
    //configuração da conexão
   $host_config = 'mysql:host=localhost;port=3306;dbname=oficina';
   $dbusername = 'root';
   $dbpassword = '';

   //instancia um objeto PDO, conectando no MySQL
   $pdo = new PDO($host_config,$dbusername,$dbpassword);

   //recuperar o id que será excluido
   $id = isset($_GET['id'])  ? $_GET['id'] : null;
   echo $id;
   if($id!=null){
        //comando sql para deletar
        $sql = "DELETE FROM orcamentos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        //executa o comando

        $stmt->execute(["id" => $id]);
        header("Location:cadastro-orçamento.php");


   }else{
       echo "Dados invalidos";
   }
   $pdo = null;
   }catch(PDOException $e){
        print "Erro! ".$e->getMessage()."<br>\n";
    }
?>