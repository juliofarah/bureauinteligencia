<?
require_once "../core/Link/LinkController.php";
require_once "../core/DataBase/Connection.php";
require_once "../core/Exceptions/FileNotFoundException.php";
require_once "../core/Exceptions/LoginException.php";
require_once "../util/Maps/HashMap.php";
require_once "../util/Session.php";
require_once "../util/JsonResponse.php";
require_once '../util/StringManager.php';
$baseUrl = LinkController::getBaseURL();
if(empty($_GET) && empty($_POST)){        
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/window-css.css" media="screen" />
        <!--<link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/ui/jquery-ui-1.8.8.custom.css" media="screen" />-->
        <link rel="stylesheet" type="text/css" href="<?echo $baseUrl?>/assets/css/ui/jquery-ui-1.8.15.custom.css" media="screen" />
        <!--<script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery.min.js"></script>-->
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-1.6.2.min.js"></script>
        <!--<script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui-1.8.8.custom.min.js"></script>-->
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-ui-1.8.15.custom.min.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/windowProccessResults.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/AppAjax.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/events.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/mainwindow.js"></script>
        <title>Busca Avançada</title>
        <script type="text/javascript">
            $(document).ready(function(){                
                $("#beginDate, #endDate").datepicker({
                    dateFormat: 'yy-mm-dd',
                    //dateFormat: 'dd/mm/yy',
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul',
                    'Ago','Set','Out','Nov','Dez'],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril',
                    'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                    nextText: 'Proximo',
                    prevText: 'Anterior',
                    changeMonth: true,
                    changeYear: true
                });
            });        
        </script>
    </head>
    <body>
        <div id="window-content">
            <div id="content-center">
                <div id="search-params">
                    <div id="params">
                        <form id="form-searchParams" action="<?echo LinkController::link()?>">
                            <table border="0" id="table-params">
                                <thead>
                                    <tr>
                                        <?if(LinkController::link() != "analysis"):?>
                                        <th>Area</th>
                                        <th>Subarea</th>
                                        <th>Tipo de Evento</th>
                                        <?else:?>
                                        <th>Assunto</th>
                                        <th colspan="2" style="text-align: center">Período (início - fim)</th>
                                        <?endif?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?if(LinkController::link() != "analysis"):?>                                       
                                        <td>
                                            <select class="params" id="area" size="5">
                                                <?if(LinkController::link() == 'video'):?>
                                                <option value="" class="all">Todos</option>
                                                <?endif;?>    
                                                <option value="1">Economia/Administração</option>
                                                <option value="2">Agronomia</option>
                                            </select>                                            
                                        </td> 
                                        <td>
                                            <select class="params" id="subarea" size="5">
                                            </select>                                            
                                        </td>                                        
                                        <!--<td>                                            
                                            <select class="params" id="state" size="5">
                                                <option value="">Aguarde...</option>
                                            </select>                                            
                                        </td>-->                                
                                        <td>
                                            <select class="params" id="type_event" size="5">
                                                <option value="" class="all">Todos</option>
                                                <option value="curso">Curso</option>
                                                <option value="palestra">Palestra</option>                                                
                                                <option value="documentario">Documentário</option>
                                                <option value="reportagem">Reportagem</option>
                                                <option value="entrevista">Entrevista</option>
                                                <option value="outros">Outros</option>
                                            </select>
                                        </td>
                                        <?else:?>
                                        <td>
                                            <select class="params" id="subarea" size="5">
                                                <option value=""></option>
                                                <option value="12">Produção</option>
                                                <option value="13">Consumo</option>
                                                <option value="14">Indústria</option>
                                                <option value="15">Varejo</option>
                                            </select>                                            
                                        </td>                                        
                                        <td>
                                            <label for="beginDate">Data inicial</label>&nbsp;&nbsp;
                                            <input type="text" id="beginDate" />
                                        </td>
                                        <td>
                                            <label for="endDate">Data Final</label>&nbsp;&nbsp;
                                            <input type="text" id="endDate" /> 
                                        </td>
                                        <?endif?>
                                    </tr>
                                </tbody>
                            </table>
                            <!--<table border="1">
                                <tbody>
                                    <tr>
                                        <td>Área</td>
                                        <td>Subarea</td>
                                        <td>Estado</td>
                                    </tr>
                                </tbody>
                            </table>-->

                            <!--<select class="params" id="evento" size="5">
                                <option value=""></option>
                                <option value="1">Palestra</option>
                                <option value="2">Curso</option>
                            </select>-->                     
                        </form>
                    </div>
                    <label>Título</label>
                    <input type="text" id="title" style='width: 500px; font-size: 18px;'/>
                </div>
                <div id="search-result">
                    <div id="search-result-content">
                        <div id="wait-search" style="display: none">Aguarde...</div>
                        <div id="no-found" style="display: none"></div>
                        <table class="table-result" border="1">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>link</th>
                                    <th>Tema</th>
                                    <th>Estado</th>                                    
                                    <?if(LinkController::link() != "analysis"):?>
                                    <th>Tipo do Evento</th>
                                    <?else:?>
                                    <th>Data</th>
                                    <?endif?>
                                </tr>
                            </thead>
                            <tbody>                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?}else{    
    try{        
        $_REQUEST['no-must-online'] = true;
        include LinkController::rest();
    }catch(Exception $err){
        $json = new JsonResponse();
        print_r($json->response(false, $err->getMessage())->serialize());
    }
}
?>