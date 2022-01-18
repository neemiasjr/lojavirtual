<?php
class Correios
{
    public $frete = array();
    
    public $error;
    
    public $servico;
    
    public $servico2;
    
    public $cepOrigem;
    
    public $cepDestino;
    
    public $peso;
    
    public $formato = '1';
    
    public $comprimento;
    
    public $altura;
    
    public $largura;
    
    public $diametro;
    
    public $maoPropria = 'N';
    
    public $valordeclarado = '0';
    
    public $avisoRecebimento = 'N';
    
    public $retorno = 'xml';
        
    private $url   = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
    private $sedex = '04014';
    private $pac   = '04510';
    /**
     * @param string cep destino
     * @param  float peso
     */
    public function __construct($destino, $peso)
    {
	
				//tipo de servicos, ou seja, sedex, pac, sedex 10, esses codigos voce encontra no PDF que mencionei acima
				$this->servico = $this->pac;  // PAC
				$this->servico2 = $this->sedex; // sedex
                
                //cep de origem, ou seja, de onde parte
        $this->cepOrigem 	= "73255900";
                
        //cep destino, ou seja, para onde vai ser mandado
        $this->cepDestino 	= $destino;
                
        //peso em kilogramas
        $this->peso 		= $peso;
        $this->comprimento      = '20';//em cm
				$this->altura 		= '6';//em cm
				$this->largura     	= '20';//em cm
				$this->diametro 	= '20';//em cm
    }

    /**
    * faz a verificação e calculo do frete
    **/
    public function Calcular()
    {
        $cURL = curl_init(sprintf(
            $this->url.'?nCdServico=%s&sCepOrigem=%s&sCepDestino=%s&nVlPeso=%s&nCdFormato=%s&nVlComprimento=%s&nVlAltura=%s&nVlLargura=%s&nVlDiametro=%s&sCdMaoPropria=%s&nVlValorDeclarado=%s&sCdAvisoRecebimento=%s&StrRetorno=%s',
            $this->servico,
            $this->cepOrigem,
            $this->cepDestino,
            $this->peso,
            $this->formato,
            $this->comprimento,
            $this->altura,
            $this->largura,
            $this->diametro,
            $this->maoPropria,
            $this->valordeclarado,
            $this->avisoRecebimento,
            $this->retorno
        ));
            
                                  
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

        $string = curl_exec($cURL);

        curl_close($cURL);
        $xml = simplexml_load_string($string);
            
				//echo json_encode($xml);

        if (!empty($xml->Erro)):
            
						$this->error = array($xml->cServico->Erro, $xml->cServico->MsgErro);
						return false; 
				else:
						$servico1 = $xml->cServico;
				endif;

				$cURL2 = curl_init(sprintf(
					$this->url.'?nCdServico=%s&sCepOrigem=%s&sCepDestino=%s&nVlPeso=%s&nCdFormato=%s&nVlComprimento=%s&nVlAltura=%s&nVlLargura=%s&nVlDiametro=%s&sCdMaoPropria=%s&nVlValorDeclarado=%s&sCdAvisoRecebimento=%s&StrRetorno=%s',
					$this->servico2,
					$this->cepOrigem,
					$this->cepDestino,
					$this->peso,
					$this->formato,
					$this->comprimento,
					$this->altura,
					$this->largura,
					$this->diametro,
					$this->maoPropria,
					$this->valordeclarado,
					$this->avisoRecebimento,
					$this->retorno
				));
		
				curl_setopt($cURL2, CURLOPT_RETURNTRANSFER, true);

				$string2 = curl_exec($cURL2);

				curl_close($cURL2);
				$xml2 = simplexml_load_string($string2);

				//echo json_encode($xml2);
				if (!empty($xml2->Erro)):
            
					$this->error = array($xml2->cServico->Erro, $xml2->cServico->MsgErro);
					return false; 
				else:
						$servico2 = $xml2->cServico;
				endif;

				return $this->frete = [
					'pac' => [
						'valor'	=> $servico1->Valor,
						'tipo' => 'PAC',
						'Prazo' => $servico1->PrazoEntrega,
						'erro' => 0,
					],
					'sedex' => [
						'valor'	=> $servico2->Valor,
						'tipo' => 'SEDEX',
						'Prazo' => $servico2->PrazoEntrega,
						'erro' => 0,
					]
				];
        
    }
        
    /*
    * mostrando erros
    */
    public function error()
    {
        if (is_null($this->error)) {
            return false;
        } else {
            return $this->error;
        }
    }
}
