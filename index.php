<?php session_start();?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('util/Maps/HashMap.php');
require_once 'util/Session.php';
require_once 'util/JsonResponse.php';
require_once 'util/StringManager.php';

require_once('Config.class.php');
require_once "core/RSSReader.php";
require_once "core/RssItem.php";
require_once 'core/DataBase/Connection.php';
require_once 'core/User/User.php';
require_once 'core/Link/LinkController.php';
require_once 'core/Exceptions/FileNotFoundException.php';
require_once 'core/Exceptions/LoginException.php';
require_once 'core/Exceptions/UserExistsException.php';    
    if(isset($_GET['login-fail']) || isset($_GET['restaurar']) || (empty($_POST) && empty($_GET))){
        /*
         * Acoes para o link RESTAURAR aplicativos
         */
        if ( isset($_GET['restaurar']) )
        {
            setcookie('Bureau_PosicaoApps', '');
            setcookie('Bureau_AppsMinimizados', '');
            header('Location: ' . Config::get('baseurl'));
        }
        if(!Session::isLogged()){            
            /*
             * Se o cookie de posicao de APPS nao existe, entao cria de acordo com o arquivo de configuracao.
             */            
            if (! isset($_COOKIE['Bureau_PosicaoApps']))
            {                
                setcookie('Bureau_PosicaoApps', Config::get('posicao_padrao_apps'), Config::get('tempo_vida_cookie'));
            }else{
                //setcookie('Bureau_PosicaoApps', Config::get('posicao_padrao_apps'), Config::get('tempo_vida_cookie'));                
            }

            /*
             * Se o cookie de APPS minimizados nao existe, entao cria.
             */
            if (! isset($_COOKIE['Bureau_AppsMinimizados']))
            {
                setcookie('Bureau_AppsMinimizados', "0", Config::get('tempo_vida_cookie'));
            }else{
                //setcookie('Bureau_AppsMinimizados', "0", Config::get('tempo_vida_cookie'));
            }

        }else{
            //echo "cookie = ".isset($_COOKIE['logged']);
            if(!isset($_COOKIE['logged'])){
                //setcookie('Bureau_PosicaoApps', '', time()-3600);
                //setcookie('Bureau_PosicaoApps', "publicacoes|noticias|videoteca", time() + 3600);
                //setcookie('Bureau_AppsMinimizados', "0", Config::get('tempo_vida_cookie'));
                //setcookie('logged', '1', time() + 3600);
            }            
        }
      ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <title>Bureau de Intelig&ecirc;ncia do Caf&eacute;</title>

                <link rel="stylesheet" type="text/css" href="assets/css/reset.css" media="screen" />
                <!--<link rel="stylesheet" type="text/css" href="assets/css/ui/jquery-ui-1.8.8.custom.css" media="screen" />-->
                <link rel="stylesheet" type="text/css" href="assets/css/ui/jquery-ui-1.8.15.custom.css" media="screen" /> 
                <link rel="stylesheet" type="text/css" href="assets/css/text.css" media="screen" />
                <link rel="stylesheet" type="text/css" href="assets/css/grid.css" media="screen" />
                <link rel="stylesheet" type="text/css" href="assets/css/main.css" media="screen" />
                <link rel="stylesheet" type="text/css" href="assets/css/contentapps.css" media="screen" />

                <!--<script type="text/javascript" src="assets/js/jquery.min.js"></script>-->
                <script type="text/javascript" src="assets/js/jquery-1.6.2.min.js"></script>
                <!--<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>-->
                <script type="text/javascript" src="assets/js/jquery-ui-1.8.15.custom.min.js"></script>
                <script type="text/javascript" src="assets/js/jquery.cooquery.js"></script>
                <script type="text/javascript" src="assets/js/jquery.cycle.min.js"></script>
                <script type="text/javascript" src="assets/js/windows.js"></script>
                <script type="text/javascript" src="assets/js/FusionCharts.js"></script>
                <script type="text/javascript" src="assets/js/chart_builder.js"></script>
                <script type="text/javascript" src="assets/js/AppAjax.js"></script>
                <script type="text/javascript" src="assets/js/load_apps.js"></script>
                <script type="text/javascript" src="assets/js/image.load.js"></script>
                <script type="text/javascript" src="assets/js/events.js"></script>                
                <script type="text/javascript" src="assets/js/main.js"></script>
                <script type="text/javascript">
                $(function(){                    
                   var qtdAppsLoaded = 0;
                   var $imgs = $(".loading-apps img");                   
                   //console.log($imgs.length);
                   $imgs.imageLoad(function(){
                       qtdAppsLoaded++;
                       //console.log("img logged = "+qtdAppsLoaded);
                       //console.log($(this).parents(".app").attr("id"));
                       loadingApps(qtdAppsLoaded);
                   });                   
                });  
                </script>
                <!--[if IE 6]>
                    <style>
                            #logo {
                                    margin-left:5px;
                            }

                            .box-app h1 {
                                    padding-top:0px;
                            }

                            .app h1 span {
                                    margin-top:-27px;
                            }

                            #carregando {
                               position:absolute;
                               left:45%;
                               width:90px;
                            }
                    </style>
                <![endif]-->

                <!--[if IE 7]>
                    <style>
                            #logo {
                                    margin-left:10px;
                            }

                            .box-app h1 {
                                    padding-top:0px;
                            }

                            .app h1 span {
                                    margin-top:-27px;
                            }

                            #carregando {
                               position:absolute;
                               left:45%;
                               width:90px;
                            }
                            .container_12 .grid_4 {
                                    width: 31.111%;
                            }

                            .container_12 .grid_7 {
                                    width: 56.111%;
                            }
                    </style>
                <![endif]-->
            </head>

        <body>

            <div id="carregando">Carregando...</div>

            <div class="container_12">

                <!-- #################### -->
                <!-- TOPO                 -->
                <!-- #################### -->
                <div class="grid_12 topo" id="topo-banner">

                    <!-- #################### -->
                    <!-- BLOCO ESQUERDA       -->
                    <!-- #################### -->
                    <div class="grid_7 box-logo omega" id="box-logo">
                        <div id="logo">
                           <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="110" height="110" align="middle">
                                <param name="allowScriptAccess" value="sameDomain" />
                                <param name="allowFullScreen" value="false" />
                                <param name="movie" value="images/logo.swf" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#990000" /><embed src="images/logo.swf" quality="high" wmode="transparent" bgcolor="#990000" width="110" height="110" name="logo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
                            </object>
                        </div>

                        <a href="<?php echo Config::get('baseurl'); ?>"><img src="images/escrito-bureau.gif" style="float:left;" id="escrito" /></a>
                    </div>

                    <!-- #################### -->
                    <!-- BLOCO DIREITA        -->
                    <!-- #################### -->
                    <div class="grid_5 omega" id="banner-on-right">

                        <!-- #################### -->
                        <!-- MENU SUPERIOR        -->
                        <!-- #################### -->
                        <div class="grid_12 menu-superior">
                            <a href="">Quem Somos</a> | <a href="">Ajuda</a> | <a href="">Contato</a> | <a href="?restaurar">Restaurar</a> |
                            <?if(!Session::isLogged()):?>
                            <a href="<?echo LinkController::getBaseURL()?>/cadastro" class="l1">Cadastre-se</a>
                            <?else:?>
                            <a href="" class="l1">Olá, <?echo Session::getLoggedUser()->getFirstName()?></a> |                             
                            <?endif?>
                        </div>

                        <div class="clear"></div>
                        
                        <div id="on-right">
                              <!-- #################### -->
                            <!-- FORM LOGIN           -->
                            <!-- #################### -->
                            <?//if(!Session::isLogged()):?>
                            <div class="grid_7 form-login" id="form-login-main">
                                <?if(isset($_GET['login-fail'])):?>
                                <div class="error">usuário e/ou senha inválidos</div>
                                <?endif?>
                                <form action="login" method="POST">
                                    <?if(!Session::isLogged()):?>
                                    Usuário: <input name="username" type="text" value="" class="inpt-txt" /> <br />
                                    Senha: <input name="password" type="password" value="" class="inpt-txt" /> <br />
                                    <span id="updateAll" class="updating-all">
                                        <img style="margin-top: 3px;" src="<?echo LinkController::getBaseURL()?>/images/refresh.png" alt="Atualizar tudo" title="Atualizar todas as caixas abertas"/>
                                    </span>
                                    <span id="ajaxRefreshGif" class="updating-all" style="display: none">
                                        <img style="margin-top: 3px; margin-bottom: 1px;" src="<?echo LinkController::getBaseURL()?>/images/ajax-refresh.gif"/>
                                    </span>                                    
                                    <a id="forget-pass" href="" class="l1">esqueci senha</a>
                                    <input type="submit" value="logar" id="bt-logar" />
                                    <?else:?>                                
                                    Usuário: <input name="username" type="text" value="<?echo Session::getLoggedUser()->username()?>" class="inpt-txt" /> <br />
                                    Senha: <input name="password" type="password" value="xxxxx" class="inpt-txt" /> <br />
                                    <span id="updateAll" class="updating-all">
                                        <img style="margin-top: 3px;" src="<?echo LinkController::getBaseURL()?>/images/refresh.png" alt="Atualizar tudo" title="Atualizar todas as caixas abertas"/>
                                    </span>
                                    <span id="ajaxRefreshGif" class="updating-all" style="display: none">
                                        <img style="margin-top: 3px; margin-bottom: 1px;" src="<?echo LinkController::getBaseURL()?>/images/ajax-refresh.gif"/>
                                    </span>                                    
                                    <a href="" class="l1" id="save-config">Salvar esta configuração</a>
                                    | <a href="<?echo LinkController::getBaseURL()?>/logout" class="l1" id="logout">sair</a>
                                    <?endif?>
                                </form>
                            </div>
                            <?//endif?>
                            <!-- #################### -->
                            <!-- APOIO                -->
                            <!-- #################### -->
                            <div class="grid_5 apoios" id="apoios">
                                <div id="imgs-apoios">
                                    <img src="images/apoio-gov.gif" style="margin-left:2px;margin-top:1px;" />
                                    <img src="images/apoio-ufla.jpg" style="margin-top:2px;margin-left:2px;" />
                                    <img src="images/apoio-cim.jpg" style="margin-left: 12px;margin-top:2px;" />
                                    <img src="images/apoio-fapemig.jpg" style="margin-top:6px;margin-left:3px;" />
                                    <img src="images/apoio-polo.gif" style="margin-top:2px;margin-left:9px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Fim Topo -->
                </div>

                <div style="clear"></div>

                <!-- #################### -->
                <!-- MENU APPS            -->
                <!-- #################### -->
                <div class="grid_12 menu-apps">
                    <ul>
                        <li><a href="" id="lnk-publicacoes">Publica&ccedil;&otilde;es</a></li>
                        <li><a href="" id="lnk-noticias">Not&iacute;cias</a></li>
                        <li><a href="" id="lnk-cotacoes">Cota&ccedil;&otilde;es</a></li>
                        <li><a href="" id="lnk-videoteca">Videoteca</a></li>
                        <li><a href="" id="lnk-metereologia">Meteorologia</a></li>
                        <li class="ultimo"><a href="" id="lnk-datacenter">Data Center</a></li>  
                    </ul>                    
                <!-- Fim Menu Apps -->
                </div>

                <div style="clear"></div>

                <div id="aplicacoes">

                    <?php                                         
                        require_once('carrega_apps.php');
                    ?>

                <!-- Fim Aplicacoes -->
                </div>

                <div class="clear"></div>

                <div class="grid_12 rodape">
                    <p>Bureau de Intelig&ecirc;ncia Competitiva do Caf&eacute;</p>
                </div>

            <!-- Fim container_12 -->
            </div>

            <div id="window-cotation">
                
            </div>
            <div id="window-forgetPassword" style="display: none">
                <form id="new-password" action="<?echo LinkController::getBaseURL()?>/user/forgetpassword">
                    <div class="fields">
                        <label>email cadastrado:</label>
                        <input id="f-email" type="text"/>
                    </div>
                    <div class="fields">
                        <label>nome de usuário:</label>
                        <input id="f-username" type="text"/>
                    </div>
                    <div class="fields">
                        <button id="get-new-pass">solicitar nova senha</button>
                    </div>
                </form>
            </div>
        </body>
        </html>
        <?
    }else{                 
        if(LinkController::link() == 'login') {                        
            require_once 'core/Login/process_login.php';        
        }else {
            try {
                require_once LinkController::rest();
            }catch(Exception $err) {                
                echo $err->getMessage();
            }
        }
    }
?>
