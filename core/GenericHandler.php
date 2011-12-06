<?php
/**
 * Description of GenericHandler
 *
 * @author RAMONox
 */
class GenericHandler {
    
    public static function explodeKeywords($keywords){
        $keys = explode(",", $keywords);
        return $keys;
    }

    public static function prevPage($page, $link_type){
        return $page - 1 > 0 ? "<a href='".LinkController::getBaseURL()."/$link_type".($page - 1)."' class='prev-page'>anterior</a>" : "";
    }

    public static function nextPage($page, $max_per_page, $total_news, $link_type){
        return $page + 1 <= ceil($total_news/$max_per_page) ? "<a href='".LinkController::getBaseURL()."/$link_type".($page + 1)."' class='next-page'>próxima</a>" : "";
    }

    public static function pages($total_news, $current, $max_per_page, $link_type){
        $max_index = 5;
        $html = self::beforeCurrent($current, $max_index, $link_type);
        $html .= "<strong class='current'>".$current."</strong>";
        $html .= self::afterCurrent($current, $max_index, $total_news, $max_per_page, $link_type);
        return $html;
    }
    
    private static function beforeCurrent($current, $max_index, $link_type){
        $html = "";

        for($i = ($current - $max_index); $i < $current; $i++){
            if($i > 0){
                $html .= "<a href='".LinkController::getBaseURL()."/".$link_type."$i'>".$i."</a>";
            }
        }
        return $html;
    }

    private static function afterCurrent($current, $max_index, $total_news, $max_per_page, $link_type){
        $html = "";
        for($i = ($current + 1); $i <= ($current + $max_index); $i++){            
            if($i <= ceil($total_news/$max_per_page)){
                $html .= "<a href='".LinkController::getBaseURL()."/$link_type$i'>".$i."</a>";
            }
        }
        return $html;
    }
}
?>
