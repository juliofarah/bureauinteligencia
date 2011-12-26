<?php
/**
 * Description of Conection
 *
 * @author RAMONox
 */
class Connection {

    public static function connectToTest(){
        try{
            $session = new PDO("mysql:host=localhost;
                        dbname=bureau_inteligencia_test",
                        "root",
                        "");
            $session->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $session;
        }catch(PDOException $error){
            die("Falha ao conectar no Banco de Dados: ".$error->getMessage());
        }        
    }
    
    public static function connect(){
        //require_once "DataBaseConfig.php";
        return self::doConnection();
    }
    
    public static function connectLogin(){
        //require_once 'DataBaseLoginConfig.php';
        return self::doConnection();
    }

    private static function doConnection(){
        require_once 'Databaselocal.php';       
        try{
            $session = new PDO("mysql:host=".
                        DataBaseConfig::$HOST.";
                        dbname=".DataBaseConfig::$DB_NAME,
                        DataBaseConfig::$USER,
                        DataBaseConfig::$PASSWORD);
            $session->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $session;
        }catch(PDOException $error){
            die("Falha ao conectar no Banco de Dados: ".$error->getMessage());
        }
    }
}
?>
