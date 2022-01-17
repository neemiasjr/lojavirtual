<?php
/* Smarty version 3.1.40, created on 2022-01-17 09:01:01
  from '/Users/neemiasjr/git-desafios-empresas/desafio-zpt/old/Modulo5/Arquivos/lojafinalizada/loja/adm/view/adm_login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.40',
  'unifunc' => 'content_61e55a7d183191_29512022',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '661a5e025b2e5c074a75aa71c6fc8ba0ae11d6cd' => 
    array (
      0 => '/Users/neemiasjr/git-desafios-empresas/desafio-zpt/old/Modulo5/Arquivos/lojafinalizada/loja/adm/view/adm_login.tpl',
      1 => 1505402266,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61e55a7d183191_29512022 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>

<html>
    <head>
        <title>Area restrita </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href="<?php echo $_smarty_tpl->tpl_vars['GET_TEMA']->value;?>
/tema/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['GET_TEMA']->value;?>
/tema/js/jquery-2.2.1.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['GET_TEMA']->value;?>
/tema/js/bootstrap.min.js" type="text/javascript"><?php echo '</script'; ?>
>
        <!-- meu aquivo pessoal de CSS-->
        <link href="<?php echo $_smarty_tpl->tpl_vars['GET_TEMA']->value;?>
/tema/css/tema.css" rel="stylesheet" type="text/css"/>
     
    
    </head>
    <body style="background-color: #d7dcf8">
        
        <section class="container" >
            
            
            <section class="row">
                
                <div class="col-md-4"></div>    
               
                <div class="col-md-4 thumbnail" id="bloco_login_adm">
                 
                    <h4 class="text-center"> Área restrita </h4>
               
                    
                    <form name="login" method="post" action="">
                        
                        <label>Email:</label>
                        <input type="email" name="txt_email" class="form-control" required autocomplete="off">
                        
                        
                        <label>Senha:</label>
                        <input type="password" name="txt_senha" class="form-control" required>
                        
                        <br>
                        <br>
                        <button class="btn btn-success btn-block btn-lg" name="txt_logar" value="txt_logar"> Entrar </button>
                        <br>
                        
                          
                        
                    </form>
                    
                    <!-- botão senha recovery -->
                    <br>
                    <center><button class="btn btn-warning" data-toggle="collapse" data-target="#recovery"> Esqueci a senha </button>

                    <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
" class="btn btn-info"> Ir para Loja </a>
                    </center>
                    
                    <div class="alert alert-danger collapse" id="recovery">
                    
                        <form name="recovery" method="post" action="">
                            <label>Digite o email do administrador </label>
                            <input type="email" name="txt_email" class="form-control" required>
                            <button class="btn btn-success" name="recovery" value="recovery">Solicitar senha</button>
                            
                        </form> 
                        
                    </div>
                    
                </div>    
              
                <div class="col-md-4"></div>    
                
                
            </section>
            
            
            
        </section>
        
        
    </body>
</html>

<?php }
}
