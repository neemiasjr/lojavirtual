<?php 

Class Config{

	
	//INFORMÃÇÕES BÁSICAS DO SITE HOSPEDADO
	const SITE_URL = "http://localhost";
	const SITE_PASTA = "";
	const SITE_NOME = "Loja ZPT - Desafio";
	const SITE_EMAIL_ADM = "lojavirtualfreitas@gmail.com";
	const BD_LIMIT_POR_PAG = 6;
	const SITE_CEP = '31535522';


	//INFORMAÇÕES DO BANCO DE DADOS HOSPEDADO
	const BD_HOST = "127.0.0.1",
		  BD_USER = "zptuser",
		  BD_SENHA = "123456",
		  BD_BANCO = "lojaf",
		  BD_PREFIX = "qc_";


	//INFORMAÇÕES PARA PHP MAILLER
	const EMAIL_HOST = "smtp.gmail.com";
	const EMAIL_USER = "lojazptdesafio@gmail.com";
	const EMAIL_NOME = "Contato Loja ZPT";
	const EMAIL_SENHA = "lojazpt";
	const EMAIL_PORTA = 587;
	const EMAIL_SMTPAUTH = true;
	const EMAIL_SMTPSECURE = "tls";
	const EMAIL_COPIA = "neemias.jr@gmail.com";



	//CONSTANTES PARA O PAGSEGURO
	const PS_EMAIL  = "qcursos@hotmail.com"; // email pagseguro
    const PS_TOKEN  = "0E86ADF6373348509E7B35389D92004C"; // token produção
    const PS_TOKEN_SBX = "1FB4D7860EA9491BA7AB4A9D9336C275";  // token do sandbox
    const PS_AMBIENTE = "production"; // production   /  sandbox

}
 ?>

