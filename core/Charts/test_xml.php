<html>
    <head>
        <script type="text/javascript" src="http://localhost/bureau_perfil/assets/js/FusionCharts.js"></script>
        <script type="text/javascript" src="http://localhost/bureau_perfil/assets/js/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var fusion = new FusionCharts("http://localhost/bureau_perfil/fusion/MSColumn3D.swf","ChartId", "500", "350", "0", "0");
                fusion.setDataURL('arq.xml');
                //fusion.setDataXML("<chart bgColor='FFFFFF'><categories><category label='Caf&#xE9; Londres Mai/11'/><category label='Caf&#xE9; Londres Jul/11'/><category label='Caf&#xE9; Londres Set/11'/><category label='Caf&#xE9; Londres Nov/11'/></categories><dataset seriesName='ULT'><set value='2.475'/><set value='2.473'/><set value='2.498'/><set value='2.500'/></dataset><dataset seriesName='CAberto'><set value='53.166'/><set value='78.146'/><set value='22.828'/><set value='9.363'/></dataset></chart>");
                fusion.render("chart");
            });
        </script>
    </head>
    <body>
        <div id="chart" style="border: 2px solid black">

        </div>
    </body>
</html>
<?php
    ini_set('display_errors', '1');

    require_once '../Link/LinkController.php';
    require_once '../../util/Maps/HashMap.php';
    require_once 'XmlCharts/XmlChart.php';
    require_once 'XmlCharts/MultiSerie/XmlMultiSeries.php';
    require_once 'XmlCharts/MultiSerie/XmlMultiSerieColumn.php';
    require_once 'Configs/MultiSeriesConfig.php';
    require_once 'Configs/MultiSeriesColumnConfig.php';
    require_once '../Cotation/CotacoesRefactor/HtmlLib.php';
    $allCots = HtmlLib::cotacoes();
    
    $config = new MultiSeriesColumnConfig();

    $bmf = $allCots->get("BMF");
        
    $config->config($bmf);
    $config->config($allCots->get("NY"));
    $config->config($allCots->get("London"));
    $config->getChartXml()->buildXml();
?>
