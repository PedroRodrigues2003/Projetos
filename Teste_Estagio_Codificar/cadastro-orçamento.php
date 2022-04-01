<?php

require_once "consultar-orçamento.php";

if(!isset($_SESSION)){
  session_start();
}
//recuperando a variavel da pagina atual para fazer a paginacao
if(isset($_GET["nP"])){
  $nP=$_GET["nP"];
}else{
  $nP=1;
}
//logica para paginacao
$pagina_Atual=$nP;
$qt_total_orcamento=count($lista_orcamentos );
$qt_orcamento_pg=6;
$qt_pg=ceil($qt_total_orcamento/$qt_orcamento_pg);
$inicio=($qt_orcamento_pg*$pagina_Atual)-$qt_orcamento_pg;
//recuperando os dados dos filtros de pesquisa

$filtro_Nome_vendedor=isset($_SESSION["nome_Vendedor"])?$_SESSION["nome_Vendedor"]:null;
$filtro_Nome_cliente=isset($_SESSION["nome_Cliente"])?$_SESSION["nome_Cliente"]:null;
$filtro_Data_final=isset($_SESSION["data_final"])?$_SESSION["data_final"]:null;
$filtro_Data_inicial=isset($_SESSION["data_inicial"])?$_SESSION["data_inicial"]:null;

//exclui os filtros da sessao
unset($_SESSION["nome_Vendedor"]);
unset($_SESSION["nome_Cliente"]);
unset($_SESSION["data_final"]);
unset($_SESSION["data_inicial"]);

//recupera os dados do orçamento a ser editado
$orcamento = isset($_SESSION["orcamento"])? $_SESSION["orcamento"]: null;
//exclui o orçamento da sessao
unset($_SESSION["orcamento"]);

// recuperar os dados do orcamento especifico que foi pedido para editar 
if($orcamento!=null){
  //configuracao para editar
    $id_editar = $orcamento["id"];
    $descricao_editar = $orcamento["descricao"];
    $preco_editar = $orcamento["preco"];
    $nome_Cliente_editar = $orcamento["nome_Cliente"];
    $nome_Vendedor_editar = $orcamento["nome_Vendedor"];
    $horario_editar = $orcamento["horario"];

    //configuracoes do botao
    $texto_bt= "Atualizar";
    $cor_bt= "info";
}else{
  //como a mesma variavel sera usada na opcao de cadastro,é so setar elas como nulas
  $id_editar = null;
  $descricao_editar = null;
  $preco_editar = null;
  $nome_Cliente_editar = null;
  $nome_Vendedor_editar = null;
  $horario_editar = null;
  $texto_bt= "Cadastrar";
  $cor_bt= "success";
}

?>
<!doctype html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Cadastro de Orçamento</title>
  </head>
<!-- CSS para corrigir bug do chrome ao tremer a página algumas vezes
        Gera uma barra de rolamento porem foi a unica solucao que  cosegui encontrar para resolver o bug que é do proprio navegador
        Em outros navegadores(opera,firefox,etc) não ocorre este bug
 -->
 <style>
    .all{
      height:100%;
       overflow-y: scroll;
    }
  </style>
  <body>

  <div class="container">
        <table class="table table-hover">
            <thead class="thead-light">
                <tr">
                    <th class="text-right" scope="col">Filtros para visualização da tabela</th>
                    <th scope="col"></th>
                </tr>   
            </thead>
        <tbody> 
          <!-- Filtro nome vendedor-->
            <tr>
                <form action="filtra-orçamento.php" method="POST">
                <td class="text-left">Pelo nome do vendedor</th>
                <td class="text-center"><input type="text" class="form-control" name ="filtro_Vendedor" value = "" id =""  required></td>
                <td class="text-right"><button class="btn btn-outline-primary col-md-5" type="submit" name="btFiltro">Filtrar</button> </td> 
                </form>
            </tr>
            <!-- Filtro nome cliente-->
            <tr>
            <form action="filtra-orçamento.php" method="POST">
                <td class="text-left">Pelo nome do cliente</th>
                <td class="text-center"><input type="text" class="form-control" name ="filtro_Cliente" value = "" id =""  required></td>
                <td class="text-right"><button class="btn btn-outline-primary col-md-5" type="submit" name="btFiltro">Filtrar</button> </td> 
                </form>
            </tr>
            <!-- Filtro data-->
            <tr >
            <form action="filtra-orçamento.php" method="POST">
                <td class="text-left">Pela data</th>
                <td class="text-center"><input type="text" class="form-control" name ="filtro_Data_inicial" value = "" id ="" placeholder="Data inicial: ano/mes/dia" required><input type="text" class="form-control" name ="filtro_Data_final" value = "" id =""  placeholder="Data final: ano/mes/dia" required></td>
                <td class="text-right"><button class="btn btn-outline-primary col-md-5" type="submit" name="btFiltro">Filtrar</button> </td> 
                </form>
            </tr>
            
        </tbody>
        </table>
