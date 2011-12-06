<?php

require_once 'CodeMap.php';
//require_once 'DateMap.php';

/**
 * Description of JSONBolsaDao
 * @author RAMONox
 */
class JSONBolsaDao implements BolsaDao{
    
    //private $ARQ_JSON = "core/Cotation/CotacoesRefactor/cotacoes2.json";
    private $ARQ_JSON;
    private $json;
    private $codeMap;
    private $dateMap;

    public function JSONBolsaDao(CodeMap $codeMap, DateMap $dateMap){       
        //$this->ARQ_JSON = LinkController::getBaseURL()."/core/Cotation/CotacoesRefactor/cotacoes.json";                
        $this->ARQ_JSON = "core/Cotation/CotacoesRefactor/cotacoes.json";
        $arq = file_get_contents($this->ARQ_JSON);
                
        $this->json = json_decode($arq);        
        $this->codeMap = $codeMap;
        $this->dateMap = $dateMap;      
    }

    /**
     * @return HashMap
     */
    public function getCotacoes(){
        $map = new CodeMap();
        $values = new HashMap();
        $values->put("BMF", new ArrayIterator());
        $values->put("London", new ArrayIterator());
        $values->put("NY", new ArrayIterator());
        $values->put("Dolar", new ArrayIterator());
        $values->put("Euro", new ArrayIterator());
        $values->put("Arabica", new ArrayIterator());
        $values->put("IBovespa", new ArrayIterator());

        $dateMap = new DateMap();        
        $classifier = new Classifier($dateMap);
        foreach($this->json as $cotacao){           
            $cotation = $classifier->classify($cotacao);            
            if($cotation != null){
                $cotation->setJsonInfo($cotacao);
                $values->get($cotation->type())->append($cotation);
            }
            $cot = new Cotacao();                     
        }
        return $values;
    }
}
?>
