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

require './../lib/autoload.php';

if (!empty($_ENV['REDIS_URL'])) {
	$redisUrlParts = parse_url($_ENV['REDIS_URL']);
	ini_set('session.save_handler', 'redis');
	ini_set('session.save_path', "tcp://$redisUrlParts[host]:$redisUrlParts[port]?auth=$redisUrlParts[pass]");
}


//################Habilitando variaveis de ambiente .env ou do Sistema operacional########
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS']);



if(!Login::LogadoADM()){
	Rotas::Redirecionar(1, 'login.php');
	exit('<h2>Erro! Acesso negado </h2>');
}


$smarty = new Template();
$categorias = new Categorias();
$categorias->GetCategorias();


//valores para o template
$smarty->assign('GET_TEMA', Rotas::get_SiteTEMA());
$smarty->assign('TITULO_SITE', $_ENV['SITE_NOME']);
$smarty->assign('SITE_NOME', $_ENV['SITE_NOME']);
$smarty->assign('GET_SITE_HOME', Rotas::get_SiteHOME());
$smarty->assign('GET_SITE_ADM', Rotas::get_SiteADM());
$smarty->assign('PAG_ADM_CLIENTE', Rotas::pag_ClientesADM());
$smarty->assign('PAG_ADM_PEDIDOS', Rotas::pag_PedidosADM());
$smarty->assign('PAG_CONTATO', Rotas::pag_Contato());
$smarty->assign('PAG_CATEGORIAS', Rotas::pag_CategoriasADM());
$smarty->assign('PAG_ADM_PRODUTOS', Rotas::pag_ProdutosADM());
$smarty->assign('PAG_SENHA', Rotas::get_SiteADM() . '/adm_senha');
$smarty->assign('PAG_LOGOFF', Rotas::pag_LogoffADM());
$smarty->assign('CATEGORIAS', $categorias->GetItens());
$smarty->assign('DATA', Sistema::DataAtualBR());
$smarty->assign('LOGADO', Login::LogadoADM());
//$smarty->assign('LOGADO', Login::LogadoADM());
//$smarty->assign('PAG_LOGOFF', Rotas::get_SiteADM() .'/logoff');
//$smarty->assign('PAG_SENHA', Rotas::get_SiteADM() .'/adm_senha');


if(Login::LogadoADM()){
	$smarty->assign('USER', $_SESSION['ADM']['user_nome']);
	$smarty->assign('DATA', $_SESSION['ADM']['user_data']);
	$smarty->assign('HORA', $_SESSION['ADM']['user_hora']);
}


$smarty->display('adm_index.tpl');
 ?>