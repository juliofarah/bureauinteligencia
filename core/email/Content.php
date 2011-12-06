<?php

/**
 * Description of Content
 *
 * @author ramon
 */
class Content {
    
    public function Content(){
        
    }
    
    public function getContentNewPassword(){
        $html = "<div>
                    Olá :name, você solicitou uma nova senha no Bureau de Inteligência. <br />
                    Sua nova senha é <strong>:pass</strong>
                 </div>
                 <div>
                     http://www.agrocim.com.br/BureauInteligencia
                 </div>";
        return $html;
    }   
    
    public function getNoHtmlContentNewPassword(){
        return "Olá :name, você solicitou uma nova senha no Bureau de Inteligência.
            Sua nova senha é <strong>:pass</strong>.
            Acesse: http://www.agrocim.com.br/BureauInteligencia";
    }
    
    public function getAnalysisContent(Analyse $analysis, $nameFrom){
        $html = "<div>";
        $html .= "<span>Olá! $nameFrom enviou uma Análise para você do Bureau Inteligencia!</span>";
        $html .=    "<div style='display: inline-block; border: 1px solid #710E0E; border-top-width: 3px; border-left: 0; border-right: 0; width: 95%; height: auto; margin-bottom: 15px; margin-top: 15px; padding: 5px 0;'>";
        $html .=        "<div style='width: 132px; height: 132px; float: left;'>";
        $html .=            "<img src='".LinkController::getBaseURL()."/images/bg-logo.gif'/>";
        //$html .=            "<div style='z-index: 1000; position: absolute;'>";
        //$html .=                $this->objectFlash();
        //$html .=            "</div>";
        $html .=        "</div>";
        $html .=        "<a style='float: left; margin-left: 10px; margin-top: 35px; border: 0' href='".LinkController::getBaseURL()."'>";
        $html .=            "<img style='border: 0;' src='".LinkController::getBaseURL()."/images/escrito-bureau.gif'/>";
        $html .=        "</a>";
        $html .=    "</div>";
        $html .=    "<div style='color: #333333;'>";
        $html .=        "<h1 style='text-align: center; margin: 0; padding: 0; font-size: 28.5px; font-weight: bold; letter-spacing: -1px'>".$analysis->title()."</h1>";
        $html .=        "<br />";
        //$html .=        "<div style='font-weight: normal; font-size: 13px; letter-spacing: -0.3px; line-height: 30px; text-align: left;'>";        
        //$html .=                $analysis->text();
        //$html .=        "</div>";
        $html .=        "<div style='width: 90%; margin: 5px auto; padding: 5px; background-color: #EEEEEE;'>";
        $html .=            "<a href='".LinkController::getBaseURL()."/analise/".$analysis->link().".html' style='font-size: 16px; font-weight: bold; color: #710E0E !important;'>".LinkController::getBaseURL()."/analise/".$analysis->link().".html</a>";
        $html .=        "</div>";
        $html .=    "</div>";                
        $html .= "</div>";
        return $html;
    }
    
    private function objectFlash(){
       $object = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="110" height="110" align="middle">
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="allowFullScreen" value="false" />
            <param name="movie" value="'.LinkController::getBaseURL().'/images/logo.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <param name="bgcolor" value="#990000" />
            <embed src="'.LinkController::getBaseURL().'/images/logo.swf" quality="high" wmode="transparent" bgcolor="#990000" width="110" height="110" name="logo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
        </object>';
       $object = str_replace("\"", "'", $object);
       return $object;
    }
    
}

?>
