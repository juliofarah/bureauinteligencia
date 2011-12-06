<?php
/**
 * Description of Cotation
 *
 * @author ramon
 */
abstract class Cotation {

    /**
     * @var array
     * Its atts are publics and are:
     * codigo
     *  max
     *  min
     *  diff
     *  abertura
     *  fechamento
     *  valor
     *  CAberto
     *  data
     */
    protected $jsonInfo;

    protected $name;

    protected $type;
    
    protected $date;
    
    /**     
     * @var DateMap 
     */
    protected $dateMap;

    public function Cotation(DateMap $map){
        $this->dateMap = $map;
    }

    public function setJsonInfo($jsonInfo){
        $this->jsonInfo = $jsonInfo;
    }

    public function getCode(){
        return $this->jsonInfo->codigo;
    }
    
    public function getMax(){
        return $this->jsonInfo->max;
    }

    public function getMin(){
        return $this->jsonInfo->min;
    }

    public function getDiff(){
        return number_format($this->jsonInfo->diff, 2);
    }

    public function getOpen(){
        return $this->jsonInfo->abertura;
    }

    public function getClose(){
        return $this->jsonInfo->fechamento;
    }

    public function getLast(){
        return $this->jsonInfo->valor;
    }

    public function openContracts(){
        return $this->jsonInfo->CAberto;
    }
    
    public function getName(){
        return $this->name;
    }

    public function type(){
        return $this->type;
    }
        
    public function getDate(){
        return $this->jsonInfo->data;
    }

    public function getImage(){
        if($this->getDiff() < 0){
            return 'cot_imgs/variacao-baixa.gif';
        }elseif($this->getDiff() == 0){
            return 'cot_imgs/variacao-neutra.gif';
        }else{
            return 'cot_imgs/variacao-alta.gif';
        }
    }
    
    public function toArray(){
        $array = array('codigo' => $this->getCode(),
            'max' => $this->getMax(), 
            'min' => $this->getMin(),
            'diff'=> $this->getDiff(),
            'abertura' => $this->getOpen(),
            'fechamento'=> $this->getClose(),            
            'CAberto' => $this->openContracts(),
            );
        return $array;
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
    
    public abstract function getMonth();
    
    public function hasValidValues(){
        return ($this->getMax() != 0 && $this->getMin() != 0 && $this->getOpen() != 0);
    }

}
?>
