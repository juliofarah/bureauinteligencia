<?php
/**
 * Description of NewsHandler
 *
 * @author RAMONox
 */
class NewsHandler {

    private static $TOTAL;

    /**
     * @var ArrayObject
     */
    private static $News;

    public static function getAll($page){
        $controller = new NewsController(new NewsDao(Connection::connect()));
        try{
            self::$TOTAL = $controller->total();
            self::$News = $controller->getAll($page);
            return self::$News;
        }catch(PDOException $err){
            echo $err->getMessage();
        }
    }

    public static function hasNews(){
        return self::$News != null && self::$News->count() > 0;
    }
    
    /**     
     * @return ArrayObject 
     */
    public static function news(){
        return self::$News;
    }

    public static function total(){
        return self::$TOTAL;
    }
}
?>
