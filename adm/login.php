<?php

date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION)) {
    session_start();
}


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



$smarty = new Template();


if (isset($_POST['recovery'])):
    
 
    // obejto USER
    $user = new User();
   // passo alguns valores
    $email = $_POST['txt_email'];
    $senha = Sistema::GerarSenha();
    // verifico se tem este email na tabela
    if ($user->GetUserEmail($email) > 0):
        
        try{
          // faz alteração
            $user->AlterarSenha($senha, $email);
            
            // apos alterar envia email com a nova senha
            $enviar = new EnviarEmail();
            
            $assunto = 'Nova senha ADM do site '. Sistema::DataAtualBR();
            $destinatarios = array($email,  $_ENV['SITE_EMAIL_ADM']);
            $msg = ' Nova senha no ADM do site, nova senha:  ' .$senha;
            
            
            $enviar->Enviar($assunto, $msg, $destinatarios);
          
            echo '<div class="alert alert-success"> Foi enviado um email com a NOVA SENHA  </div>';
        } catch(Exception $e) {
          echo "Erro ao enviar email: $e";
        }
    else:
        
         echo '<div class="alert alert-danger"> Email não encontrado </div>';
    endif;
 endif;




if (isset($_POST['txt_logar']) && isset($_POST['txt_email'])) {
    $user = $_POST['txt_email'];
    $senha = $_POST['txt_senha'];
    $login = new Login();
    if ($login->GetLoginADM($user, $senha)) {
        Rotas::Redirecionar(0, 'index.php');
        exit();
    }
}


$smarty->assign('GET_TEMA', Rotas::get_SiteTEMA());
$smarty->assign('HOME', Rotas::get_SiteHOME());

$smarty->display('adm_login.tpl');
