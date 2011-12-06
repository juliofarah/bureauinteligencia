<?php
/**
 * Description of RequestsPatterns
 *
 * @author RAMONox
 */
class RequestsPatterns {

    public static $ID = 'id';
    
    public static $LINK = "link";

    public static $TITLE = "title";

    
    public static function postParamsSetted(){
        $all_setted = true;
        $numberOfParams = func_num_args();
        for ($i = 0; $i < $numberOfParams; $i++){            
            $all_setted = $all_setted && isset ($_POST[func_get_arg($i)]);
        }
        return $all_setted;
    }

    public static function postParamsSent(){
        $all_sent = true;
        $numberOfParams = func_num_args();
        for ($i = 0; $i < $numberOfParams; $i++){
            $all_sent = $all_sent && !empty ($_POST[func_get_arg($i)]);
        }
        return $all_sent;
    }

    public static function getParamsSetted(){
        $all_setted = true;
        $numberOfParams = func_num_args();
        for($i = 0; $i < $numberOfParams; $i++){
            $all_setted = $all_setted && isset ($_GET[func_get_arg($i)]);
        }
        return $all_setted;
    }
}
?>
