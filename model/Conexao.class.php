<?php 

Class Conexao{
	private $host, $user, $senha, $banco;

	protected $obj, $itens=array(), $prefix;


	public $paginacao_links, $totalpags, $limite, $inicio;



	function __construct(){
		$this->host = $_ENV['DB_HOST'];
		$this->user = $_ENV['DB_USER'];
		$this->senha = $_ENV['DB_PASS'];
		$this->banco = $_ENV['DB_NAME'];
		$this->prefix = $_ENV['DB_PREFIX'];

		try {
			if($this->Conectar() == null){
				$this->Conectar();
			}
			

		} catch (Exception $e) {
			exit($e->getMessage().'<h2> Erro ao conectar com o banco de dados! </h2>');
		}

	}

	private function Conectar(){
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
			);
		$link = new PDO("mysql:host={$this->host};dbname={$this->banco}" , 
			$this->user, $this->senha, $options);
		return $link;
	}


	function ExecuteSQL($query, array $params = NULL){
		
		$this->obj = $this->Conectar()->prepare($query);

		if(!empty($params) && count($params) > 0){
			foreach($params as $key =>$value){
				$this->obj->bindvalue($key, $value);
			}
		}


		return $this->obj->execute();
	}

	function ListarDados(){
		return $this->obj->fetch(PDO::FETCH_ASSOC);
	}

	function TotalDados(){
		return $this->obj->rowCount();
	}


	function GetItens(){
		return $this->itens;
	}



	function paginacaoLinks($campo, $tabela){
		$pag = new Paginacao();
		$pag->GetPaginacao($campo, $tabela);
		$this->paginacao_links = $pag->link;

		$this->totalpags = $pag->totalpags;
		$this->limite = $pag->limite;
		$this->inicio = $pag->inicio;

		$inicio = $pag->inicio;
		$limite = $pag->limite;

		if($this->totalpags > 0){
			return " limit {$inicio}, {$limite}";
		}else{
			return " ";
		}
		
	}

	protected function paginacao($paginas=array()){
		$pag = '<ul class="pagination">';
		$pag .= '<li><a href="?p=1"> << Inicio</a></li>';

		foreach($paginas as $p):
			$pag .= '<li><a href="?p='.$p.'">'.$p.'</a></li>';
			endforeach;

		$pag .= '<li><a href="?p='. $this->totalpags .'"> ...'.$this->totalpags.'>></a></li>';

		$pag .= '</ul>';

		if($this->totalpags > 1){
		return $pag;
		}
	}

	function showPaginacao(){
		return $this->Paginacao($this->paginacao_links);
	}








}

 ?>