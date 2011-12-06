var WindowProccessResults = function(){
    
    var api = {};
    
    var urlSite = 'http://www.icafebr.com.br';
    
    api.showVideoSearch = function(){
        var video = {};
        
        video.showResults = function(results, $appendTo){
            $appendTo.children("table.table-result").children("tbody").empty();
            var html = "";
            $(results).each(function(i, obj){
               html += "<tr>";
               html += "<td>" + obj.title +"</td>";
               html += "<td><a target='_blank' href='http://www.youtube.com/watch?v="+ obj.link +"'>";
               html += "Assistir este video no youtube</a></td>";
               html += "<td>" + obj.subarea.name + "</td>";
               html += "<td>" + obj.state.UF + "</td>";
               html += "<td>" + api.translateType(obj.event) + "</td>";
               html += "</tr>";
            });            
            $appendTo.children("table.table-result").children("tbody").
                append(html)
        }
        return video;
    }

    api.showPaperSeach = function(){
        var publication = {};

        publication.showResults = function(results, $appendTo){
            //$appendTo.empty();

            $appendTo.children("table.table-result").children("tbody").empty();
            
            var html = "";
            $(results).each(function(i, obj){
               html += "<tr>";
               html += "<td>" + obj.title + "</td>";
               html += "<td><a href='"+urlSite+"/publicacao/"+obj.file.simplename+"'>" + obj.file.simplename + "</a></td>";
               html += "<td>" + obj.subarea.name +"</td>";
               html += "<td>" + obj.state.UF + "</td>";
               html += "<td>" + api.translateType(obj.event) + "</td>";
               html += "</tr>";
            });            
            $appendTo.children("table.table-result").children("tbody").
                append(html)
        }
        return publication;
    }

    api.showAnalysisSearch = function(){
        var publication = {};
        
        publication.showResults = function(results, $appendTo){
            $appendTo.children("table.table-result").children("tbody").empty();            
            var html = "";
            $(results).each(function(i, obj){
               html += "<tr>";
               html += "<td>" + obj.title + "</td>";
               html += "<td><a target='_blank' href='"+urlSite+"/analise/"+obj.link+".html'>Ler análise</a></td>";
               html += "<td>" + obj.subarea.name +"</td>";
               html += "<td>" + obj.state.UF + "</td>";
               html += "<td>" + obj.date + "</td>";
               html += "</tr>";
            });            
            $appendTo.children("table.table-result").children("tbody").
                append(html)                       
        }
        
        return publication;
    }
    
    api.translateType = function(type){            
        var events = new Array();
        events['curso'] = "Curso";
        events['palestra'] = "Palestra";
        events["documentario"] = "Documentário";
        events["reportagem"] = "Reportagem";
        events["entrevista"] = "Entrevista";
        events["outros"] = "Outros";        
        events[undefined] = " - ";
        
        return events[type];
    }
    return api;
}

