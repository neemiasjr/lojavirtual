<?php 



class Pedidos extends Conexao{

  public array $erro = [];


	function __construct(){
		parent::__construct();
	}

	function PedidoGravar($cliente, $cod, $ref, $freteValor=null, $freteTipo=null){

		$retorno = FALSE;
		 $query  = "INSERT INTO ".$_ENV['DB_PREFIX']."pedidos ";   
     	 $query .= "(ped_data, ped_hora, ped_cliente, ped_cod, ped_ref, ped_frete_valor, ped_frete_tipo, ped_pag_status)"; 
    	 $query .= " VALUES ";
     	 $query .= "(:data, :hora, :cliente, :cod, :ref, :frete_valor, :frete_tipo, :ped_pag_status)";

     	 $params = array(


     	 	':data' => Sistema::DataAtualUS(),
            ':hora' => Sistema::HoraAtual(),
            ':cliente'=> (int)$cliente,
            ':cod' => $cod,
            ':ref' => $ref,
            ':frete_valor'=>$freteValor,
            ':frete_tipo' =>$freteTipo,
            ':ped_pag_status' =>'NAO' 

     	 	);


     	 $this->ExecuteSQL($query, $params);
     	 
     	 //gravar os itens do pedido
     	 $this->ItensGravar($cod);
     	 $retorno = TRUE;
     	 return $retorno;

	}

    function GetPedidosCliente($cliente=null){
      $query = "SELECT * FROM {$_ENV['DB_PREFIX']}pedidos p INNER JOIN {$_ENV['DB_PREFIX']}clientes c";
      $query .= " ON p.ped_cliente = c.cli_id";

      if($cliente != null){
        $cli = (int)$cliente;
        $query .= " WHERE ped_cliente = {$cli}";
        $query .= " ORDER BY ped_id DESC ";

        $query .= $this->PaginacaoLinks("ped_id", $_ENV['DB_PREFIX']."pedidos WHERE ped_cliente=".(int)$cli);
        
      } else{
        $query .= $this->PaginacaoLinks("ped_id", $_ENV['DB_PREFIX']."pedidos");
      }

      $this->ExecuteSQL($query);
      $this->GetLista();   
    }


     private function GetLista(){
        
        $i = 1;
        while ($lista = $this->ListarDados()):
            
        $this->itens[$i] = array(
                'ped_id'    => $lista['ped_id'],
                'ped_data'  => Sistema::Fdata($lista['ped_data']),
                'ped_data_us'  => $lista['ped_data'],
                'ped_hora'   => $lista['ped_hora'],
                'ped_cliente' => $lista['ped_cliente'],
                'ped_cod'   => $lista['ped_cod'],
                'ped_ref'     => $lista['ped_ref'],
                'ped_pag_status' => $lista['ped_pag_status'],
                'ped_pag_forma'   => $lista['ped_pag_forma'],
                'ped_pag_tipo'    => $lista['ped_pag_tipo'],
                'ped_pag_codigo'   => $lista['ped_pag_codigo'],
                'ped_frete_valor' => $lista['ped_frete_valor'],
                'ped_frete_tipo'  => $lista['ped_frete_tipo'],
                'cli_nome'  => $lista['cli_nome'],
                'cli_sobrenome'  => $lista['cli_sobrenome'],
            );
        
        
            $i++;
        
        endwhile;
        
        
    }




    function GetPedidosREF($ref){
        
          // monto a SQL
        $query = "SELECT * FROM {$_ENV['DB_PREFIX']}pedidos p INNER JOIN {$_ENV['DB_PREFIX']}clientes c";
        $query.= " ON p.ped_cliente = c.cli_id";        
        $query .= " WHERE ped_ref = :ref";
        $query .= $this->PaginacaoLinks("ped_id", $_ENV['DB_PREFIX']."pedidos WHERE ped_ref = ".$ref);
        
        // passando parametros
        $params = array(':ref'=>$ref);
       // executando a SQL                      
        $this->ExecuteSQL($query,$params);
        // trazendo a listagem 
        $this->GetLista();
    }



