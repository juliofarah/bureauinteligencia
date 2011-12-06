$.fn.imageLoad = function(fn){ 
    this.load(fn); 
    this.each( function() { 
        if ( this.complete && this.naturalWidth !== 0 ) { 
            $(this).trigger('load'); 
        } 
    }); 
}

