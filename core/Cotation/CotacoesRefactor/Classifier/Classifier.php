<?php
/**
 * Description of Classifier
 *
 * @author ramon
 */
require_once 'Cotation.php';
require_once 'BMF.php';
require_once 'NewYork.php';
require_once 'London.php';
require_once 'DolarCom.php';
require_once 'EuroCom.php';
require_once 'IBovespa.php';
require_once 'Arabica.php';
require_once 'Provider/Provider.php';
require_once 'Provider/ProvideBMF.php';
require_once 'Provider/ProvideLondon.php';
require_once 'Provider/ProvideNewYork.php';
require_once 'Provider/ProvideDolarCom.php';
require_once 'Provider/ProvideArabica.php';
require_once 'Provider/ProvideEuroCom.php';
require_once 'Provider/ProvideIBovespa.php';

class Classifier {
    /**
     * @var Map
     */
    private $types;

    /**
     * @var DateMap
     */
    private $dateMap;
       
    public function Classifier(DateMap $dateMap){
        $this->dateMap = $dateMap;
        $this->types = new HashMap();
        $this->tableOfTypes();        
    }

    private function tableOfTypes(){
        $this->types->put("IC", new ProvideBMF());
        $this->types->put("KC", new ProvideNewYork());
        $this->types->put("RC", new ProvideLondon());
        $this->types->put("CF", new ProvideArabica());
        $this->types->put("DO", new ProvideDolarCom());
        $this->types->put("EU", new ProvideEuroCom());
        $this->types->put("WI", new ProvideIBovespa());
    }
    
    /**
     *
     * @param <type> $key
     * @return Cotation
     */
    public function classify($json){   
        $key = substr($json->codigo, 0, 2);        
        $provider = $this->selectTypeOf($key);        
        if($provider != null){            
            $obj = $provider->provideObject($this->dateMap);
            if($obj instanceof Arabica){
                $obj->setName($json->codigo);
            }
            return $obj;
        }            
        return null;
    }

    /**     
     * @param <type> $key
     * @return Provider
     */
    private function selectTypeOf($key){
        if($this->types->containsKey($key))
            return $this->types->get($key);
        return null;       
    }
    
}
?>
