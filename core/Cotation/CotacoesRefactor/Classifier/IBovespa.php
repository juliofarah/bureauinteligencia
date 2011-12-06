<?php
/**
 * Description of IBovespa
 *
 * @author ramon
 */
class IBovespa extends Cotation {
    
    public function IBovespa(DateMap $map){
        $this->name = "IBovespa";
        $this->type = "IBovespa";
        parent::Cotation($map);
    }

    public function getMonth() {
        return date("M/y");
    }
}
?>
