<?  session_start(); ?>
<?  require_once 'requirements.php';?>
<?$baseUrl = LinkController::getBaseURL();?>
<?$user = new User("ramon", "raigons");?>
<?Session::login($user);?>
<!DOCTYPE html>
<html>
    <head>
        <title>Request de Table, excel e chart</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/FusionCharts.js"></script>
        <script type="text/javascript" src="<?echo $baseUrl?>/assets/js/chart_builder.js"></script>
        <script type="text/javascript">
            $(function(){
                getGroups();
                getVariety();
                getCoffeType();
                getCountry('origin');
                getCountry('destiny');
                
                getTable();
                getMultiTable();
                getChart();
                getMultiChart();
            });
                        
            //functions
            function getGroups(){                
                var data = {'type':'Groups'};                
                requestParams(data);
            }
            function getVariety(){
                requestParams({'type':'Variety'});
            }            
            function getCoffeType(){
                requestParams({'type':'CoffeType'});
            }
            function getCountry(type){
                requestParams({'type':type});
            }
            function requestParams(data, id){
                var $div = $("#"+data.type.toLowerCase());
                var url = '../datacenter/param';
                if(id != undefined)
                    data.id = id;
                else
                    data.id = null;
                $.getJSON(url, data, function(json){                    
                    $(json).each(function(i,param){                        
                        if(data.type == 'Groups')
                            requestSubgroup(param.id);
                        $div.append("id = "+param.id + "; nome: "+param.name+"<br />");
                    });
                });
            }
            function requestSubgroup(idGroup){
                var url = '../datacenter/param';
                var $div = $("#subgroup_"+idGroup);
                var data = {"type":"subgroup", "id":idGroup};
                $.getJSON(url, data, function(json){
                    $(json).each(function(i, param){
                        $div.append("id = "+param.id+" ; nome: "+param.name+"<br />");
                    })                    
                });
            }
            
            function simpleData(){
                var data = {
                    'subgrupo': 1,
                    'tipo': 1,
                    'variedade': 1,
                    'origem': 1,
                    'destino': 1,
                    'fonte': 1,
                    'ano': new Array(1989,1991)
                }
                return data;
            }
            
            function multiData(){
                var data = {
                    'subgrupo': new Array(1,2),
                    'tipo': new Array(1,2,3),
                    'variedade': new Array(1,2,3),
                    'origem': new Array(1,2,3),
                    'destino': new Array(1,2,3),
                    'fonte': new Array(1,2),
                    'ano': new Array(1989,1991)
                }
                return data;
            }
            
            function getUrl(){
                var url = new Array();
                url["table"] = 'http://localhost/BureauInteligencia/core/Datacenter/requests/buildTable.php';
                url["chart"] = 'http://localhost/BureauInteligencia/core/Datacenter/requests/buildChart.php';
                
                //testando modificação nos links
                url["chart"] = 'http://localhost/BureauInteligencia/datacenter/chart';
                url["table"] = 'http://localhost/BureauInteligencia/datacenter/table';
                return url;
            }
            
            function getTable(){
                var url = getUrl();
                var data = simpleData();
                request(data, url["table"]);
            };
            
            function getMultiTable(){
                var url = getUrl();
                var data = multiData();
                request(data,url["table"]);
            }
            
            function getChart(){
                var url = getUrl();
                var data = simpleData();
                request(data, url["chart"]);                
            };
            
            function getMultiChart(){                
                var url = getUrl();
                var data = multiData();
                data.subgrupo = 1;
                request(data,url["chart"], true);
                data.subgrupo = new Array(1,2);
                request(data,url["chart"]);
            };
            
            function request(data, url, buildChart){
                if(buildChart == undefined) buildChart = false;
                $.get(url, data, function(jsonResponse){                    
                    if(jsonResponse.tabela != undefined){
                        var json = JSON.stringify(jsonResponse.tabela);
                        $("#jsons").append(json+"<br /><br />");
                    }else{
                        if(jsonResponse.chart != undefined && buildChart){
                            var builder = ChartBuilder();                            
                            var swf = "../fusion/"+jsonResponse.typeChart;
                            //var xml = "<chart bgColor='FFFFFF'><categories><category label='1989'/><category label='1990'/><category label='1991'/></categories><dataset seriesName='Brasil-Brasil'><set value='0'/><set value='150'/><set value='200'/></dataset></chart>";
                            var xml = jsonResponse.chart;
                            builder.buildCombinationChart("chart-test", 800, 430, xml, swf);
                        }
                    }
                }, 'json');
            };
            
            /**********************************************************/
            // implement JSON.stringify serialization
            JSON.stringify = JSON.stringify || function (obj) {
                var t = typeof (obj);
                if (t != "object" || obj === null) {
                    // simple data type
                    if (t == "string") obj = '"'+obj+'"';
                    return String(obj);
                }
                else {
                    // recurse array or object
                    var n, v, json = [], arr = (obj && obj.constructor == Array);
                    for (n in obj) {
                        v = obj[n]; t = typeof(v);
                        if (t == "string") v = '"'+v+'"';
                        else if (t == "object" && v !== null) v = JSON.stringify(v);
                        json.push((arr ? "" : '"' + n + '":') + String(v));
                    }
                    return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
                }
            };            
        </script>
        <style type="text/css">
            .params{
                display: inline;
                float: left;
                border: 1px solid #CCC;
                margin-right: 5px;
                margin-bottom: 10px;
                width: 250px;
                height: auto;
                font-size: 12px;
            }
            .subgroup{
                font-size: 12px;
            }
            h4{
                margin: 0;
                margin-bottom: 10px;
            }
            h5,h6{
                margin: 5px;
            }
            #params{
                padding: 10px 0; 
                display: inline-block; 
                border: 1px solid #CCC; 
                width: 100%; height: auto;
            }
        </style>
    </head>
    <body style='margin-bottom: 20px;'>
        <div style='margin: 0 auto; margin-top: 0; width: 800px; height: auto; color: #222'>
            <h3 style="margin: 0">Params</h3>
            <div id="params">
                <div class="params" id="groups">
                    <h6>Grupos</h6>
                </div>
                <div class="params" id="variety">
                    <h6>Variedades</h6>
                </div>
                <div class="params" id="coffetype">
                    <h6>Tipos de Café</h6>
                </div>
                <div class="params" id="origin">
                    <h6>Origem</h6>
                </div>
                <div class="params" id="destiny">
                    <h6>Destino</h6>
                </div>
                <div class="params subgroup" id="subgroup_1">
                    <h6>Subgrupo Grupo 1</h6>
                </div>
                <div class="params subgroup" id="subgroup_2">                    
                    <h6>Subgrupo Grupo 2</h6>
                </div>
                <div class="params subgroup" id="subgroup_3">
                    <h6>Subgrupo Grupo 3</h6>
                </div>
                <div class="params subgroup" id="subgroup_4">
                    <h6>Subgrupo Grupo 4</h6>
                </div>
            </div>
            <h3>Jsons</h3>
            <div id="jsons" style="font-family: Helvetica; font-size: 13px; letter-spacing: 0.75px; border: 1px solid #CCC; width: 100%; min-height: 100px;">
                
            </div>
            <h3>Test chart</h3>
            <div id="chart-test" style="border: 1px solid #CCC; width: 100%; height: 450px"></div>
        </div>
    </body>
</html>
