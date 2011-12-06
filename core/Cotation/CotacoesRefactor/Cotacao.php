<?php
/**
 * Description of Cotacao
 * @author RAMONox
 */
class Cotacao {

    private $name;
    
    private $codigo;

    private $mounth;
    
    private $valor;

    private $diferencial;

    public function Cotacao(){
        
    }

    public function setName($name){
        $this->name = $name;
    }
    public function getName(){                
        return $this->name;
    }
    
    public function setMounth($mounth){
        $this->mounth = $mounth;
    }
    
    public function getMounth(){
        return $this->mounth;
    }

    public function getCodigo(){
        return $this->codigo;
    }

    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }
    
    public function getValor(){
        if($this->valor != null && $this->valor != ' ')
            return number_format($this->valor,2,',','.');
        return 'ND';
    }

    public function setValor($valor){
        $this->valor = $valor;
    }

    public function getDiferencial(){        
        if($this->diferencial != null && $this->diferencial != ' ')
            return number_format($this->diferencial,2,',','.');
        return 'ND';
    }

    public function setDiferencial($diferencial){
        $this->diferencial = $diferencial;
    }

    public function getImage(){
        if($this->diferencial < 0){
            return 'images/variacao-baixa.gif';
        }elseif($this->diferencial == 0){
            return 'images/variacao-neutra.gif';            
        }else{
            return 'images/variacao-alta.gif';            
        }
    }
}
?>
