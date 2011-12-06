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
                <param name="movie" value="<?echo $baseUrl?>/images/logo.swf" />
                <param name="quality" value="high" />
                <param name="wmode" value="transparent" />
                <param name="bgcolor" value="#990000" />
                <embed src="<?echo $baseUrl;?>/images/logo.swf" 
                       quality="high" 
                       wmode="transparent" 
                       bgcolor="#990000" 
                       width="110" 
                       height="110" 
                       name="logo" 
                       align="middle" 
                       allowScriptAccess="sameDomain" 
                       allowFullScreen="false" 
                       type="application/x-shockwave-flash" 
                       pluginspage="http://www.adobe.com/go/getflashplayer" />
            </object>
        </div>

        <a href="<?php echo LinkController::getBaseURL(); ?>"><img src="<?echo $baseUrl?>/images/escrito-bureau.gif" style="float:left;" id="escrito" /></a>
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
            <a href="" class="l1">Cadastre-se</a>
            <?else:?>
            <form action="" method="">
                
            </form>
            <a href="" class="l1">Olá, <?echo Session::getLoggedUser()->getFirstName()?></a> |             
            <?endif?>
        </div>
        <div class="clear"></div>

        <!-- #################### -->
        <!-- APOIO                -->
        <!-- #################### -->
        <!--<div class="grid_5 apoios" style="float: right">
            <div id="imgs-apoios">
                <img src="<?echo $baseUrl?>/images/apoio-gov.gif" style="margin-left:2px;margin-top:1px;" />
                <img src="<?echo $baseUrl?>/images/apoio-ufla.jpg" style="margin-top:2px;margin-left:2px;" />
                <img src="<?echo $baseUrl?>/images/apoio-cim.jpg" style="margin-left: 12px;margin-top:2px;" />
                <img src="<?echo $baseUrl?>/images/apoio-fapemig.jpg" style="margin-top:6px;margin-left:3px;" />
                <img src="<?echo $baseUrl?>/images/apoio-polo.gif" style="margin-top:2px;margin-left:9px;" />
            </div>
        </div>-->
    </div>
    <?if(Session::isLogged()):?>
    <div class="grid_7 form-login" style="width: 30%; float: right;">
        <form action="login" method="POST">
            Usuário: <input name="username" type="text" value="<?echo Session::getLoggedUser()->username()?>" class="inpt-txt" /> <br />
            Senha: <input name="password" type="password" value="xxxxx" class="inpt-txt" /> <br />                
            | <a href="<?echo LinkController::getBaseURL()?>/logout" class="l1" id="logout">sair</a>                
        </form>         
    </div>
    <?endif?>    
<!-- Fim Topo -->
</div>
