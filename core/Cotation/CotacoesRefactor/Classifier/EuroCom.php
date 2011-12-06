<?php
/**
 * Description of EuroCom
 *
 * @author ramon
 */
class EuroCom extends Cotation{

    public function EuroCom(DateMap $map){
        $this->name = "Euro";
        $this->type = "Euro";
        parent::Cotation($map);
    }

    public function getMonth() {
        return date("M/y");
    }
}
?>
