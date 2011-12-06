<?php session_start();?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    require_once('../util/Maps/HashMap.php');
    require_once '../util/Session.php';
    require_once '../util/JsonResponse.php';
    require_once '../util/StringManager.php';
    require_once '../util/RequestsPatterns.php';
    require_once('../Config.class.php');

    require_once '../core/DataBase/Connection.php';
    require_once '../core/User/User.php';
    require_once '../core/Link/LinkController.php';
    require_once '../core/Exceptions/FileNotFoundException.php';
    require_once '../core/Exceptions/LoginException.php';
    require_once '../core/Exceptions/UserExistsException.php';    
    $baseUrl = LinkController::getBaseURL();
    if((empty($_POST) && empty($_GET))){        
?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <title>CADASTRO - Bureau de Intelig&ecirc;ncia do Caf&eacute;</title>

                <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/reset.css" media="screen" />
                <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/text.css" media="screen" />
                <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/grid.css" media="screen" />
                <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/main.css" media="screen" />
                <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/subscribe.css" media="screen" />                

                <!--<script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.min.js"></script>
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui.min.js"></script>-->
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui-1.8.15.custom.min.js"></script>                
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.cooquery.js"></script>
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.cycle.min.js"></script>                
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/chart_builder.js"></script>
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/AppAjax.js"></script>
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/events.js"></script>
                <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/subscribe.js"></script>

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
                <div class="grid_12 topo">

                    <!-- #################### -->
                    <!-- BLOCO ESQUERDA       -->
                    <!-- #################### -->
                    <div class="grid_7 box-logo omega">
                        <div id="logo">
                           <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="110" height="110" align="middle">
                                <param name="allowScriptAccess" value="sameDomain" />
                                <param name="allowFullScreen" value="false" />
                                <param name="movie" value="<?echo $baseUrl?>/images/logo.swf" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="bgcolor" value="#990000" /><embed src="<?echo $baseUrl?>/images/logo.swf" quality="high" wmode="transparent" bgcolor="#990000" width="110" height="110" name="logo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
                            </object>
                        </div>

                        <a href="<?php echo $baseUrl; ?>"><img src="<?echo $baseUrl?>/images/escrito-bureau.gif" style="float:left;" id="escrito" /></a>
                    </div>

                    <!-- #################### -->
                    <!-- BLOCO DIREITA        -->
                    <!-- #################### -->
                    <div class="grid_5 omega">

                        <!-- #################### -->
                        <!-- MENU SUPERIOR        -->
                        <!-- #################### -->
                        <div class="grid_12 menu-superior">
                            <a href="">Quem Somos</a> | <a href="">Ajuda</a> | <a href="">Contato</a> | <a href="?restaurar">Restaurar</a> |
                            <?if(!Session::isLogged()):?>
                            <a href="<?echo $baseUrl?>/cadastro" class="l1">Cadastre-se</a>
                            <?else:?>
                            <a href="" class="l1">Olá, <?echo Session::getLoggedUser()->name()?></a> | 
                            <a href="" class="l1" id="save-config">Salvar esta configuração</a>
                            <?endif?>
                        </div>

                        <div class="clear"></div>

                        <!-- #################### -->
                        <!-- APOIO                -->
                        <!-- #################### -->
                        <div class="grid_5 apoios">
                            <!--<div id="imgs-apoios">
                                <img src="<?echo $baseUrl?>/images/apoio-gov.gif" style="margin-left:2px;margin-top:1px;" />
                                <img src="<?echo $baseUrl?>/images/apoio-ufla.jpg" style="margin-top:2px;margin-left:2px;" />
                                <img src="<?echo $baseUrl?>/images/apoio-cim.jpg" style="margin-left: 12px;margin-top:2px;" />
                                <img src="<?echo $baseUrl?>/images/apoio-fapemig.jpg" style="margin-top:6px;margin-left:3px;" />
                                <img src="<?echo $baseUrl?>/images/apoio-polo.gif" style="margin-top:2px;margin-left:9px;" />
                            </div>-->
                        </div>

                        <!-- #################### -->
                        <!-- FORM LOGIN           -->
                        <!-- #################### -->
                        <?if(!Session::isLogged()):?>
                        <!--<div class="grid_7 form-login">
                            <?if(isset($_GET['login-fail'])):?>
                            <div class="error">usuário e/ou senha inválidos</div>
                            <?endif?>
                            <form action="login" method="POST">
                                <input name="username" type="text" value="Login" class="inpt-txt" /> <br />
                                <input name="password" type="password" value="Senha" class="inpt-txt" /> <br />                                
                                <a href="" class="l1">esqueci senha</a>
                                <input type="submit" value="logar" id="bt-logar" />
                            </form>
                        </div>-->
                        <?endif?>
                    </div>
                <!-- Fim Topo -->
                </div>

                <div style="clear"></div>

                <!-- #################### -->
                <!-- MENU APPS            -->
                <!-- #################### -->
                <div class="grid_12 menu-apps">
                    <!--
                    <ul>
                        <li><a href="" id="lnk-publicacoes">Publica&ccedil;&otilde;es</a></li>
                        <li><a href="" id="lnk-noticias">Not&iacute;cias</a></li>
                        <li><a href="" id="lnk-cotacoes">Cota&ccedil;&otilde;es</a></li>
                        <li><a href="" id="lnk-videoteca">Videoteca</a></li>
                        <li><a href="" id="lnk-metereologia">Meteorologia</a></li>
                        <li class="ultimo"><a href="" id="lnk-datacenter">Data Center</a></li>
                    </ul>
                    -->
                <!-- Fim Menu Apps -->
                </div>
                
                <div style="clear"></div>

                <div id="aplicacoes">
                    <div id="subscribe">
                        <center>
                            <h3>
                                Cadastro Bureau Inteligência
                            </h3>
                        </center>
                        <div id="subscribe-content">
                            <div id="form-subscribe">
                                <form id="toSubscribe" action="<?echo $baseUrl?>/cadastro/user/subscribe" method="post">
                                    <div class="fields">
                                        <label for="name">Nome:</label>
                                        <input id="name" name="Nome" type="text" value="" maxlength="80"/>
                                        <div class="erro"></div>
                                    </div>
                                    <div class="fields">
                                        <label for="username">nome de usuário:</label>
                                        <input id="username" name="Nome de Usuário" type="text" value=""/>
                                        <div class="erro"></div>
                                    </div>
                                    <div class="fields">
                                        <label for="email">email:</label>
                                        <input id="email" name="Email" type="text" value=""/>
                                        <div class="erro"></div>
                                    </div>
                                    <div class="fields">
                                        <label>senha:</label>
                                        <input id="password" name="Senha" type="password" value=""/>
                                        <div class="erro"></div>
                                    </div>
                                    <div class="fields">
                                        <label>confirmar senha:</label>
                                        <input id="confirm-password" name="Confirmar Senha" type="password" value=""/>
                                        <div class="erro"></div>
                                    </div>
                                    <div class="fields" style="text-align: center">
                                        <label>Estado</label>
                                        <select id="state">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="fields" style="text-align: center">
                                        <label>Cidade</label>
                                        <select id="city" style="min-width: 163px;">                                            
                                        </select>
                                    </div>
                                    <div class="fields" style="text-align: center">
                                        <label>Atividade</label>
                                        <select id="activity" style="min-width: 163px">
                                            
                                        </select>
                                    </div>
                                    <div id="button-subscribe">
                                         <button id="submit-subscribe"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- Fim Aplicacoes -->
                </div>

                <div class="clear"></div>

                <div class="grid_12 rodape">
                    <p>Bureau de Intelig&ecirc;ncia Competitiva do Caf&eacute;</p>
                </div>

            <!-- Fim container_12 -->
            </div>

        </body>
        </html>
        <?
    }else{                 
        if(LinkController::link() == 'login') {                        
            require_once 'core/Login/process_login.php';        
        }else {
            try {
                require_once LinkController::restSubscribe();
            }catch(Exception $err) {                
                echo $err->getMessage();
            }
        }
    }
?>
