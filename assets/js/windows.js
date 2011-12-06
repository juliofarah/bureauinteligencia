Window = {
    New: function(width, height, position){
        return new this.newWindow(width, height, position);
    },
    newWindow: function(width,height,position){
        var w, h, p;
        w = (width != undefined ? width : 500);
        h = (height != undefined ? height: "auto");
        p = (position != undefined ? position : "center");

        this.renderSuccess = function(){
            this.render(imageSuccess(), true);
        }
        
        this.renderFailure = function(){
            this.render(imageFailure());
        }

        this.renderAlert = function(){
            this.render(imageAlert());
        }
        
        this.render = function($img, refresh){
            $(this.divName).dialog({
                modal: true,
                resizable: false,
                height: h,
                width: w,
                position: p,
                title: this.title,
                buttons: {
                    Ok: function(){
                        $(this).dialog("close");
                    }
                },
                close: function(){
                    if(refresh != undefined && refresh == true){
                        location.href = location.href;
                    }
                }
            });            
            var $imgResponse = $(this.divName).children(".dialog-content").children("#image-response");
            $imgResponse.html("<span><img src='"+$img.attr('src')+"'/></span>");
            $("#message-dialog-content").empty().append(this.content);
            $(this.divName).dialog("open");
        }

        this.renderQuestion = function(id, url, publisher){
            $(this.divName).dialog({
                modal:true,
                resizable: false,
                height: h,
                width: w,
                position: p,
                title: this.title,
                buttons:{
                    'Sim':function(){
                        $(this).dialog('close');
                        //var request = Ajax_Requests.New();
                        //request.deleteUser(url, id);
                        //request.toDelete(url, id, publisher);
                    },
                    'Não':function(){
                        $(this).dialog('close');
                    }
                }
            });
            var $imageResponse = $(this.divName).children(".dialog-content").children("#image-response");
            $imageResponse.html("<span><img src='"+imageQuestion().attr('src')+"'/></span>");
            $("#message-dialog-content").empty().append(this.content);
            $(this.divName).dialog("open");
        }

        this.renderDialogWithForm = function(){
            $(this.divName).dialog({
                modal: false,
                resizable: false,
                height: h,
                width: w,
                position: p,
                title: this.title,
                close: function(event, ui){
                    
                }//,
                /*buttons:{
                    Ok: function(){
                        $(this).dialog('close');
                    }
                }*/
            });
            $(this.divName).dialog("open");
        }
        
        this.renderSimpleDialogForChartOfQuotation = function (request, id, div_of_chart, id_div_chart, url){            
            $(this.divName).dialog({
                modal: false,
                resizable: false,
                height: h, 
                width: w, 
                position: p,
                title: this.title
            });            
            $(this.divName).empty();
            $(this.divName).append(this.content).append(div_of_chart);
            $(this.divName).dialog('open');            
            var data = {
                'no-must-online':true, 
                'quotation': id
            };
            request.getLineXMLOfOneCotation(url, data, id_div_chart.replace("#", ""), id);
        }
                
        /***another atts***/
        this.divName = function(div){
            return div ? divName = div : divName;
        }

        this.title = function (t){
            return t ? title = t : title;
        }

        this.content = function(cnt){
            return cnt ? content = cnt : content;
        }

        /**functions**/
        var imageSuccess = function(){
            return $("div#success img");
        }
        var imageFailure = function(){
            return $("div#failure img");
        }
        var imageAlert = function(){
            return $('div#alert img');
        }
        var imageQuestion = function(){
            return $('div#question img');
        }

    }
}

