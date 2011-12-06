<?$baseUrl = LinkController::getBaseURL();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Bureau de Intelig&ecirc;ncia do Caf&eacute;</title>

        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/grid.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/main.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/login.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/admin.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/admin-table.css" media="screen" />

        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.form.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.cooquery.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.cycle.min.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/events_admin.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/admin_ajax.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/admin.js"></script>
    </head>
    <body>
        <div class="container_12">
            <h1 style="width: 100%" class="titleadmin">Administrador Bureau Inteligência</h1>
            <div class="grid_12 menu-apps">
                <ul>
                    <li><a href="<?echo $baseUrl?>/admin/publicacoes" id="lnk-publicacoes">Publica&ccedil;&otilde;es</a></li>
                    <li><a href="<?echo $baseUrl?>/admin/noticias" id="lnk-noticias">Not&iacute;cias</a></li>
                    <li><a href="" id="lnk-cotacoes">Cota&ccedil;&otilde;es</a></li>
                    <li><a href="<?echo $baseUrl?>/admin/videos" id="lnk-videoteca">Videoteca</a></li>
                    <li><a href="" id="lnk-metereologia">Meteorologia</a></li>
                    <li class="ultimo"><a href="" id="lnk-datacenter">Data Center</a></li>
                </ul>
            <!-- Fim Menu Apps -->
            </div>
            <div style="clear:both"></div>
            <div id="aplicacoes">
                <div id="loading">
                    <img alt="loading" src="<?echo LinkController::getBaseURL()?>/images/ajax-loader.gif" />
                </div>
                <div id="content-middle">                    
                    <?include 'loginer.php'?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="grid_12 rodape">
                <p>Bureau de Intelig&ecirc;ncia do Caf&eacute;</p>
            </div>
        </div>
    </body>
</html>