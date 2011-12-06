<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    
    require_once '../../../DataBase/Connection.php';
    require_once '../../../../util/Maps/HashMap.php';
    require_once '../../../Link/LinkController.php';
    
    require_once '../HtmlLib.php';
    require_once 'StorageDao.php';
    
    $allCots = HtmlLib::cotacoes();
    $types = array("BMF", "NY", "London", 'Arabica','Dolar', 'Euro', 'IBovespa');
        
    $storage = new StorageDao(Connection::connect());
       
    foreach($types as $val){        
        if($allCots->containsKey($val)){
            $cots = ($allCots->get($val));
            foreach($cots as $cot){
                $cotation = turnItToObj($cot);
                try{
                    if($cotation->hasValidValues())
                        echo $storage->saveFuturas($cotation);       
                    else
                        echo 'Não foi possível salvar os valores de '.$cotation->getCode();
                }catch(PDOException $err){
                    echo $err->getMessage().'<br />';
                }catch(Exception $err){
                    echo $err->getMessage().'<br />';
                }                
            }            
        }
    }
    
?>
<?
/**
 *
 * @param type $current
 * @return Cotation 
 */
function turnItToObj($current){
    return $current;
}
?>