</div>

<div class ="all">
        <div class="container ">
            <h1 class="display-6 text-secondary text-center">Cadastro de Orçamentos</h1>

  </div>
    
    <!-- Form  cadastrar/atualizar-->
    
      <div class="container col-md-7 " style="display: flex; justify-content: flex-end"  >
    
          <form action="processa-orçamento.php" method="POST">

            <!--Input escondido para armazenar e enviar o id a ser atualizado -->
            <input type="hidden"  name ="inputId" value = "<?=$id_editar?>">
            <!-- Row 1 -->
            <div class="form-row">
                <div class="form-group col-md-10">
                  <label for="inputDescricao">Descrição</label>
                  <input type="text" class="form-control" name ="inputDescricao" value = "<?=$descricao_editar?>"  id ="inputDescricao" placeholder=
                  "Ex:Fusca com parabrisa trincado,rodas desalinhadas e lataria amassada" required>
                </div>

            </div>

            <!-- Row2 -->
            <div class="form-row">

              <div class="form-group col-md-3 mr-3 ">
                  <label for="inputPreco">Preço</label>
                  <input type="number" class="form-control" name ="inputPreco" value = "<?=$preco_editar?>"  id ="inputPreco" placeholder="1,00" step="0.01" min="0" required>
              </div>
              <div class="col-md-3 mr-5">
                <div class="form-group">
                  <label for="inputPreco">Nome do Cliente</label>
                  <input type="text" class="form-control" name ="inputNc" value = "<?=$nome_Cliente_editar?>"  id ="inputNc" placeholder="Seu Zé"  required>
                </div>
              </div>
              
              <div class="form-group col-md-3 mr-3">
                <label for="inputQt">Nome do vendedor</label>
                <input type="text" class="form-control" name ="inputNv" value = "<?=$nome_Vendedor_editar?>" id ="inputNv"   placeholder="Paulão" required>
              </div>

            </div>

            <!-- Row 3 -->
            <div class="form-row">

              <div class="form-group col-md-10 mr-3">
                <label for="inputQt">Data(obrigatório) e Horário(opcional)</label>
                <input type="text" class="form-control" name ="inputHorario" value = "<?=$horario_editar?>" id ="inputHorario"   placeholder="Deve ser inserido no seguinte formato : ano/mes/dia hora:minuto:segundo" required>
              </div>

            </div>
            <!-- Row 4 -->
            <div class="form-row justify-content-left mt-4">
    
                <button class="btn btn-outline-<?=$cor_bt?> col-md-10" type="submit" value="<?=$texto_bt?>" name="btEnvio"><?=$texto_bt?></button>  
            </div>
      
        </form>

      </div>
        
  </div> <!-- Fim do form -->
  <?php 
    if(isset($lista_orcamentos) && count($lista_orcamentos)>0){
?>
        <!-- Table -->
        <div class="container">
        <table class="table table-hover mt-5">
            <thead class="thead-light">
                <tr class="text-center">
                    <th scope="col">Código</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Nome do vendedor</th>
                    <th scope="col">Nome do cliente</th>
                    <th scope="col">Horário</th>
                    <th scope="col"></th>
                </tr>   
            </thead>
        <tbody>
        <?php 
            $qt_orcamentos=count($lista_orcamentos);
            
            for($i=$inicio;$i<$inicio+$qt_orcamento_pg;$i++){ 
              if($i<$qt_total_orcamento){
            $link_excluir ="excluir-orçamento.php?id=".$lista_orcamentos[$i]["id"]."#";
            $link_editar ="editar-orçamento.php?id=".$lista_orcamentos[$i]["id"];
            //parametro na URL paginadestino.php?variavel=valor ou  paginadestino.php?variavel1=valor1 &&  variavel2=valor2
        ?>   
            
            <!-- tabela completa sem filtros-->
           <?php
           //imprimindo as tags html no php para poder fazer mais facilmente os ifs dos filtros da tabela
           //se todos os filtros estiverem nulos,sera impressa toda a tabela
                if($filtro_Nome_cliente==null &&  $filtro_Nome_vendedor==null && $filtro_Data_final==null && $filtro_Data_inicial==null){
                echo"<tr class='text-center'>";
                echo"<td>".$lista_orcamentos[$i]['id']."</th>";
                echo"<td>".$lista_orcamentos[$i]['descricao']."</td>";
                echo"<td>R$".number_format($lista_orcamentos[$i]['preco'],'2',',','')."</td>";
                echo"<td>".$lista_orcamentos[$i]['nome_Vendedor']."</td>";
                echo"<td>".$lista_orcamentos[$i]['nome_Cliente']."</td>";
                echo"<td>".$lista_orcamentos[$i]['horario']."</td>";
                echo"<td>";
                echo"<a class ='btn btn-outline-info mr-2' href=".$link_editar." role='button'>Editar</a>";
                echo"<a class ='btn btn-outline-danger mr-2' href=".$link_excluir." role='button'>Excluir</a>";
                echo"</td>";
                echo"</tr>";
                }
                //o filtro que nao estiver nulo sera usado 
                //filtro nome cliente
                else if($filtro_Nome_cliente==$lista_orcamentos[$i]["nome_Cliente"]){
                  echo"<tr class='text-center'>";
                  echo"<td>".$lista_orcamentos[$i]['id']."</th>";
                  echo"<td>".$lista_orcamentos[$i]['descricao']."</td>";
                  echo"<td>R$".number_format($lista_orcamentos[$i]['preco'],'2',',','')."</td>";
                  echo"<td>".$lista_orcamentos[$i]['nome_Vendedor']."</td>";
                  echo"<td>".$lista_orcamentos[$i]['nome_Cliente']."</td>";
                  echo"<td>".$lista_orcamentos[$i]['horario']."</td>";
                  echo"<td>";
                  echo"<a class ='btn btn-outline-info mr-2' href=".$link_editar." role='button'>Editar</a>";
                  echo"<a class ='btn btn-outline-danger' href=".$link_excluir." role='button'>Excluir</a>";
                  echo"</td>";
                  echo"</tr>";
                }
                //filtro nome vendedor
                else if($filtro_Nome_vendedor==$lista_orcamentos[$i]["nome_Vendedor"]){
                  echo"<tr class='text-center'>";
                  echo"<td>".$lista_orcamentos[$i]['id']."</th>";
                  echo"<td>".$lista_orcamentos[$i]['descricao']."</td>";
                  echo"<td>R$".number_format($lista_orcamentos[$i]['preco'],'2',',','')."</td>";
                  echo"<td>".$lista_orcamentos[$i]['nome_Vendedor']."</td>";
                  echo"<td>".$lista_orcamentos[$i]['nome_Cliente']."</td>";
                  echo"<td>".$lista_orcamentos[$i]['horario']."</td>";
                  echo"<td>";
                  echo"<a class ='btn btn-outline-info mr-2' href=".$link_editar." role='button'>Editar</a>";
                  echo"<a class ='btn btn-outline-danger' href=".$link_excluir." role='button'>Excluir</a>";
                  echo"</td>";
                  echo"</tr>";
                }else{
                  //filtro data
                  //um dos tres filtros nao está vazio,se ate agr não foi nome Vendedo ou cliente,sobra data.Por isso apenas elsa e nao else if
                  //primeiramente usando explode para separar data e horario
                 $dataI_convertida=explode(" ",$filtro_Data_inicial);
                 $dataF_convertida=explode(" ",$filtro_Data_final);
                 $item_convertido=explode(" ",$lista_orcamentos[$i]["horario"]);

                  //pegando apenas a data
                 $data1=$dataI_convertida[0];
                 $data2=$item_convertido[0];
                 $data3=$dataF_convertida[0];

                  //usando strtotime para fazer conta com data
                 if(strtotime($data2)>strtotime($data1) && strtotime($data2)<strtotime($data3)){
                  echo"<tr class='text-center'>";
                  echo"<td>".$lista_orcamentos[$i]['id']."</th>";
                  echo"<td>".$lista_orcamentos[$i]['descricao']."</td>";
                  echo"<td>R$".number_format($lista_orcamentos[$i]['preco'],'2',',','')."</td>";
                  echo"<td>".$lista_orcamentos[$i]['nome_Vendedor']."</td>";
                  echo"<td>".$lista_orcamentos[$i]['nome_Cliente']."</td>";
                  echo"<td>".$lista_orcamentos[$i]['horario']."</td>";
                  echo"<td>";
                  echo"<a class ='btn btn-outline-info mr-2' href=".$link_editar." role='button'>Editar</a>";
                  echo"<a class ='btn btn-outline-danger' href=".$link_excluir." role='button'>Excluir</a>";
                  echo"</td>";
                  echo"</tr>";
                 }
                }
              ?>

          
        <?php } }// fim foreach e fim if($i<$qt_total_orcamento)?> 
      </tbody>
    </table> <!-- fim table -->
  </div>
  <?php }else{//se nao houver orçamentos cadastrados  no BD ?>
    <div class="container mt-4">
            <h3 class="font-weight-light text-secondary text-center">Não existem orçamentos cadastrados</h3>
      </div>
  
  <?php }// FIM if(isset($lista_produtos) && count($lista_produtos)>0)
  //botoes para trocar de pagina

  //só troca de pagina se houver algum orçamento cadastrado
  if($qt_total_orcamento>0){
  $proxima_Pagina=$pagina_Atual+1;
  $voltar_Pagina=$pagina_Atual-1;
  //impedir o usuario de ir para a pagina 0,que nao existe
  if( $voltar_Pagina<1){
    $voltar_Pagina=1;
  }
  $link_proxima_pagina="cadastro-orçamento.php?nP=".$proxima_Pagina;
  $link_voltar_pagina="cadastro-orçamento.php?nP=".$voltar_Pagina;
 
   ?>
   <div class="container">
   <table class="table table-hover">
   <tr  >
                <form action="filtra-orçamento.php" method="POST">
                <!-- Coluna para alinhamento -->
                <td class="text-left"></th>
                <a class ='btn btn-outline-primary' href="<?=$link_voltar_pagina?>"  role='button'>Voltar pagina</a>
                <td class="text-left"><?php echo "Pagina ".$pagina_Atual." de ".$qt_pg?></th>
                <td class="text-left"><?php echo "Total de registros :  ".$qt_total_orcamento?></th>
                <!-- Coluna para alinhamento -->
                <td class="text-left"></th>
                <a class ='btn btn-outline-primary' href="<?=$link_proxima_pagina?>"  role='button'>Proxima pagina</a>
                
                </form>
            </tr>
            <?php } // fim if <? }// if($qt_total_orcamento>0)?>
</table>
</div>
  
    </div><!--fim div all -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
