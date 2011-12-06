<?php
require_once 'VideoController.php';
require_once 'VideoDao.php';
require_once 'Video.php';

class VideoHandler {
    
    private static $TOTAL;

    public static $CONNECT;

    public static function connect(){
        self::$CONNECT = Connection::connect();
    }
    /**
     * @param <type> $page
     * @return ArrayObject
     */
    public static function getAll($page){
        $controller = new VideoController(new VideoDao(self::$CONNECT));
        try{
            self::$TOTAL = $controller->total();
            return ($controller->getAll($page));
        }catch(PDOException $err){
            echo $err->getMessage();
        }
    }

    public static function total(){
        return self::$TOTAL;
    }
}
?>
