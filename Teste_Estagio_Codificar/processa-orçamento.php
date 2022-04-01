<?php
try{
    //configuração da conexão
   $host_config = 'mysql:host=localhost;port=3306;dbname=oficina';
   $dbusername = 'root';
   $dbpassword = '';

   //instancia um objeto PDO, conectando no MySQL
   $pdo = new PDO($host_config,$dbusername,$dbpassword);

   echo "<pre>";   
   print_r($_POST);
   echo "<pre>";

   $id = isset($_POST["inputId"])?$_POST["inputId"]:null;
   $descricao = isset($_POST["inputDescricao"])?$_POST["inputDescricao"]:null;
   $nome_Cliente = isset($_POST["inputNc"])?$_POST["inputNc"]:null;
   $nome_Vendedor = isset($_POST["inputNv"])?$_POST["inputNv"]:null;
   $preco = isset($_POST["inputPreco"])?$_POST["inputPreco"]:null;
   $horario = isset($_POST["inputHorario"])?$_POST["inputHorario"]:null;
   $btEnvio = isset($_POST["btEnvio"])?$_POST["btEnvio"]:null;
    
   if($btEnvio==="Cadastrar"){
       //executar a insercao dos dados
        //testar se as variaveis nao sao nulas
        if($descricao != null && $nome_Cliente != null && $nome_Vendedor != null && $preco != null && $horario != null  ){
            //insere no banco
            //comando para inserir
        
            $sql = "INSERT INTO orcamentos (preco,descricao,nome_Cliente,nome_Vendedor,horario) VALUES (:preco,:descricao,:nome_Cliente,:nome_Vendedor,:horario)";
            //usar o metodo prepared statement é mais viavel, pois tem muitos parametros
            //pre-processa o sql.Pode reutilizar o comando varias vezes com a variavel stmt,so muda os valores
            $stmt = $pdo->prepare($sql);

            //montar os dados para insercao

            $data=[
                "preco"=> $preco,
                "descricao"=> $descricao,
                "nome_Cliente"=> $nome_Cliente,
                "nome_Vendedor" => $nome_Vendedor,
                "horario" => $horario
            ];

            //executa o comando
            $stmt->execute($data);
            echo "Dados inseridos";
            header("Location:cadastro-orçamento.php");
        }else{
            echo "Dados nulos ou inseridos incorretamente<br>\n";
        }
    }//fim if cadastrar
    else if($btEnvio==="Atualizar"){

        //monta a consulta sql para atualizar
        $sql = "UPDATE orcamentos SET preco = :preco, descricao = :descricao, nome_Cliente = :nome_Cliente, nome_Vendedor = :nome_Vendedor, horario = :horario
        WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        //montar os dados para atualizar
        $data=[
            "id" => $id,
            "preco"=> $preco,
            "descricao"=> $descricao,
            "nome_Cliente"=> $nome_Cliente,
            "nome_Vendedor" => $nome_Vendedor,
            "horario" => $horario
        ];  
        //executa o comando passando os parametros que devem ser atualizados
        $stmt->execute($data);
        header("Location:cadastro-orçamento.php");
    }//fim else atualizar
   $pdo = null;
   header("Location:cadastro-orçamento.php");
   }catch(PDOException $e){
        print "Erro! ".$e->getMessage()."<br>\n";
    }
