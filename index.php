<?php 


date_default_timezone_set('America/Sao_Paulo');

if(!isset($_SESSION)){
	session_start();
}

/*
if(!isset($_SESSION['PED']['pedido'])){
	$_SESSION['pedido'] = md5(uniqid(date('YmdHms')));
}

if(!isset($_SESSION['PED']['ref'])){
	$_SESSION['ref'] = date('ymdHms');
}
*/

require './lib/autoload.php';


//Configurando redis para heroku

if (!empty($_ENV['REDIS_URL'])) {
	$redisUrlParts = parse_url($_ENV['REDIS_URL']);
	ini_set('session.save_handler', 'redis');
	ini_set('session.save_path', "tcp://$redisUrlParts[host]:$redisUrlParts[port]?auth=$redisUrlParts[pass]");
}


//################Habilitando variaveis de ambiente .env ou do Sistema operacional########
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);




$smarty = new Template();
$categorias = new Categorias();
$categorias->GetCategorias();


//valores para o template
$smarty->assign('NOME', 'NEEMIAS JR');
$smarty->assign('GET_TEMA', Rotas::get_SiteTEMA());
$smarty->assign('GET_NOME', $_ENV['SITE_NOME']);
$smarty->assign('GET_SITE_HOME', Rotas::get_SiteHOME());
$smarty->assign('PAG_CARRINHO', Rotas::pag_Carrinho());
$smarty->assign('PAG_PRODUTOS', Rotas::pag_Produtos());
$smarty->assign('PAG_CONTATO', Rotas::pag_Contato());
$smarty->assign('PAG_MINHACONTA', Rotas::pag_MinhaConta());
$smarty->assign('TITULO_SITE', $_ENV['SITE_NOME']);
$smarty->assign('CATEGORIAS', $categorias->GetItens());
$smarty->assign('DATA', Sistema::DataAtualBR());
$smarty->assign('PAG_LOGOFF', Rotas::pag_Logoff());
$smarty->assign('LOGADO', Login::Logado());

if(Login::Logado()){
	$smarty->assign('USER', $_SESSION['CLI']['cli_nome']);
	
}


$smarty->display('index.tpl');
 ?>