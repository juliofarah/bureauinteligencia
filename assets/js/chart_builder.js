var ChartBuilder = function(){
    
    var api = {};

    var div;

    var width;

    var height;

    var xml;
    
    api.buildMultiColumn = function(div_id, w, h, xml_content){
        configParams(div_id, w, h, xml_content);
        
        var swf = "fusion/MSColumn3D.swf";
        buildChart(swf);
    }

    api.buildSimpleLine = function(div_id, w, h, xml_content){
        configParams(div_id, w, h, xml_content);
        var swf = "fusion/Line.swf";
        buildChart(swf);
    }

    api.buildChandleChart = function(div_id, w, h, xml_content){
        configParams(div_id, w, h, xml_content);
        var swf = "fusion/CandleStick.swf";        
        buildChart(swf);
    }
    
    var configParams = function(div_id, w, h, xml_content){
        div = div_id;
        width = w;
        height = h;
        xml = xml_content;        
    }
    
    var buildChart = function(swf){
         var chart = new FusionCharts(swf, "ChartID", width, height, "0", "0");
        chart.setDataXML(xml);
        chart.render(div);
    }
    
    return api;
}