     function GetPedidosDATA($data_ini,$data_fim){
        
         // montando a SQL
        $query = "SELECT * FROM {$_ENV['DB_PREFIX']}pedidos p INNER JOIN {$_ENV['DB_PREFIX']}clientes c";
        $query.= " ON p.ped_cliente = c.cli_id";
        
        $query.= " WHERE ped_data between :data_ini AND :data_fim ";

        $query .= $this->PaginacaoLinks("ped_id", $_ENV['DB_PREFIX']."pedidos WHERE ped_data between ".$data_ini." AND ".$data_fim);
          
       // passando os parametros  
        $params = array(':data_ini'=>$data_ini, ':data_fim'=>$data_fim);
        
        // executando a SQL
        $this->ExecuteSQL($query,$params);
        
        $this->GetLista();
    }






    function  Apagar($ped_cod){
        
        // apagando o PEDIDO  
        
        // monto a minha SQL de apagar o pedido 
        $query =  " DELETE FROM {$_ENV['DB_PREFIX']}pedidos WHERE ped_cod = :ped_cod";        
        // parametros
        $params = array(':ped_cod'=>$ped_cod);
        // executo a minha SQL
        $this->ExecuteSQL($query, $params);
        
        /// apos apagar o pedido apaga ITENS DO PEDIDO  
        
                    // monto a minha SQL de apagar os items 
                 $query =  " DELETE FROM {$_ENV['DB_PREFIX']}pedidos_itens WHERE item_ped_cod = :ped_cod";

                 // parametros
                 $params = array(':ped_cod'=>$ped_cod);
                 // executo a minha SQL
                 if($this->ExecuteSQL($query, $params)):
                     return TRUE;
                 endif;
        
    }



	function ItensGravar($codpedido){
		$carrinho = new Carrinho();
    $produtoPedido = new Produtos();
		foreach ($carrinho->GetCarrinho() as $item) {
			
      $query  = "INSERT INTO {$_ENV['DB_PREFIX']}pedidos_itens ";
      $query .= "(item_produto, item_valor, item_qtd, item_ped_cod)";
      $query .= "VALUES  (:produto,:valor,:qtd,:cod)";
            
      $params = array(
      ':produto' => $item['pro_id'],
      ':valor'   => $item['pro_valor_us'],
      ':qtd'     => (int)$item['pro_qtd'],
      ':cod'     =>  $codpedido  
      );

      $this->ExecuteSQL($query, $params);

      if(!empty($item['pro_id'])){
        $produtoPedido->GetProdutosID($item['pro_id']);
        $dadosProduto = $produtoPedido->GetItens();
        
        if(((int) $dadosProduto[1]['pro_estoque'] > 0) && ((int) $dadosProduto[1]['pro_estoque'] - (int) $item['pro_qtd'] > 0 )){ 
          $valorAtualEstoque = (int) $dadosProduto[1]['pro_estoque'] - (int)$item['pro_qtd'];
          
          $query2 = "UPDATE {$_ENV['DB_PREFIX']}produtos SET pro_estoque = :qtde";
          
          $params2 = array(
            ':qtde' => $valorAtualEstoque
          );

          $this->ExecuteSQL($query2, $params2);
        }
        
        array_push($this->erro,"<span class='badge badge-danger'>Produto {$dadosProduto[1]['pro_nome']} sem estoque!!</span><br>");
      }
      array_push($this->erro,"<span class='badge badge-danger'>Produto não encontrado!!</span><br>");
    }
	}


	function LimparSessoes(){
		unset($_SESSION['PRO']);
		unset($_SESSION['PED']['pedido']);
        unset($_SESSION['PED']['ref']);
		
	}

  function getErro(){
    return $this->erro;
  }

}

 ?>